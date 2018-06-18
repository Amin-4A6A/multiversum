<?php
require "Controller.php";
require "../model/ShoppingModel.php";

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

            case 'cart':
            default:
                $this->collectCart();

                
        }

    }

    /**
     * the cart method
     *
     * @return void
     */
    public function collectCart() {
        $products = $this->cart->readCart();

        $this->render("cart/side_cart.twig", compact("products"));
    }
    
    /**
     * add product to shopingcart
     *
     * @return void
     */
    public function collectAddToCart()
    {
        if (isset($_GET['ean'])) {
            if (!isset($_GET['amount'])) {
               $amount = 1;
            }else {
                $amount= $_GET['amount'];
            }
            
            $this->cart->addToCart($_GET['ean'], $amount);
            
            
        }
        $this->redirect($_SERVER['HTTP_REFERER']);
      
    }

}
