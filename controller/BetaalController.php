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
        $this->mollie = new Mollie\Api\MollieApiClient();
        $this->mollie->setApiKey($_ENV["MOLLIE_KEY"]);
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

        if(isset($_POST["submit"])) {

            $betaalAdres = $this->adres->createAdres(
                $_POST["betaaladres"]["straat"],
                $_POST["betaaladres"]["huisnummer"],
                $_POST["betaaladres"]["toevoeging"],
                $_POST["betaaladres"]["postcode"],
                "Nederland",
                $_POST["betaaladres"]["woonplaats"],
                $_POST["betaaladres"]["voornaam"],
                $_POST["betaaladres"]["tussenvoegsel"],
                $_POST["betaaladres"]["achternaam"],
                $_POST["betaaladres"]["aanhef"]
            );

            if($_POST["afleveradres"] == "nieuw" && isset($_POST["bezorgadres"])) {
                $bezorgAdres = $this->adres->createAdres(
                    $_POST["bezorgadres"]["straat"],
                    $_POST["bezorgadres"]["huisnummer"],
                    $_POST["bezorgadres"]["toevoeging"],
                    $_POST["bezorgadres"]["postcode"],
                    "Nederland",
                    $_POST["bezorgadres"]["woonplaats"],
                    $_POST["bezorgadres"]["voornaam"],
                    $_POST["bezorgadres"]["tussenvoegsel"],
                    $_POST["bezorgadres"]["achternaam"],
                    $_POST["bezorgadres"]["aanhef"]
                );
            } else {
                $bezorgAdres = $betaalAdres;
            }

            $orderId = $this->order->createOrder(
                "599",                      // TODO: get price from cart cookie
                $_POST["telefoonnummer"],
                $_POST["email"],
                $betaalAdres,
                $bezorgAdres
            );

            // TODO: put products in the divot table thingy from the cart cookie

            var_dump($orderId);
            
        } else {

            $this->render("betaal/form.twig");
        }


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
