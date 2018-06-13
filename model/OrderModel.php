<?php
require_once "DataHandler.php";

/**
 * The model of order
 * 
 * @category   Model
 * @author     Leon in 't Veld <leon3110l@gmail.com>
 * @author     Amin Zammou <aminzammou@hotmail.com>
 */
class OrderModel {

    /**
     * @var DataHandler
     * @access public
     */
    public $dataHandler;

    /**
     * creates a new OrderModel
     */
    public function __construct() {
        $this->dataHandler = new DataHandler($_ENV["DB_HOST"], $_ENV["DB_DATABASE"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
    }

    /**
     * creates an order
     *
     * @param string $prijs
     * @param string $telefoonnummer
     * @param string $email
     * @param string $betaaladres_id
     * @param string $bezorgadres_id
     * @return int order id
     */
    public function createOrder(
        $prijs,
        $telefoonnummer,
        $email,
        $betaaladres_id,
        $bezorgadres_id
    ) {

        $prijs = floatval(filter_var($prijs, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $telefoonnummer = filter_var($telefoonnummer, FILTER_SANITIZE_NUMBER_INT);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $betaaladres_id = intval(filter_var($betaaladres_id, FILTER_SANITIZE_NUMBER_INT));
        $bezorgadres_id = intval(filter_var($bezorgadres_id, FILTER_SANITIZE_NUMBER_INT));

        return $this->dataHandler->createData(
            "INSERT INTO `order`(`prijs`, `telefoonnummer`, `email`, `betaaladres_id`, `bezorgadres_id`) VALUES (:prijs, :telefoonnummer, :email, :betaaladres_id, :bezorgadres_id)",
            [
                ":prijs" => $prijs,
                ":telefoonnummer" => $telefoonnummer,
                ":email" => $email,
                ":betaaladres_id" => $betaaladres_id,
                ":bezorgadres_id" => $bezorgadres_id ?? $betaaladres_id,
            ]
        );
    }

    /**
     * sets the payment id of an order
     *
     * @param integer $orderId
     * @param string $paymentId
     * @return void
     */
    public function setPaymentId(int $orderId, string $paymentId) {
        return $this->dataHandler->updateData(
            "UPDATE `order` SET `payment_id` = :paymentId WHERE `id` = :orderId",
            [
                ":paymentId" => $paymentId,
                ":orderId" => $orderId,
            ]
        );
    }

    /**
     * reads an order
     *
     * @param integer $id
     * @return array the order
     */
    public function readOrder(int $id) {
        return $this->dataHandler->readData(
            "SELECT * FROM `order` WHERE id = :id",
            [
                ":id" => $id
            ],
            false
        );
    }

}