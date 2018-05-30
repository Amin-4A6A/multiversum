<?php
require_once "DataHandler.php";
require_once "FileHandler.php";

/**
 * The model of image
 * 
 * @category   Model
 * @author     Leon in 't Veld <leon3110l@gmail.com>
 * @author     Amin Zammou <aminzammou@hotmail.com>
 */
class ImageModel {

    /**
     * the datahandler
     *
     * @var DataHandler
     * @access private
     */
    private $dataHandler;

    /**
     * the fileHandler
     *
     * @var FileHandler
     * @access private
     */
    private $fileHandler;

    /**
     * create new dataHandler and other init stuff
     */
    public function __construct() {
        $this->dataHandler = new DataHandler($_ENV["DB_HOST"], $_ENV["DB_DATABASE"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
        $this->fileHandler = new FileHandler(dirname(__DIR__)."/public/images/product");
    }

    /**
     * inserts an image to the database
     *
     * @param string $path the path of the image
     * @param string $EAN the ean of the product you want to attach the image to
     * @return int last insert id
     */
    public function createImage(string $path, string $EAN) {
        return $this->dataHandler->createData(
            "INSERT INTO `image`(`path`, `product_EAN`) VALUES(:path, :product_EAN)",
            [
                ":path" => $path,
                ":product_EAN" => $EAN
            ]
        );
    }

    /**
     * inserts an image to the database
     *
     * @param string $path the path of the image
     * @param string $EAN the ean of the product you want to attach the image to
     * @return int last insert id
     */
    public function createImages(array $paths, string $EAN) {
        
        $bindings = [
            ":product_EAN" => $EAN
        ];
        foreach ($paths as $key => $value) {
            $bindings[":path_".$key] = $value;
            $paths[$key] = "(:path_$key, :product_EAN)";
        }

        $sql = "INSERT INTO `image`(`path`, `product_EAN`) VALUES " . implode(", ", $paths);

        return $this->dataHandler->createData(
            $sql,
            $bindings
        );
    }

    /**
     * uploads image and adds it to the database
     *
     * @param array $files $_FILES["input_name"] array
     * @param string $EAN the ean of the product you want to attach the image to
     * @return int last insert id
     */
    public function createImagesUpload(array $files, string $EAN) {

        $paths = $this->fileHandler->uploadImages($files);

        // map the path we want to the paths array
        foreach($paths as $key => $path) {
            $paths[$key] = $path["file_name"];
        }

        return $this->createImages($paths, $EAN);
    }

    /**
     * reads the images from the database
     *
     * @param string $EAN the EAN of the product you want the images from
     * @return array the images
     */
    public function readImages(string $EAN) {
        return $this->dataHandler->readData(
            "SELECT * FROM `image` WHERE `product_EAN` = :product_EAN",
            [
                ":product_EAN" => $EAN
            ]
        );
    }

    /**
     * gets one image from the database
     *
     * @param string $EAN the EAN of the product you want the image from
     * @return array the image
     */
    public function readImage(string $EAN) {
        return $this->dataHandler->readData(
            "SELECT * FROM `image` WHERE `product_EAN` = :product_EAN LIMIT 1",
            [
                ":product_EAN" => $EAN
            ]
        );
    }

}