<?php
require "Controller.php";
require "../model/ProductModel.php";
require "../model/ImageModel.php";
require "../model/HTMLElements.php";

class ProductController extends Controller {

    private $product;

    public function __construct() {
        $this->product = new ProductModel();
        $this->image = new ImageModel();
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
            case "read":
                $this->collectReadProduct();
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
                $this->render("product/overview.twig");
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
                "/product/create",
                "POST",
                "form",
                "product toevoegen"
            );

            $this->render("product/create.twig", compact("form"));

        } else {


            $EAN = filter_var($_POST["EAN"], FILTER_SANITIZE_STRING);

            $this->product->createProduct(
                $EAN,
                filter_var($_POST["name"], FILTER_SANITIZE_STRING),
                filter_var($_POST["brand"], FILTER_SANITIZE_STRING),
                floatval(filter_var($_POST["price"], FILTER_SANITIZE_NUMBER_FLOAT)),
                filter_var($_POST["description"], FILTER_SANITIZE_STRING),
                filter_var($_POST["resolution_width"]."x".$_POST["resolution_height"], FILTER_SANITIZE_STRING),
                intval(filter_var($_POST["refresh_rate"], FILTER_SANITIZE_NUMBER_INT)),
                intval(filter_var($_POST["fov"], FILTER_SANITIZE_NUMBER_INT)),
                filter_var($_POST["inputs"], FILTER_SANITIZE_STRING),
                filter_var($_POST["accessories"], FILTER_SANITIZE_STRING),
                isset($_POST["accelerometer"]),
                isset($_POST["camera"]),
                isset($_POST["gyroscope"]),
                isset($_POST["adjustable_lenses"]),
                filter_var($_POST["color"], FILTER_SANITIZE_STRING),
                filter_var($_POST["platform"], FILTER_SANITIZE_STRING),
                floatval(filter_var($_POST["discount"], FILTER_SANITIZE_NUMBER_FLOAT))
            );

            $this->image->createImagesUpload($_FILES["product_images"], $EAN);

            $this->redirect("/product/read/$EAN");

        }

    }
      public function collectReadProduct() {
        $array = ["key" => "value"];
        $table = HTMLElements::tableSpec($array);
          $this->render("product/detail.twig", compact("table"));
      }

}
