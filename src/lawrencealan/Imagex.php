<?php
namespace lawrencealan;

use Exception;
use finfo;

class Imagex
{

    public static $file_info = null;

    public $images = array();
    public $image_list = array();
    public $filter_list = array();
    public $filtered_images = array();

    public $output_folder = "output";

    function __construct()
    {
        if (!defined("DEBUG")) define("DEBUG", false);
        // instantiate fileinfo
        Imagex::$file_info = new finfo(FILEINFO_MIME_TYPE);
    }

    function __destruct()
    {
        unset($this->filtered_images);
        unset($this->images);
    }

    /**
     * Load a single image
     * @param $filename string path to the file
     */
    function LoadImage($filename)
    {
        $this->Log("Loading {$filename}...");
        $img_obj = new ImagexObject($filename);
        if ($img_obj->valid) $this->images[$img_obj->filename] = $img_obj;

    }


    /**
     * Load an multiple images from an array filled with paths
     * @param $image_list array array of path strings
     */
    function LoadImages(array $image_list)
    {
        foreach ($image_list as $filename) $this->LoadImage($filename);
    }

    /**
     * Save filtered images
     * @param $image_list array array of path strings
     */
    function SaveImages()
    {
        $this->Log("Saving images...");
        foreach ($this->filtered_images as $subdir => $filter_images) {
            foreach ($filter_images as $im_name => $im) {
                // we pull the parent using a key lookup from the filename
                $parent = $this->images[$im_name];

                // use the extension to find the right function
                $save_func = "image{$parent->extension}";

                $path = "{$this->output_folder}/{$subdir}";

                $this->Log("\t&middot; {$path}/{$im_name}");
                if (!is_dir($path)) mkdir($path, 0777, true);
                $save_func($im->img, "{$path}/{$im_name}");

            }
        }
    }


    /**
     * Run filters on all the loaded images
     */
    function RunFilters()
    {
        $this->Log("Running filters...");
        foreach ($this->images as $im) {
            $this->Log("\t&middot; {$im->filename}");
            foreach ($this->filter_list as $filter_class) {
                $this->Log("\t\t...'{$filter_class}'");
                $filter_obj = new $filter_class($im);
                $filter_obj->filter();
                @$this->filtered_images[(string)$filter_class][$im->filename] = $filter_obj;
            }
        }
    }


    public $loggedText = "";

    function Log($txt)
    {
        if (DEBUG) $this->loggedText .= "$txt\n";
    }

}

class ImagexObject
{
    public $path = null;
    public $type = null;
    public $extension = null;
    public $valid = FALSE;
    public $image = null;

    /**
     * @param string $path path to source image (required)
     */
    function __construct($path)
    {
        if (empty($path)) throw new Exception("File path missing.");
        if (!file_exists($path)) throw new Exception("File not found. ({$path})");
        $this->path = $path;

        // get the mime type
        $_mimetype = Imagex::$file_info->file($path);
        list($this->type, $this->extension) = explode("/", $_mimetype);

        if ($this->type != 'image' || !preg_match("/^(bmp|jpeg|png|gif)$/", $this->extension)) {
            // not an image/* or compatible image type
            return;
        }

        $this->pathinfo = (object)pathinfo($path);
        $this->filename = "{$this->pathinfo->filename}.{$this->pathinfo->extension}";

        // use the mime type to find the right function
        $create_func = "imagecreatefrom{$this->extension}";

        // create image from source
        $this->image = $create_func($this->path);

        // set parameters
        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);

        // woohoo! valid if we've reached this point
        $this->valid = TRUE;
    }

    function __destruct()
    {
       if($this->image!=null) imagedestroy($this->image);
    }
}

class ImagexFilter
{
    public $title = "Default Filter Title";
    public $img = null;

    function __construct($image_object)
    {
        $this->img = imagecreatetruecolor($image_object->width, $image_object->height);
        imagecopy(
            $this->img,
            $image_object->image,
            0, 0,
            0, 0,
            $image_object->width, $image_object->height
        );
    }

    function filter()
    {
        $total_pixels = imagesx($this->img) * imagesy($this->img);

        /* process image here */
    }

    function __destruct()
    {
        imagedestroy($this->img);
    }
}

