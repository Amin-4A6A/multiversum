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
        } else {
            $this->data = unserialize($_COOKIE[$name]);
        }

    }
    public function saveCookie()
    {
        // var_dump($this->data);
        setcookie($this->name, serialize($this->data));
    }

    /**
     * deletes the cookie
     *
     * @return bool if it will delete
     */
    public function deleteCookie() {
        return setcookie($this->name, "", time()-3600);
    }

}
