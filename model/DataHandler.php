<?php

class DataHandler {

    public $pdo;

    public $lastSelect = [];

    public $host;
    public $database;
    public $username;
    public $password;
    public $dbtype;

    public function __construct($host, $database, $username, $password, $dbtype = "mysql") {
        try {
            $this->pdo = new PDO("$dbtype:host=$host;dbname=$database", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch(PDOexeption $e) {
            $this->showError("Error: " . $e->getMessage());
        }

        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->dbtype = $dbtype;
    }

    public function createData($sql, $bindings = []) {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($bindings);
        return $this->pdo->lastInsertId();
    }

    public function readData(string $sql, array $bindings = [], bool $multiple = true, int $pagination = 0) {

        $sql = $sql
                . ($pagination ? " LIMIT $pagination OFFSET " . (intval(($_REQUEST["page"] ?? 0)) * $pagination ?? 0) : "");

        $sth = $this->pdo->prepare($sql);
        $sth->execute($bindings);

        $this->lastSelect = compact("bindings", "sql");

        if($multiple) {
            return $sth->fetchAll();
        } else {
            return $sth->fetch();
        }
        
    }

    public function updateData(string $sql, array $bindings = []) {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($bindings);
        return $this->pdo->lastInsertId();        
    }

    public function deleteData(string $sql, array $bindings = []) {
        $sth = $this->pdo->prepare($sql);
        return $sth->execute($bindings);
    }

    public function exportToCSV(array $data) {

        function addQuotes($val) {
            return "\"$val\"";
        }

        $csv = "";
        foreach ($data as $value) {
            $csv .= implode(", ", array_map("addQuotes", array_keys($value))) . "\r\n";
            break;
        }

        foreach ($data as $value) {
            $csv .= implode(", ", array_map("addQuotes", array_values($value))) . "\r\n";
        }

        echo $csv;
    }

    public function pagination(int $pagination) {

        // remove "body" from select prev query
        $sql = preg_split("/(?s)(?<=SELECT).*?(?=FROM)/", $this->lastSelect["sql"]);
        // shuffle
        $sql[2] = $sql[1];
        // add count
        $sql[1] = "COUNT(*) AS count";
        // implode
        $sql = implode($sql, " ");

        $sql = preg_replace("/LIMIT [0-9]+ OFFSET [0-9]+/", "", $sql);
                
        $count =  $this->readData(
            $sql,
            $this->lastSelect["bindings"],
            false
        )["count"];

        return ceil($count / $pagination);

    }

    public function showError(string $error) {
        echo $error;
    }

}
