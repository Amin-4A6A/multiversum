<?php
require_once "DataHandler.php";

/**
 * The model of adres
 * 
 * @category   Model
 * @author     Leon in 't Veld <leon3110l@gmail.com>
 * @author     Amin Zammou <aminzammou@hotmail.com>
 */
class AdresModel {

    /**
     * @var DataHandler
     * @access public
     */
    public $dataHandler;

    /**
     * creates a new AdresModel
     */
    public function __construct() {
        $this->dataHandler = new DataHandler($_ENV["DB_HOST"], $_ENV["DB_DATABASE"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
    }

    /**
     * creates an adres in the database
     *
     * @param string $straat
     * @param string $huisnummer
     * @param string $toevoeging
     * @param string $postcode
     * @param string $land
     * @param string $stad
     * @param string $voornaam
     * @param string $tussenvoegsel
     * @param string $achternaam
     * @param string $geslacht
     * @return int adres id
     */
    public function createAdres(
        $straat,
        $huisnummer,
        $toevoeging,
        $postcode,
        $land,
        $stad,
        $voornaam,
        $tussenvoegsel,
        $achternaam,
        $geslacht
    ) {

        $straat = filter_var($straat, FILTER_SANITIZE_STRING);
        $huisnummer = intval(filter_var($huisnummer, FILTER_SANITIZE_NUMBER_INT));
        $toevoeging = filter_var($toevoeging, FILTER_SANITIZE_STRING);
        $postcode = filter_var($postcode, FILTER_SANITIZE_STRING);
        $land = filter_var($land, FILTER_SANITIZE_STRING);
        $stad = filter_var($stad, FILTER_SANITIZE_STRING);
        $voornaam = filter_var($voornaam, FILTER_SANITIZE_STRING);
        $tussenvoegsel = filter_var($tussenvoegsel, FILTER_SANITIZE_STRING);
        $achternaam = filter_var($achternaam, FILTER_SANITIZE_STRING);
        $geslacht = filter_var($geslacht, FILTER_SANITIZE_STRING);

        if($geslacht == "m") {
            $geslacht = 1;
        } else {
            $geslacht = 0;
        }

        return $this->dataHandler->createData(
            "INSERT INTO `adres`(`straat`, `huisnummer`, `toevoeging`, `postcode`, `land`, `stad`, `voornaam`, `tussenvoegsel`, `achternaam`, `geslacht`) VALUES (:straat, :huisnummer, :toevoeging, :postcode, :land, :stad, :voornaam, :tussenvoegsel, :achternaam, :geslacht)",
            [
                ":straat" => $straat,
                ":huisnummer" => $huisnummer,
                ":toevoeging" => $toevoeging,
                ":postcode" => $postcode,
                ":land" => $land,
                ":stad" => $stad,
                ":voornaam" => $voornaam,
                ":tussenvoegsel" => $tussenvoegsel,
                ":achternaam" => $achternaam,
                ":geslacht" => $geslacht
            ]
        );
    }

}