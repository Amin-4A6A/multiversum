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
            case 'search':
                $this->collectSearchProduct();
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

            $products[$key] = $this->product->addCheckmark($products[$key]);
            $products[$key] = $this->product->addHz($products[$key]);
            $products[$key] = $this->product->addDegreeSymbol($products[$key]);

            $items = ArrayHelper::getPriority($products[$key], $this->cardPriority, 3);
            $products[$key]["priority_table"] = HTMLElements::table($items, "table", false);
        }

        $pagination = HTMLElements::pagination(
            $this->product->dataHandler->pagination(9),
            $_GET["page"] ?? 0,
            "/product/overview/{page}"
        );

        $this->render("product/paginated_content.twig", compact("products", "pagination"));
    }

    /**
     * the search product page controller method
     *
     * @return void
     */
    public function collectSearchProduct() {

        if(!isset($_GET["q"]) || empty($_GET["q"]))
            $this->redirect("/product/overview");

        $products = $this->product->searchProductsOneImage($_GET["q"], 9);

        foreach($products as $key => $product) {

            $products[$key] = $this->product->addCheckmark($products[$key]);
            $products[$key] = $this->product->addHz($products[$key]);
            $products[$key] = $this->product->addDegreeSymbol($products[$key]);

            $items = ArrayHelper::getPriority($products[$key], $this->cardPriority, 3);
            $products[$key]["priority_table"] = HTMLElements::table($items, "table", false);
        }

        $pagination = HTMLElements::pagination(
            $this->product->dataHandler->pagination(9),
            $_GET["page"] ?? 0,
            "/product/search/{page}?q=" . urlencode($_GET["q"])
        );

        $page_title = "Zoek resultaten";

        $this->render("product/paginated_content.twig", compact("products", "pagination", "page_title"));

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

            $this->product->createProduct(
                $_POST["EAN"],
                $_POST["name"],
                $_POST["brand"],
                $_POST["price"],
                $_POST["description"],
                $_POST["resolution_width"],
                $_POST["resolution_height"],
                $_POST["refresh_rate"],
                $_POST["fov"],
                $_POST["inputs"],
                $_POST["accessories"],
                $_POST["accelerometer"],
                $_POST["camera"],
                $_POST["gyroscope"],
                $_POST["adjustable_lenses"],
                $_POST["color"],
                $_POST["platform"],
                $_POST["discount"]
            );

            $this->image->createImagesUpload($_FILES["product_images"], $_POST["EAN"]);

            $this->redirect("/product/" . $_POST["EAN"]);

        }

    }

    public function collectReadProduct() {
        $product = $this->$product->readProduct($_get['EAN']);
        $array = ["key" => "value"];
        $tableClass = "table";
        $table = HTMLElements::tableVerticalRows($array, $tableClass);
        $this->render("product/detail.twig", compact("table"));
    }

}
