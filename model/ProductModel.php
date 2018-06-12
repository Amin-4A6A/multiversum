<?php
require_once "DataHandler.php";
require_once "ArrayHelper.php";
require_once "HTMLElements.php";

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
     * @param string $old_EAN the old EAN of the product
     * @param string $new_EAN the new EAN of the product
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
     * @return void
     */
    public function updateProduct(
        string $old_EAN,
        string $new_EAN,
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
        $magnetometer = null,
        $koptelefoon = null,
        $microfoon = null,
        string $color = null,
        string $platform = null,
        $discount = null
    ) {

        extract($this->sanitizeProductInput(get_defined_vars()));

        return $this->dataHandler->updateData(
            "UPDATE `product` SET `EAN` = :new_EAN, `naam` = :name, `merk` = :brand, `prijs` = :price, `beschrijving` = :description, `resolutie` = :resolution, `refresh rate` = :refresh_rate, `gezichtsveld` = :fov, `aansluitingen` = :inputs, `accessoires` = :accessories, `accelerometer` = :accelerometer, `camera` = :camera, `gyroscoop` = :gyroscope, `verstelbare lenzen` = :adjustable_lenses, `magnetometer` = :magnetometer, `koptelefoon` = :koptelefoon, `microfoon` = :microfoon, `kleur` = :color, `platform` = :platform, `korting` = :discount WHERE `product`.`EAN` = :old_EAN",
            [
                ":old_EAN" => $old_EAN,
                ":new_EAN" => $new_EAN,
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
                ":magnetometer" => $magnetometer,
                ":koptelefoon" => $koptelefoon,
                ":microfoon" => $microfoon,
                ":color" => $color,
                ":platform" => $platform,
                ":discount" => $discount
            ]
        );

    }

    public function sanitizeProductInput(array $inputs) {

        $inputs["EAN"] = filter_var(($inputs["EAN"] ?? ""), FILTER_SANITIZE_STRING);
        $inputs["old_EAN"] = filter_var(($inputs["old_EAN"] ?? ""), FILTER_SANITIZE_STRING);
        $inputs["new_EAN"] = filter_var(($inputs["new_EAN"] ?? ""), FILTER_SANITIZE_STRING);
        $inputs["name"] = filter_var($inputs["name"], FILTER_SANITIZE_STRING);
        $inputs["brand"] = filter_var($inputs["brand"], FILTER_SANITIZE_STRING);
        $inputs["price"] = floatval(filter_var($inputs["price"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $inputs["description"] = filter_var($inputs["description"], FILTER_SANITIZE_STRING);
        $inputs["discount"] = floatval(filter_var($inputs["discount"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $inputs["resolution"] =  filter_var($inputs["resolution_width"]."x".$inputs["resolution_height"], FILTER_SANITIZE_STRING);
        $inputs["refresh_rate"] = intval(filter_var($inputs["refresh_rate"], FILTER_SANITIZE_NUMBER_INT));
        $inputs["fov"] = intval(filter_var($inputs["fov"], FILTER_SANITIZE_NUMBER_INT));
        $inputs["inputs"] = filter_var($inputs["inputs"], FILTER_SANITIZE_STRING);
        $inputs["accessories"] = filter_var($inputs["accessories"], FILTER_SANITIZE_STRING);
        $inputs["color"] = filter_var($inputs["color"], FILTER_SANITIZE_STRING);
        $inputs["platform"] = filter_var($inputs["platform"], FILTER_SANITIZE_STRING);

        $inputs["accelerometer"] = isset($inputs["accelerometer"]);
        $inputs["camera"] = isset($inputs["camera"]);
        $inputs["gyroscope"] = isset($inputs["gyroscope"]);
        $inputs["adjustable_lenses"] = isset($inputs["adjustable_lenses"]);
        $inputs["magnetometer"] = isset($inputs["magnetometer"]);
        $inputs["koptelefoon"] = isset($inputs["koptelefoon"]);
        $inputs["microfoon"] = isset($inputs["microfoon"]);


        if($inputs["discount"] == 0) {
            $inputs["discount"] = null;
        }
        if($inputs["refresh_rate"] == 0) {
            $inputs["refresh_rate"] = null;
        }
        if($inputs["fov"] == 0) {
            $inputs["fov"] = null;
        }
        if(!$inputs["resolution_width"] && !$inputs["resolution_height"]) {
            $inputs["resolution"] = null;
        }

        return $inputs;
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
    public function createProduct(
        string $EAN,
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
        $magnetometer = null,
        $koptelefoon = null,
        $microfoon = null,
        string $color = null,
        string $platform = null,
        $discount = null
    ) {

        extract($this->sanitizeProductInput(get_defined_vars()));

        return $this->dataHandler->createData(
            "INSERT INTO `product`(`EAN`, `naam`, `merk`, `prijs`, `beschrijving`, `resolutie`, `refresh rate`, `gezichtsveld`, `aansluitingen`, `accessoires`, `accelerometer`, `camera`, `gyroscoop`, `verstelbare lenzen`, `magnetometer`, `koptelefoon`, `microfoon`, `kleur`, `platform`, `korting`)
                           VALUES (:EAN, :name, :brand, :price, :description, :resolution, :refresh_rate, :fov, :inputs, :accessories, :accelerometer, :camera, :gyroscope, :adjustable_lenses, :magnetometer, :koptelefoon, :microfoon, :color, :platform, :discount)",
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
                ":magnetometer" => $magnetometer,
                ":koptelefoon" => $koptelefoon,
                ":microfoon" => $microfoon,
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
            "SELECT * FROM `product` ORDER BY `korting` DESC",
            [],
            true,
            $pagination
        );
    }

    /**
     * reads multiple products and gets one image with the product
     *
     * @param int $pagination the amount of products you want to read per page, pagination works with the page get variable
     * @param string $orderBy what table to order by
     * @return array a 2d array with all the products
     */
    public function readProductsOneImage(int $pagination) {
        return $this->dataHandler->readData(
            "SELECT * FROM `product` LEFT JOIN `image` ON `product`.`EAN` = `image`.`product_EAN` GROUP BY `product`.`EAN` ORDER BY `product`.`korting` DESC",
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
            "SELECT * FROM `product` LEFT JOIN `image` ON `product`.`EAN` = `image`.`product_EAN` WHERE `product`.`ean` LIKE :q OR `product`.`beschrijving` LIKE :q OR `product`.`naam` LIKE :q OR `product`.`merk` LIKE :q GROUP BY `product`.`EAN` ORDER BY `product`.`korting` DESC",
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
     * deletes a product
     *
     * @param string $EAN the EAN of the product you want to delete
     * @return bool if it worked or not
     */
    public function deleteProduct(string $EAN) {
        return $this->dataHandler->deleteData(
            "DELETE FROM `product` WHERE EAN = :EAN",
            [":EAN" => $EAN]
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
     * adds all the symbols, like Hz and euro, and adds an table
     *
     * @param array $products the products you want to apply it on
     * @param array $priority the priority table
     * @param integer $amount the amount of items in the table
     * @return array the product with all the symbols applied
     */
    public function applySymbols(array $products, array $priority, $amount = 0) {

        $assoc = ArrayHelper::is_assoc($products);

        if($assoc) {
            $products = ArrayHelper::to2DArray($products);
        }

        foreach($products as $key => $product) {

            $products[$key] = $this->addCheckmark($products[$key]);
            $products[$key] = $this->addHz($products[$key]);
            $products[$key] = $this->addDegreeSymbol($products[$key]);
            $products[$key] = $this->addEuro($products[$key]);

            $items = ArrayHelper::getPriority($products[$key], $priority, $amount);
            $products[$key]["priority_table"] = HTMLElements::table($items, "table", false);
        }

        if($assoc) {
            $products = $products[0];
        }

        return $products;
    }

    /**
     * adds a checkmark to the product
     *
     * @param array $product the product you want to add checkmarks on
     * @return array the finished product
     */
    public function addCheckmark(array $product) {
        foreach(["accelerometer", "camera", "gyroscoop", "verstelbare lenzen", "magnetometer", "microfoon", "koptelefoon"] as $value) {

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

        $product["prijs"] = "€ ". str_replace(".", ",", $product["prijs"]);

        if(isset($product["korting"]))
            $product["korting"] = "€ ". str_replace(".", ",", $product["korting"]);


        return $product;
    }

}
