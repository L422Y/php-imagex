<?php
/**
 * User: larry
 */

include "lawrencealan/Imagex.php";
use lawrencealan\Imagex;

class ImageFilterDemo extends Imagex
{

    /**
     * @param string $path path to search for images (optional)
     */
    function  __construct($path = null)
    {
        parent::__construct();
        if ($path == null) return;
        $this->image_list = glob($path);
        $this->LoadImages($this->image_list);
    }

    /**
     * Start the processing party!
     */
    public function Run()
    {
        $this->RunFilters();
        $this->SaveImages();
    }


}

