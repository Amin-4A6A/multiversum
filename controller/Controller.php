<?php
/**
 * The base controller
 * 
 * @category   Controller
 * @author     Leon in 't Veld <leon3110l@gmail.com>
 */
abstract class Controller {
    
    /**
     * renders a twig template
     *
     * @param string $template template path relative to the view folder
     * @param array $args arguments to pass to the view
     * @return void
     */
    public function render($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new Twig_Loader_Filesystem(dirname(__DIR__) . '/view');
            $twig = new Twig_Environment($loader);
        }

        echo $twig->render($template, $args);
    }

    /**
     * redirects to a url
     *
     * @param string $url the url of the paage to redirect to
     * @return void
     */
    public function redirect(string $url) {
        header("Location: $url");
    }

    abstract public function handleRequest();

}
