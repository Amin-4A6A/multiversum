<?php

/**
 * The FileHandler used to handle file uploads
 * 
 * @category   Model
 * @author     Leon in 't Veld <leon3110l@gmail.com>
 */
class FileHandler {

    /**
     * last select made by the datahandler
     *
     * @var string the save destination
     * @access private
     */
    private $dest;

    /**
     * constructor
     *
     * @param string $dest the default file save destination
     */
    public function __construct(string $dest = null) {
        $this->dest = $dest;
    }

    /**
     * remaps the $_FILES["input_name"] array to something easier to work with
     *
     * @param array $files the $_FILES["input_name"] array
     * @return array $output the remapped array
     */
    private function remapUploadArray(array $files) {

        $output = [];

        for($i = 0; $i < sizeof($files["name"]); $i++) {
            $output[] = [];
            foreach ($files as $key => $value) {
                $output[$i][$key] = $value[$i];
            }
        }

        return $output;

    }

    /**
     * uploads images from a form($_FILES["input_name"] array)
     *
     * @param array $files $_FILES["input_name"] array
     * @param string $dest (optional) the upload destination
     * @return array $paths an array with the image path info
     */
    public function uploadImages(array $files, string $dest = null) {
        $files = $this->remapUploadArray($files);

        $paths = [];
        foreach ($files as $key => $value) {
            $paths[] = $this->uploadImage($value, $dest);
        }

        return $paths;
    }

    /**
     * uploads an image from form($_FILES["input_name"]) array
     *
     * @param array $file $_FILES["input_name"] array
     * @param string $dest (optional) the upload destination
     * @return array $path image path info
     */
    public function uploadImage(array $file, string $dest = null) {

        $dest = $dest ?? $this->dest;

        if(getimagesize($file["tmp_name"]) == false) {
            throw new Exception("file is not an image", 1);
        }

        $fileExt = ".".explode(".", $file["name"])[1];

        $fileName = uniqid() . $fileExt;

        $path = $dest . "/$fileName";
        
        if(move_uploaded_file($file["tmp_name"], $path)) {
            return [
                "path" => $path,
                "file_name" => $fileName,
                "file_ext" => $fileExt,
                "absolute_path" => realpath($path)
            ];
        } else {
            throw new Exception("File could not be uploaded", 1);
        }

    }

}