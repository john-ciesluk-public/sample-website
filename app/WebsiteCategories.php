<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteCategories extends Model
{
    public $timestamps = false;

    /**
      *
      * returns a website category by name
      *
      */
    public function getCategoryByName($name)
    {
        return WebsiteCategories::where('category',$name)->firstOrFail();
    }

    /**
      *
      * returns a website category by name
      *
      */
    public function getCategories($siteId)
    {
        return WebsiteCategories::where('website_id',$siteId)->orderBy('name','asc')->get();
    }
}
