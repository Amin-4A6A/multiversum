<?php
require "Controller.php";
require "../model/ProductModel.php";
require "../model/ImageModel.php";
require "../model/HTMLElements.php";

/**
 * The base controller
 *
 * @category   Controller
 * @author     Leon in 't Veld <leon3110l@gmail.com>
 * @author     Amin Zammou <aminzammou@hotmail.com>
 */
class ProductController extends Controller {

    /**
     * @var ProductModel
     * @access private
     */
    private $product;

    /**
     * @var ImageModel
     * @access private
     */
    private $image;

    /**
     * @var array the array with an priority list for the card
     * @access private
     */
    private $cardPriority = [
        "resolution",
        "refresh_rate",
        "platform",
        "fov",
        "color",
        "accelerometer",
        "camera",
        "gyroscope",
        "adjustable_lenses",
        "inputs",
        "accessories"
    ];

    /**
     * creates a new ProductController
     */
    public function __construct() {
        $this->product = new ProductModel();
        $this->image = new ImageModel();
    }

    /**
     * handles the request
     *
     * @return void
     */
    public function handleRequest() {

        switch ($_GET["op"] ?? false) {

            case "create":
                $this->collectCreateProduct();
                break;
            case "read":
                $this->collectReadProduct();
                break;
            case 'detail':
                $this->render("product/detail.twig");
                break;
            case 'contact':
                $this->render("contact.twig");
                break;
            case 'overview':
                $this->collectOverviewProduct();
                break;
            case 'home':
            default:
                $this->render("home.twig");
                break;
        }

    }


    /**
     * the overview product page controller method
     *
     * @return void
     */
    public function collectOverviewProduct() {

        $products = $this->product->readProductsOneImage(9);

        foreach($products as $key => $product) {
            $items = ArrayHelper::getPriority($product, $this->cardPriority, 3);
            $products[$key]["priority_table"] = HTMLElements::table($items, "table", false);
        }

        $pagination = HTMLElements::pagination(
            $this->product->dataHandler->pagination(9),
            $_GET["page"] ?? 0,
            "/product/overview/{page}"
        );

        $this->render("product/overview.twig", compact("products", "pagination"));
    }

    /**
     * the create product page controller method
     *
     * @return void
     */
    public function collectCreateProduct() {

        if(!isset($_POST["submit"])) {

            $this->render("product/create.twig");

        } else {

            $EAN = filter_var($_POST["EAN"], FILTER_SANITIZE_STRING);
            $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
            $brand = filter_var($_POST["brand"], FILTER_SANITIZE_STRING);
            $price = floatval(filter_var($_POST["price"], FILTER_SANITIZE_NUMBER_FLOAT));
            $description = filter_var($_POST["description"], FILTER_SANITIZE_STRING);
            $discount = floatval(filter_var($_POST["discount"], FILTER_SANITIZE_NUMBER_FLOAT));
            $resolution =  filter_var($_POST["resolution_width"]."x".$_POST["resolution_height"], FILTER_SANITIZE_STRING);
            $refresh_rate = intval(filter_var($_POST["refresh_rate"], FILTER_SANITIZE_NUMBER_INT));
            $fov = intval(filter_var($_POST["fov"], FILTER_SANITIZE_NUMBER_INT));
            $inputs = filter_var($_POST["inputs"], FILTER_SANITIZE_STRING);
            $accessories = filter_var($_POST["accessories"], FILTER_SANITIZE_STRING);
            $color = filter_var($_POST["color"], FILTER_SANITIZE_STRING);
            $platform = filter_var($_POST["platform"], FILTER_SANITIZE_STRING);


            if($discount == 0) {
                $discount = null;
            }
            if($refresh_rate == 0) {
                $refresh_rate = null;
            }
            if($fov == 0) {
                $fov = null;
            }
            if(!$_POST["resolution_width"] && !$_POST["resolution_height"]) {
                $resolution = null;
            }

            $this->product->createProduct(
                $EAN,
                $name,
                $brand,
                $price,
                $description,
                $resolution,
                $refresh_rate,
                $fov,
                $inputs,
                $accessories,
                isset($_POST["accelerometer"]),
                isset($_POST["camera"]),
                isset($_POST["gyroscope"]),
                isset($_POST["adjustable_lenses"]),
                $color,
                $platform,
                $discount
            );

            $this->image->createImagesUpload($_FILES["product_images"], $EAN);

            $this->redirect("/product/$EAN");

        }

    }
      public function collectReadProduct() {
        $array = ["key" => "value"];
        $table = HTMLElements::tableSpec($array);
        $this->render("product/detail.twig", compact("table"));
      }

}
