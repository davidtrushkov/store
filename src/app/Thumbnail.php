<?php

namespace App;

use Image;

class Thumbnail {


    /**
     * Make a Photo Thumbnail of the product images
     *
     * @param $src
     * @param $destination
     */
    public function make($src, $destination) {
        Image::make($src)
            ->fit(200)
            ->save($destination);
    }

}