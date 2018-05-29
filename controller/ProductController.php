<?php
require "Controller.php";
require "../model/ProductModel.php";
require "../model/HTMLElements.php";

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
            case "create":
                $this->collectCreateProduct();
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

    /**
     * the create product page controller method
     *
     * @return void
     */
    public function collectCreateProduct() {

        if(!isset($_POST["submit"])) {

            $form = HTMLElements::generateForm(
                $this->product->describeTable(),
                "POST",
                "/product/create",
                "form",
                "product toevoegen"
            );
    
            $this->render("product/create.twig", compact("form"));

        } else {

            $this->product->createProduct(
                filter_var($_POST["EAN"], FILTER_SANITIZE_STRING),
                filter_var($_POST["name"], FILTER_SANITIZE_STRING),
                filter_var($_POST["brand"], FILTER_SANITIZE_STRING),
                filter_var($_POST["price"], FILTER_SANITIZE_NUMBER_FLOAT),
                filter_var($_POST["description"], FILTER_SANITIZE_STRING),
                filter_var($_POST["resolution"], FILTER_SANITIZE_STRING),
                filter_var($_POST["refresh_rate"], FILTER_SANITIZE_NUMBER_INT),
                filter_var($_POST["fov"], FILTER_SANITIZE_NUMBER_INT),
                filter_var($_POST["inputs"], FILTER_SANITIZE_STRING),
                filter_var($_POST["accessories"], FILTER_SANITIZE_STRING),
                $_POST["accelerometer"] == "ON",
                $_POST["camera"] == "ON",
                $_POST["gyroscope"] == "ON",
                $_POST["adjusable_lenses"] == "ON",
                filter_var($_POST["color"], FILTER_SANITIZE_STRING),
                filter_var($_POST["platform"], FILTER_SANITIZE_STRING),
                filter_var($_POST["discount"], FILTER_SANITIZE_NUMBER_FLOAT)
            );

        }

    }

}
