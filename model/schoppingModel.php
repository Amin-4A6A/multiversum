<?php
require_once "DataHandler.php";

/**
 * The model of schoppingCart
 *
 * @category   Model
 * @author     Leon in 't Veld <leon3110l@gmail.com>
 * @author     Amin Zammou <aminzammou@hotmail.com>
 */
class schoppingCart {

  public function addToProductCart($value='')
  {
  // setcookie("schoppingCart", "0192371098237:1,0238409283409:1,02348092348:2");

    if(!isset($_POST["add_cart"])) {

        $product_array = array(
          'product_name'    => $_POST["naam"],
          'product_price'   => $_POST["prijs"],
          'product_ean'     => $_POST["EAN"],
          'product_quantity'=> $_POST["aantal"],
        );
        $cart_data[] = $product_array;
        $product_data = json_encode($cart_data);
        setcookie('schoppingCart','$product_data', time() + (86400 * 30));
        // header("location:product/detail.twig?success=1")

    }
  //   if(!isset($_GETS["success"])) {
  //     $message = 'gelukt ?';
  // }

}



?>
