<?php
require "Controller.php";
require "../model/ShoppingModel.php";
require_once "../model/HTMLElements.php";

/**
 * The cart controller
 *
 * @category   Controller
 * @author     Leon in 't Veld <leon3110l@gmail.com>
 * @author     Amin Zammou <aminzammou@hotmail.com>
 */
class CartController extends Controller {

    /**
     * @var ShoppingModel
     * @access private
     */
    private $cart;

    /**
     * creates a new CartController
     */
    public function __construct() {
        $this->cart = new ShoppingModel();
    }

    /**
     * handles the request
     *
     * @return void
     */
    public function handleRequest() {

        switch ($_GET["op"] ?? false) {
            case 'addtocart':
                $this->collectAddToCart();
                break;
            case 'deletecart':
                $this->collectDeleteCart();
                break;
            case 'cart':
            default:
                $this->collectCart();
                break;
           
                

                
        }

    }

    /**
     * the cart method
     *
     * @return void
     */
    public function collectCart() {
        $products = $this->cart->readCart();

        $prices = [];

        foreach(["subtotaal", "BTW", "verzendkosten", "korting", "totaal"] as $key) {
            $prices[ucfirst($key)] = $products[$key];
        }

        $priceTable = HTMLElements::table($prices, "table", false);

        $this->render("cart/side_cart.twig", compact("products", "priceTable"));
    }
    
    /**
     * add product to shopingcart
     *
     * @return void
     */
    public function collectAddToCart()
    {
        if (isset($_GET['ean'])) {
            if (!isset($_GET['aantal'])) {
                $amount = 1;
            }else {
                $amount= $_GET['aantal'];
            }
            
            $this->cart->addToCart($_GET['ean'], $amount);
            
            
        }
        $this->redirect($_SERVER['HTTP_REFERER']);
      
    }
    public function collectDeleteCart()
    {
        $this->cart->deleteCartProduct($_GET['ean']);
        $this->redirect($_SERVER['HTTP_REFERER']);
      
    }

}
