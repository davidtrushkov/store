<?php

namespace App\Http\Utilities;

class Gender {

    /**
     * Array of genders.
     *
     * @var array
     */
    protected static $genders = [

        ""       => "",
        "Male"   => "Male",
        "Female" => "Female",

    ];


    /**
     * Return all the genders.
     *
     * @return array
     */
    public static function all() {
        return array_keys(static::$genders);
    }

}