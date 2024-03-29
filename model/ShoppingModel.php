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
/**
 * function that adds a product to the cart
 *
 * @param string $ean
 * @param integer $amount
 * @return void
 */
    public function addToCart($ean, $amount = 1)
    {
        $this->cookieHandler->data[$ean] += $amount;
        $this->cookieHandler->saveCookie();

    }

    /**
     * update the product in the cart
     *
     * @param string $ean
     * @param integer $amount
     * @return void
     */
    public function updateCartProduct($ean, $amount = 1)
    {
        if($amount < 1) {
            $this->deleteCartProduct($ean);
            return;
        }


        $this->cookieHandler->data[$ean] = $amount;
        $this->cookieHandler->saveCookie();
    }
    /**
     * delete the product in the cart
     *
     * @param string $ean
     * @return void
     */
    public function deleteCartProduct($ean)
    {
        unset($this->cookieHandler->data[$ean]);
        $this->cookieHandler->saveCookie();
    }
    /**
     * an function that returns all prduducts in the shopping cart
     *
     * @param boolean $format
     * @return array $products
     */
    public function readCart($format = true) {

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
            $this->product->getPrice($products["products"], $format)
        );

        $products["products"] = $this->product->applySymbols($products["products"]);
        
        return $products;

    }

}
