<?php

namespace App;

class Common
{
    /**
     *
     * Textile generator
     *
     */
    public static function textile($markup)
    {
        return app('textile')->parse($markup);
    }
    
    /**
     *
     * Objectify json data
     *
     */
    public static function objectify($data)
    {
        return json_decode(json_encode($data));
    }
}
