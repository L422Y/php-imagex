<?php
use lawrencealan\ImagexFilter;

/**
 * Custom filters
 * User: larry
 */

class filter_blackwhite extends ImagexFilter
{
    public $title = "Black and White";

    function filter()
    {
        $iw = imagesx($this->img);
        $ih = imagesy($this->img);

        for ($x = 0; $x < $iw; $x++) {
            for ($y = 0; $y < $ih; $y++) {
                $col = imagecolorsforindex($this->img, imagecolorat($this->img, $x, $y));
                $replace = floor(($col['red'] + $col['green'] + $col['blue']) / 3);
                imagesetpixel(
                    $this->img, $x, $y,
                    imagecolorallocate($this->img,
                        $replace, $replace, $replace
                    )
                );
            }
        }
    }
}

class filter_invert extends ImagexFilter
{
    public $title = "Invert";

    function filter()
    {
        $iw = imagesx($this->img);
        $ih = imagesy($this->img);

        for ($x = 0; $x < $iw; $x++) {
            for ($y = 0; $y < $ih; $y++) {
                $col = imagecolorsforindex($this->img, imagecolorat($this->img, $x, $y));
                imagesetpixel(
                    $this->img, $x, $y,
                    imagecolorallocate($this->img,
                        255-$col['red'], 255-$col['green'],255-$col['blue']
                    )
                );
            }
        }
    }
}
