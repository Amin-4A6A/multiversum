<?php
require "Controller.php";

class ProductController extends Controller {

    public function handleRequest() {

        switch ($_GET["op"] ?? false) {

          case 'contact':
              $this->render("contact.twig");
            break;
            case 'overvieuw':
                $this->render("overview.twig");
              break;
            default:
                $this->render("home.twig");
                break;
        }

    }

}
