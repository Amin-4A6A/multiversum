<?php

/**
 * The cookiehandler used to store information in
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
    public $time;
    public $path;

     /**
     * constructor for the cookiehandler
     *
     * @param string $name the name of  the cookie
     * @param int $time how long the cookie wil exist
     * @param string $path the path of the cookie
     */

    public function __construct($name, $time, $path = "/")
    {

        $this->name = $name;
        $this->time = time() + $time;
        $this->path = $path;

        if (!isset($_COOKIE[$name])) {
            setcookie($this->name, null, $this->time, $path, $this->path);
        } else {
            $this->data = unserialize($_COOKIE[$this->name]);
        }

    }

    /**
     * an function that saves cookies\\
     *
     * @return void
     */
    public function saveCookie()
    {
        // var_dump($this->data);
        setcookie($this->name, serialize($this->data), $this->time, $this->path);
    }

    /**
     * deletes the cookie
     *
     * @return bool if it will delete
     */
    public function deleteCookie() {
        return setcookie($this->name, "", time()-3600, $this->path);
    }

}
