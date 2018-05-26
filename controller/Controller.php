<?php

abstract class Controller {
    
    public function render($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new Twig_Loader_Filesystem(dirname(__DIR__) . '/view');
            $twig = new Twig_Environment($loader);
        }

        echo $twig->render($template, $args);
    }

    abstract public function handleRequest();

}
