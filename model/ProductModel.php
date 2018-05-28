<?php
require "DataHandler.php";


/**
 * The model of product
 * 
 * @category   Model
 * @author     Leon in 't Veld <leon3110l@gmail.com>
 * @author     Amin Zammou
 */
class ProductModel {


    /**
     * @var DataHandler
     * @access private
     */
    private $dataHandler;

    /**
     * 
     */
    public function __construct() {
        $this->dataHandler = new DataHandler($_ENV["DB_HOST"], $_ENV["DB_DATABASE"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
    }

    public function createProduct() {
        return $this->dataHandler->createProducts(
            "INSERT INTO `product`() VALUES ()",
            []
        );
    }

    public function readProducts($pagination = false) {
        return $this->dataHandler->readData(
            "SELECT * FROM `product`",
            [],
            true,
            $pagination
        );
    }
    
    public function readProduct($id) {
        return $this->dataHandler->readData(
            "SELECT * FROM `product` WHERE id = :id",
            [":id" => $id],
            false,
            false
        );
    }

}