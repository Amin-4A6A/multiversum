<?php
require "DataHandler.php";


/**
 * The model of product
 * 
 * @category   Model
 * @author     Leon in 't Veld <leon3110l@gmail.com>
 * @author     Amin Zammou <aminzammou@hotmail.com>
 */
class ProductModel {


    /**
     * @var DataHandler
     * @access private
     */
    private $dataHandler;

    /**
     * creates a new ProductModel
     */
    public function __construct() {
        $this->dataHandler = new DataHandler($_ENV["DB_HOST"], $_ENV["DB_DATABASE"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
    }

    /**
     * @param string $EAN the EAN of the product
     * @param string $name the name of the product
     * @param string $brand the brand of the product
     * @param float $price the price of the product
     * @param string $description the description of the product
     * @param string (optional) $resolution the resolution of the product
     * @param int (optional) $refresh_rate the refresh_rate of the product
     * @param int (optional) $fov the fov of the product
     * @param string (optional) $inputs the inputs of the product
     * @param string (optional) $accessories the accessories of the product
     * @param bool (optional) $accelerometer the accelerometer of the product
     * @param bool (optional) $camera the camera of the product
     * @param bool (optional) $gyroscope the gyroscope of the product
     * @param bool (optional) $adjusable_lenses the adjusable_lenses of the product
     * @param string (optional) $color the color of the product
     * @param string (optional) $platform the platform of the product
     * @param float (optional) $discount the discount of the product
     * 
     * @return string $EAN product EAN
     */
    public function createProduct(string $EAN,
                                  string $name,
                                  string $brand,
                                  float $price,
                                  string $description,
                                  string $resolution = null,
                                  int $refresh_rate = null,
                                  int $fov = null,
                                  string $inputs = null,
                                  string $accessories = null,
                                  bool $accelerometer = null,
                                  bool $camera = null,
                                  bool $gyroscope = null,
                                  bool $adjusable_lenses = null,
                                  string $color = null,
                                  string $platform = null,
                                  float $discount = null) {
        return $this->dataHandler->createProducts(
            "INSERT INTO `product`(`EAN`, `name`, `brand`, `price`, `description`, `resolution`, `refresh_rate`, `fov`, `inputs`, `accessories`, `accelerometer`, `camera`, `gyroscope`, `adjustable_lenses`, `color`, `platform`, `discount`)
                           VALUES (:EAN, :name, :brand, :price, :description, :resolution, :refresh_rate, :fov, :inputs, :accessories, :accelerometer, :camera, :gyroscope, :adjustable_lenses, :color, :platform, :discount)",
            [
                ":EAN" => $EAN,
                ":name" => $name,
                ":brand" => $brand,
                ":price" => $price,
                ":description" => $description,
                ":resolution" => $resolution,
                ":refresh_rate" => $refresh_rate,
                ":fov" => $fov,
                ":inputs" => $inputs,
                ":accessories" => $accessories,
                ":accelerometer" => $accelerometer,
                ":camera" => $camera,
                ":gyroscope" => $gyroscope,
                ":adjustable_lenses" => $adjustable_lenses,
                ":color" => $color,
                ":platform" => $platform,
                ":discount" => $discount
            ]
        );
    }

    /**
     * reads multiple products from the database with optional pagination
     * @param int (optional) $pagination the amount of products you want to read per page, pagination works with the page get variable
     * @return array a 2d array with all the products
     */
    public function readProducts($pagination = 0) {
        return $this->dataHandler->readData(
            "SELECT * FROM `product`",
            [],
            true,
            $pagination
        );
    }
    
    /**
     * reads one product from the database
     * @param string $EAN the EAN code of the product
     * @return array an array with the product info
     */
    public function readProduct(string $EAN) {
        return $this->dataHandler->readData(
            "SELECT * FROM `product` WHERE EAN = :EAN",
            [":EAN" => $EAN],
            false,
            false
        );
    }

    /**
     * returns the describe data from the table
     *
     * @return array an array with the table info
     */
    public function describeTable() {
        return $this->dataHandler->readData(
            "DESCRIBE `product`"
        );
    }

}