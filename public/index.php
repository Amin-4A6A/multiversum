<?php
require "../vendor/autoload.php";

// load environment variables
$dotenv = new Dotenv\Dotenv(dirname(__DIR__));
$dotenv->load();

// route to the correct
$controllerName = ucfirst($_GET["controller"]) . "Controller";

$file = dirname(__DIR__) . "/controller/" . $controllerName . ".php";

require $file;

$controller = new $controllerName();

$controller->handleRequest();