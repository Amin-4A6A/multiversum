<?php
require "Controller.php";
require "../model/AdresModel.php";
require "../model/ProductModel.php";
require "../model/OrderModel.php";
require "../model/ShoppingModel.php";
require "../model/OrderProductsModel.php";
require_once "../model/HTMLElements.php";

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
     * @var ShoppingModel
     * @access private
     */
    private $cart;

    /**
     * creates a new BetaalController
     */
    public function __construct() {
        $this->adres = new AdresModel();
        $this->order = new OrderModel();
        $this->mollie = new Mollie\Api\MollieApiClient();
        $this->mollie->setApiKey($_ENV["MOLLIE_KEY"]);
        $this->cart = new ShoppingModel();
        $this->orderProducts = new OrderProductsModel();
        $this->product = new ProductModel();
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
            case 'confirm':
                $this->collectConfirm();
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

        if($payment->status === "paid") {
            $this->cart->cookieHandler->deleteCookie(); // if paid remove from cart
        }

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

            $cart = $this->cart->readCart(false);

            $orderId = $this->order->createOrder(
                $cart["totaal"],
                $_POST["telefoonnummer"],
                $_POST["email"],
                $betaalAdres,
                $bezorgAdres
            );

            foreach($cart["products"] as $product) {
                $this->orderProducts->createOrderProduct($orderId, $product["EAN"], $product["aantal"]);
            }

            $this->redirect("/betaal/confirm?order=" . $orderId);


        } else {

            $this->render("betaal/form.twig");
        }


    }

    /**
     * the confirm method
     *
     * @return void
     */
    public function collectConfirm() {

        if(!isset($_GET["order"]))
            $this->redirect("/");

        $order = $this->orderProducts->readOrderProducts($_GET["order"]);

        $betaaladresArray = [
            "Naam: " => $order["betaaladres"]["voornaam"] . " " . $order["betaaladres"]["tussenvoegsel"] . " " . $order["betaaladres"]["achternaam"],
            "Stad: " => $order["betaaladres"]["stad"],
            "Straat: " => $order["betaaladres"]["straat"],
            "Huisnummer: " => $order["betaaladres"]["huisnummer"] . $order["betaaladres"]["toevoeging"],
            "Postcode: " => $order["betaaladres"]["postcode"],
        ];

        if($order["betaaladres"]["id"] == $order["bezorgadres"]["id"]) {
            $bezorgadresArray = $betaaladresArray;
        } else {
            $bezorgadresArray = [
                "Naam: " => $order["bezorgadres"]["voornaam"] . " " . $order["bezorgadres"]["tussenvoegsel"] . " " . $order["bezorgadres"]["achternaam"],
                "Stad: " => $order["bezorgadres"]["stad"],
                "Straat: " => $order["bezorgadres"]["straat"],
                "Huisnummer: " => $order["bezorgadres"]["huisnummer"] . $order["bezorgadres"]["toevoeging"],
                "Postcode: " => $order["bezorgadres"]["postcode"],
            ];
        }

        $betaaladresTable = HTMLElements::table($betaaladresArray, "table", false);
        $bezorgadresTable = HTMLElements::table($bezorgadresArray, "table", false);


        $priceArray = $this->product->getPrice($order["products"]);

        $priceTable = HTMLElements::table($priceArray, "table", false);

        $this->render("betaal/confirm.twig", compact("order", "betaaladresTable", "bezorgadresTable", "priceTable"));

    }

}
