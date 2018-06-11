<?php
require "Controller.php";
require "../model/AdresModel.php";
require "../model/OrderModel.php";

/**
 * The betaal controller
 *
 * @category   Controller
 * @author     Leon in 't Veld <leon3110l@gmail.com>
 * @author     Amin Zammou <aminzammou@hotmail.com>
 */
class BetaalController extends Controller {

    /**
     * @var AdresModel
     * @access private
     */
    private $adres;

    /**
     * @var OrderModel
     * @access private
     */
    private $order;

    /**
     * creates a new BetaalController
     */
    public function __construct() {
        $this->adres = new AdresModel();
        $this->order = new OrderModel();
    }

    /**
     * handles the request
     *
     * @return void
     */
    public function handleRequest() {

        switch ($_GET["op"] ?? false) {
            case 'formulier':
                $this->collectFormBetaal();
                break;
            case 'cart':
                $this->collectCard();
                break;
        }

    }

    /**
     * the betaal form method
     *
     * @return void
     */
    public function collectFormBetaal() {

        $this->render("betaal/form.twig");

    }
    /**
     * the card method
     *
     * @return void
     */
    public function collectCard() {
        $this->render("betaal/side_cart.twig");

    }

}
