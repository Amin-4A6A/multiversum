<?php
require_once "CookieHandler.php";
require_once "ProductModel.php";

/**
 * The model of ShoppingModel
 *
 * @category   Model
 * @author     Leon in 't Veld <leon3110l@gmail.com>
 * @author     Amin Zammou <aminzammou@hotmail.com>
 */

class ShoppingModel
{
      /**
     * @var ProductModel
     * @access private
     */
    private $product;

    /**
     * @var CookieHandler the name of the cookie .
     * @access public
     */

    public $cookieHandler; /* deze is leeg*/

    public function __construct()
    {

        $this->cookieHandler = new CookieHandler("shoppingCart", (24 * 60 * 60 * 2));
        $this->product = new ProductModel();
    }
    public function addToCart($ean, $amount = 1)
    {
        $this->cookieHandler->data[$ean] = $amount;

    }
    public function updateCartProduct($ean, $amount = 2)
    {
        $this->addToCart($ean, $amount);
    }
    public function deleteCartProduct()
    {
        unset($this->cookieHandler->data[$ean]);
    }
    public function readCart() {
   
        $this->cookieHandler->data;
        $products = [];
        foreach ($this->cookieHandler->data as $ean => $amount) {
            $product[] = $this->product->readProduct($ean);
        }
        
        return $products;

    }

}

// public function addToProductCart($value='') {
// // setcookie("schoppingCart", "0192371098237:1,0238409283409:1,02348092348:2");
//
//     if(!isset($_POST["add_cart"])) {
//
//         $product_array = array(
//           'product_name'    => $_POST["naam"],
//           'product_price'   => $_POST["prijs"],
//           'product_ean'     => $_POST["EAN"],
//           'product_quantity'=> $_POST["aantal"],
//         );
//         $cart_data[] = $product_array;
//         $product_data = json_encode($cart_data);
//         setcookie("schoppingCart", "$product_data", time() + (86400 * 30));
//
//
//     }
//   //   if(!isset($_GETS["success"])) {
//   //     $message = 'gelukt ?';
//   // }
// }
// }
