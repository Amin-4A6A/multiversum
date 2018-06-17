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
        $this->cookieHandler->saveCookie();

    }
    public function updateCartProduct($ean, $amount = 2)
    {
        $this->addToCart($ean, $amount);
        
    }
    public function deleteCartProduct()
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
            $product["amount"] = $amount;
            $products["products"][] = $product;
        }
        $products["subtotaal"] = array_reduce($products["products"],
            function($carry, $item){
                $carry += floatval($item["prijs"]) * intval($item["amount"]);
                return $carry;

            }
        );
        $products["exBTW"] = $products["subtotaal"]/ 121 * 100;
        $products["verzendkosten"] = 6.50 ;
        $products["totaal"] = $products["subtotaal"] + $products["verzendkosten"];
        $products["products"] = $this->product->applySymbols($products["products"]);
        return $products;

    }

}
