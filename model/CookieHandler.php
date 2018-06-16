<?php

/**
 * The model of schoppingCart
 *
 * @category   Model
 * @author     Leon in 't Veld <leon3110l@gmail.com>
 * @author     Amin Zammou <aminzammou@hotmail.com>
 */
class CookieHandler
{

    /**
     * @var string the name of the cookie .
     * @access public
     */
    public $name;
    public $data = array();

    public function __construct($name, $time)
    {

        $this->name = $name;

        if (!isset($_COOKIE[$name])) {
            setcookie($name, null, time() + $time);
        }

    }
    public function __destruct()
    {
        setcookie($this->name, serialize($this->data));
    }

}
