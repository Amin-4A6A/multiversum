<?php
require "Controller.php";
require "../model/AdresModel.php";
require "../model/OrderModel.php";

/**
 * The betaal controller
 *
 * @category   Controller
 * @author     Leon in 't Veld <leon3110l@gmail.com>
 * @author     Amin Zammou <aminzammou@hotmail.com>
 */
class BetaalController extends Controller {

    /**
     * @var AdresModel
     * @access private
     */
    private $adres;

    /**
     * @var OrderModel
     * @access private
     */
    private $order;

    /**
     * creates a new BetaalController
     */
    public function __construct() {
        $this->adres = new AdresModel();
        $this->order = new OrderModel();
    }

    public function handleRequest() {

        switch ($_GET["op"] ?? false) {
            case 'value':
                # code...
                break;
            
            default:
                echo "hoi";
                break;
        }

    }

}