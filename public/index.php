<?php
require "../vendor/autoload.php";

$controllerName = ucfirst($_GET["controller"]) . "Controller";

$file = dirname(__DIR__) . "/controller/" . $controllerName . ".php";

require $file;

$controller = new $controllerName();

$controller->handleRequest();