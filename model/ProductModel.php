<?php
require_once "DataHandler.php";

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
     * @access public
     */
    public $dataHandler;

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
     * @param string $price the price of the product
     * @param string $description the description of the product
     * @param string (optional) $resolution_width the resolution width of the product
     * @param string (optional) $resolution_height the resolution height of the product
     * @param string (optional) $refresh_rate the refresh_rate of the product
     * @param string (optional) $fov the fov of the product
     * @param string (optional) $inputs the inputs of the product
     * @param string (optional) $accessories the accessories of the product
     * @param string (optional) $accelerometer the accelerometer of the product
     * @param string (optional) $camera the camera of the product
     * @param string (optional) $gyroscope the gyroscope of the product
     * @param string (optional) $adjusable_lenses the adjusable_lenses of the product
     * @param string (optional) $color the color of the product
     * @param string (optional) $platform the platform of the product
     * @param string (optional) $discount the discount of the product
     * 
     * @return string $EAN product EAN
     */
    public function createProduct(string $EAN,
                                  string $name,
                                  string $brand,
                                  $price,
                                  string $description,
                                  string $resolution_width = null,
                                  string $resolution_height = null,
                                  $refresh_rate = null,
                                  $fov = null,
                                  string $inputs = null,
                                  string $accessories = null,
                                  $accelerometer = null,
                                  $camera = null,
                                  $gyroscope = null,
                                  $adjustable_lenses = null,
                                  string $color = null,
                                  string $platform = null,
                                  $discount = null) {

        $EAN = filter_var($EAN, FILTER_SANITIZE_STRING);
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $brand = filter_var($brand, FILTER_SANITIZE_STRING);
        $price = floatval(filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT));
        $description = filter_var($description, FILTER_SANITIZE_STRING);
        $discount = floatval(filter_var($discount, FILTER_SANITIZE_NUMBER_FLOAT));
        $resolution =  filter_var($resolution_width."x".$resolution_height, FILTER_SANITIZE_STRING);
        $refresh_rate = intval(filter_var($refresh_rate, FILTER_SANITIZE_NUMBER_INT));
        $fov = intval(filter_var($fov, FILTER_SANITIZE_NUMBER_INT));
        $inputs = filter_var($inputs, FILTER_SANITIZE_STRING);
        $accessories = filter_var($accessories, FILTER_SANITIZE_STRING);
        $color = filter_var($color, FILTER_SANITIZE_STRING);
        $platform = filter_var($platform, FILTER_SANITIZE_STRING);

        $accelerometer = isset($accelerometer);
        $camera = isset($camera);
        $gyroscope = isset($gyroscope);
        $adjustable_lenses = isset($adjustable_lenses);


        if($discount == 0) {
            $discount = null;
        }
        if($refresh_rate == 0) {
            $refresh_rate = null;
        }
        if($fov == 0) {
            $fov = null;
        }
        if(!$resolution_width && !$resolution_height) {
            $resolution = null;
        }
        
        return $this->dataHandler->createData(
            "INSERT INTO `product`(`EAN`, `naam`, `merk`, `prijs`, `beschrijving`, `resolutie`, `refresh rate`, `gezichtsveld`, `aansluitingen`, `accessoires`, `accelerometer`, `camera`, `gyroscoop`, `verstelbare lenzen`, `kleur`, `platform`, `korting`)
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
     * reads multiple products and gets one image with the product
     *
     * @param int $pagination the amount of products you want to read per page, pagination works with the page get variable
     * @return array a 2d array with all the products
     */
    public function readProductsOneImage(int $pagination) {
        return $this->dataHandler->readData(
            "SELECT * FROM `product` LEFT JOIN `image` ON `product`.`EAN` = `image`.`product_EAN` GROUP BY `product`.`EAN`",
            [],
            true,
            $pagination
        );
    }

    /**
     * searches multiple products and gets one image with the product
     *
     * @param string $query what to search for
     * @param int $pagination the amount of products you want to read per page, pagination works with the page get variable
     * @return array a 2d array with all the products
     */
    public function searchProductsOneImage(string $query, int $pagination) {
        return $this->dataHandler->readData(
            "SELECT * FROM `product` LEFT JOIN `image` ON `product`.`EAN` = `image`.`product_EAN` WHERE `product`.`ean` LIKE :q OR `product`.`beschrijving` LIKE :q OR `product`.`naam` LIKE :q OR `product`.`merk` LIKE :q GROUP BY `product`.`EAN`",
            [":q" => "%$query%"],
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

    /**
     * adds a checkmark to the product
     *
     * @param array $product the product you want to add checkmarks on
     * @return array the finished product
     */
    public function addCheckmark(array $product) {
        foreach(["accelerometer", "camera", "gyroscoop", "verstelbare lenzen"] as $value) {

            $class = $product[$value] == 1 ? "far fa-check-circle text-success" : "far fa-times-circle text-danger";
            $product[$value] = "<i class=\"$class\"></i>";
        }

        return $product;
    }

    /**
     * adds a degree symbol to the product
     *
     * @param array $product the product you want to add degree symbols on
     * @return array the finished product
     */
    public function addDegreeSymbol(array $product) {

        if(!isset($product["gezichtsveld"]))
            return $product;

        $product["gezichtsveld"] = $product["gezichtsveld"] . "°";

        return $product;
    }

    /**
     * adds a hz symbol to the product
     *
     * @param array $product the product you want to add hz symbols on
     * @return array the finished product
     */
    public function addHz(array $product) {

        if(!isset($product["refresh rate"]))
            return $product;

        $product["refresh rate"] = $product["refresh rate"] . "Hz";

        return $product;
    }

    /**
     * adds a euro symbol to the product
     *
     * @param array $product the product you want to add euro symbols on
     * @return array the finished product
     */
    public function addEuro(array $product) {

        if(!isset($product["prijs"]))
            return $product;

        $product["prijs"] = "€ ". $product["prijs"];
        
        if(isset($product["korting"]))
            $product["korting"] = "€ ". $product["korting"];

        return $product;
    }

}