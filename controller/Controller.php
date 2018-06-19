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

    /**
     * if used will require the client to login
     *
     * @return void
     */
    public function requireLogin() {
        session_start();
        if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
            return;
        }

        if(isset($_GET["username"]) &&
           isset($_GET["password"]) &&
           $_GET["username"] == $_ENV["ADMIN_USERNAME"] &&
           $_GET["password"] == $_ENV["ADMIN_PASSWORD"]) {
            $_SESSION["logged_in"] = true;
            return;
        }

        die("U moet inloggen om op de pagina te mogen.");
    }

    abstract public function handleRequest();

}
