<?php
require "Controller.php";

class ProductController extends Controller {

    public function handleRequest() {
        
        switch ($_GET["op"] ?? false) {
            default:
                $this->render("home.twig");
                break;
        }

    }

}