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
     * @var Mollie\Api\MollieApiClient
     * @access private
     */
    private $mollie;

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
            case 'bank':
                $this->collectBankForm();
                break;
            case 'order':
                $this->collectOrderStatus();
                break;
            case 'cart':
                $this->collectCard();
                break;
            case 'formulier':
            default:
                $this->collectAdresForm();
        }

    }

    /**
     * the order status method
     *
     * @return void
     */
    public function collectOrderStatus() {

        if(!isset($_GET["order"]))
            $this->redirect("/betaal");

        $order = $this->order->readOrder($_GET["order"]);

        if(empty($order["payment_id"]))
            $this->redirect("/betaal/bank");

        $payment = $this->mollie->payments->get($order["payment_id"]);

        $this->render("/betaal/paid.twig", ["status" => $payment->status]);

    }

    /**
     * the bank form method
     *
     * @return void
     */
    public function collectBankForm() {

        if(isset($_POST["submit"])) {

            if(!isset($_GET["order"]))
                $this->redirect("/betaal/formulier");

            $order = $this->order->readOrder($_GET["order"]);

            $protocol = isset($_SERVER['HTTPS']) && strcasecmp('off', $_SERVER['HTTPS']) !== 0 ? "https" : "http";
            $hostname = $_SERVER['HTTP_HOST'];

            $payment = $this->mollie->payments->create([
                "locale" => "nl_NL",
                "amount" => [
                    "currency" => "EUR",
                    "value" => $order["prijs"]
                ],
                "method" => Mollie\Api\Types\PaymentMethod::IDEAL,
                "description" => "Order #{$order["id"]}",
                "redirectUrl" => "{$protocol}://{$hostname}:3000/betaal/order?order={$order["id"]}",
                "metadata" => [
                    "order_id" => $order["id"]
                ],
                "issuer" => $_POST["bank"]
            ]);

            $this->order->setPaymentId($order["id"], $payment->id);

            $this->redirect(
                $payment->getCheckoutUrl()
            );

        } else {
            $method = $this->mollie->methods->get(\Mollie\Api\Types\PaymentMethod::IDEAL, ["include" => "issuers"]);
            $issuers = $method->issuers;

            $this->render("betaal/bank.twig", compact("issuers"));
        }

    }

    /**
     * the betaal form method
     *
     * @return void
     */
    public function collectAdresForm() {

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



            // TODO: naar een soort overview pagina met betaal knop naar /betaal/bank?order=1
            $this->redirect("/betaal/bank?order=" . $orderId); // tijdelijk ding


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
