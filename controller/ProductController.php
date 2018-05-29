<?php
require "Controller.php";
require "../model/ProductModel.php";

class ProductController extends Controller {

    private $product;

    public function __construct() {
        $this->product = new ProductModel();
    }


    public function handleRequest() {

        switch ($_GET["op"] ?? false) {

            case "test":
                echo "<pre>";
                var_dump($this->product->readProduct(1));
                break;

            case 'home':
                $this->render("home.twig");
                break;
            case 'detail':
                $this->render("product/detail.twig");
                break;
            case 'contact':
                $this->render("contact.twig");
                break;
            case 'overview':
                $this->render("overview.twig");
                break;
            default:
                $this->render("home.twig");
                break;
        }

    }

    public function collectCreateProduct() {

    }

}
