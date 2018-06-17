<?php
require_once "DataHandler.php";

/**
 * The model of the order_has_products pivot table
 * 
 * @category   Model
 * @author     Leon in 't Veld <leon3110l@gmail.com>
 * @author     Amin Zammou <aminzammou@hotmail.com>
 */
class OrderProductsModel {

    /**
     * creates a new OrderProductsModel
     */
    public function __construct() {
        $this->dataHandler = new DataHandler($_ENV["DB_HOST"], $_ENV["DB_DATABASE"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
    }


    /**
     * adds an product to an order in the pivot table
     *
     * @param string $order_id
     * @param string $product_EAN
     * @param string $aantal
     * @return void
     */
    public function createOrderProduct($order_id, $product_EAN, $aantal) {

        $order_id = intval($order_id);
        $product_EAN = filter_var(($product_EAN ?? ""), FILTER_SANITIZE_STRING);
        $aantal = intval($aantal);

        return $this->dataHandler->createData(
            "INSERT INTO `order_has_product`(`order_id`, `product_EAN`, `aantal`) VALUES(:order_id, :product_EAN, :aantal)",
            [
                ":order_id" => $order_id,
                ":product_EAN" => $product_EAN,
                ":aantal" => $aantal
            ]
        );

    }

    /**
     * reads the order and the products
     *
     * @param int $order_id
     * @return void
     */
    public function readOrderProducts($order_id) {

        $res = $this->dataHandler->readData(
            "SELECT * FROM `order` WHERE `order`.`id` = :order_id",
            [
                ":order_id" => $order_id
            ],
            false
        );

        $res["betaaladres"] = $this->dataHandler->readData(
            "SELECT * FROM `adres` WHERE `adres`.`id` = :id",
            [
                ":id" => $res["betaaladres_id"]
            ],
            false
        );

        $res["bezorgadres"] = $this->dataHandler->readData(
            "SELECT * FROM `adres` WHERE `adres`.`id` = :id",
            [
                ":id" => $res["bezorgadres_id"]
            ],
            false
        );

        $res["products"] =  $this->dataHandler->readData(
            "SELECT * FROM `order_has_product` INNER JOIN `product` ON `product`.`EAN` = `order_has_product`.`product_EAN` LEFT JOIN `image` ON `product`.`EAN` = `image`.`product_EAN` WHERE `order_has_product`.`order_id` = :order_id GROUP BY `product`.`EAN`",
            [
                ":order_id" => $order_id
            ]
        );

        return $res;

    }

}