<?php
require_once "Controller.php";
require_once "../model/ProductModel.php";
require_once "../model/ImageModel.php";
require_once "../model/HTMLElements.php";

/**
 * The product controller
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
        "resolutie",
        "refresh rate",
        "platform",
        "gezichtsveld",
        "kleur",
        "accelerometer",
        "camera",
        "gyroscoop",
        "verstelbare lenzen",
        "magnetometer",
        "microfoon",
        "koptelefoon",
        "aansluitingen",
        "accessoires",
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

            case "admin":
                $this->collectAdminProduct();
                break;
            case "create":
                $this->collectCreateProduct();
                break;
            case "update":
                $this->collectUpdateProduct();
                break;
            case "delete":
                $this->collectDeleteProduct();
                break;
            case "read":
                $this->collectReadProduct();
                break;
            case 'contact':
                $this->collectContact();
                break;
            case 'overview':
                $this->collectOverviewProduct();
                break;
            case 'search':
                $this->collectSearchProduct();
                break;
            case 'home':
            default:
                $this->collectHomeProduct();
                break;
        }

    }

    /**
     * the contact page method
     *
     * @return void
     */
    public function collectContact() {
        $this->render("contact.twig");
    }

    /**
     * the update page method
     *
     * @return void
     */
    public function collectUpdateProduct() {

        $this->requireLogin();


        if(!isset($_POST["submit"])) {

            if(!isset($_GET["EAN"]))
                $this->redirect("/product/admin");

            $product = $this->product->readProduct($_GET["EAN"]);

            $resolution = explode("x", $product["resolutie"]);

            $product["resolution_width"] = $resolution[0] ?? "";
            $product["resolution_height"] = $resolution[1] ?? "";

            $images = $this->image->readImages($_GET["EAN"]);

            $update = true;

            $this->render("product/form.twig", compact("product", "images", "update"));

        } else {

            $this->product->updateProduct(
                $_GET["EAN"],
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
                $_POST["accelerometer"] ?? null,
                $_POST["camera"] ?? null,
                $_POST["gyroscope"] ?? null,
                $_POST["adjustable_lenses"] ?? null,
                $_POST["magnetometer"] ?? null,
                $_POST["koptelefoon"] ?? null,
                $_POST["microfoon"] ?? null,
                $_POST["color"],
                $_POST["platform"],
                $_POST["discount"]
            );

            $this->image->createImagesUpload($_FILES["product_images"], $_POST["EAN"]);

            foreach ($_POST["delete_image"] as $key => $value) {
                $this->image->deleteImage($key);
            }

            $this->redirect("/product/" . $_POST["EAN"]);

        }

    }

    /**
     * the home page method
     *
     * @return void
     */
    public function collectHomeProduct() {

        $products = $this->product->readProductsOneImage(6);

        $products = $this->product->applySymbols($products, $this->cardPriority, 3);

        $this->render("home.twig", compact("products"));

    }

    /**
     * the overview product page controller method
     *
     * @return void
     */
    public function collectOverviewProduct() {

        $products = $this->product->readProductsOneImage(9);

        $products = $this->product->applySymbols($products, $this->cardPriority, 3);

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

        $products = $this->product->applySymbols($products, $this->cardPriority, 3);

        $pagination = HTMLElements::pagination(
            $this->product->dataHandler->pagination(9),
            $_GET["page"] ?? 0,
            "/product/search/{page}?q=" . urlencode($_GET["q"])
        );

        $page_title = "Zoek resultaten";

        $this->render("product/paginated_content.twig", compact("products", "pagination", "page_title"));

    }

    /**
     * the delete product method
     *
     * @return void
     */
    public function collectDeleteProduct() {

        $this->requireLogin();

        if(!isset($_GET["EAN"]))
            $this->redirect("/product/admin");

        $this->image->deleteImages($_GET["EAN"]);
        $this->product->deleteProduct($_GET["EAN"]);

        $this->redirect("/product/admin");

    }

    /**
     * the admin page method
     *
     * @return void
     */
    public function collectAdminProduct() {

        $this->requireLogin();

        $products = $this->product->readProducts();

        foreach($products as $key => $product) {
            // <a class=\"btn btn-warning\" href=\"?op=update&id=".$row["product_id"]."\"><i class='fas fa-edit'></i> Update</a>

            $products[$key]["actions"] = "
            <a class=\"btn btn-danger\" href=\"/product/delete?EAN=$product[EAN]\"><i class='fas fa-trash-alt'></i> Verwijder</a>
            <a class=\"btn btn-warning\" href=\"/product/update?EAN=$product[EAN]\"><i class='fas fa-edit'></i> Wijzig</a>
            ";

            $products[$key] = ArrayHelper::getPriority($products[$key], [
                "EAN",
                "merk",
                "naam",
                "actions"
            ]);
        }

        $table = HTMLElements::table($products, "table");

        $this->render("product/admin.twig", compact("table"));

    }

    /**
     * the create product page controller method
     *
     * @return void
     */
    public function collectCreateProduct() {

        $this->requireLogin();

        if(!isset($_POST["submit"])) {

            $this->render("product/form.twig");

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
                $_POST["accelerometer"] ?? null,
                $_POST["camera"] ?? null,
                $_POST["gyroscope"] ?? null,
                $_POST["adjustable_lenses"] ?? null,
                $_POST["magnetometer"] ?? null,
                $_POST["koptelefoon"] ?? null,
                $_POST["microfoon"] ?? null,
                $_POST["color"],
                $_POST["platform"],
                $_POST["discount"]
            );

            $this->image->createImagesUpload($_FILES["product_images"], $_POST["EAN"]);

            $this->redirect("/product/" . $_POST["EAN"]);

        }

    }

    
    public function collectReadProduct() {

        $detailProducts =
        [
            "resolutie",
            "refresh rate",
            "platform",
            "gezichtsveld",
            "kleur",
            "accelerometer",
            "camera",
            "gyroscoop",
            "verstelbare lenzen",
            "magnetometer",
            "microfoon",
            "koptelefoon",
            "aansluitingen",
            "accessoires",
            "EAN"
        ];

        $images = $this->image->readImages($_GET['EAN']);
        $product = $this->product->readProduct($_GET['EAN']);
        $product = $this->product->applySymbols($product, $detailProducts);

        $this->render("product/detail.twig", compact("product","images"));

    }
    public function shoppingCart() {

    if(isset($_COOKIE["shopping_cart"])) {
      $total = 0;
      $product_data = stripslashes($_COOKIE["shopping_cart"]);
      $cart_data = json_decode($product_data, true);
      foreach($cart_data as $key => $value){

        ?>
        <h5 class='card-title'><?php echo $value["product_name"] ?></h5>
        <h5 class='card-title'><?php echo $value["product_price"] ?></h5>
        <h5 class='card-title'><?php echo $value["product_quantity"] ?></h5>
        <h5 class='card-title'><?php echo number_format($values["
            product_quantity"] * $values["
            product_price "], 2) ?></h5>
            <?php
     $total = $total + ($value["product_quantity"] * $value["product_price"]);
    }
   ?>

     <h5 colspan="3" align="right">Total</h5>
     <h5 align="right">$ <?php echo number_format($total, 2); ?></h5>

        <?php
      }
      else {
        echo'cart is empty';
      }
    

    }

}
