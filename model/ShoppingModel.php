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
        $this->cookieHandler->data[$ean] += $amount;
        $this->cookieHandler->saveCookie();

    }

    public function updateCartProduct($ean, $amount = 1)
    {
        $this->cookieHandler->data[$ean] = $amount;
        $this->cookieHandler->saveCookie();
    }

    public function deleteCartProduct($ean)
    {
        unset($this->cookieHandler->data[$ean]);
        $this->cookieHandler->saveCookie();
    }
    
    public function readCart() {

        $products = [
            "products" => [],
        ];
        foreach ($this->cookieHandler->data as $ean => $amount) {
            $product = $this->product->readProductOneImage($ean);
            $product["aantal"] = $amount;
            $products["products"][] = $product;
        }
        
        $products = array_merge(
            $products,
            $this->product->getPrice($products["products"])
        );

        $products["products"] = $this->product->applySymbols($products["products"]);
        
        return $products;

    }

}
