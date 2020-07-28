<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{

    /**
     *
     * Gets filters by type
     * @return (object) $filters
     *
     */
    public function getFilters($type,$filters = false)
    {
        switch ($type) {
        case 'many':
            $filters = Filter::whereIn('filter',$filters)->get();
            break;
        case 'one':
            $filters = Filter::where('filter',$filters)->firstOrFail();
            break;
        case 'all':
            $filters = Filter::orderBy('name','asc')->get();
            break;
        }

        return $filters;
    }

    /**
     *
     * Gets filters by category
     * @return (object) $filters
     *
     */
    public function getFiltersByCategory($category)
    {
        return Filter::orderBy('name','asc')->where('website_categories_id',$category)->get();
    }

    /**
    * Makes the filters html
    *
    * @return string $filters
    *
    */
    public function makeFilters($f,$currentFilters = false)
    {
        $filters = '';
        if ($f) {
            $filters .= '<div class="filter-group feature-filters">';
            $filters .= '<ul class="filter-group-content">';
            foreach ($f as $filter) {
                $filters .= '<li><input class="filter-option" type="checkbox" name="filters[]" value="'.$filter->filter.'"';
                if ($currentFilters && in_array($filter->filter,$currentFilters)) {
                    $filters .= ' checked="checked" ';
                }
                $filters .= '/>';
                $filters .= '<label for="'.$filter->filter.'">'.$filter->name.'</label></li>';
            }
            $filters .= '</ul></div>';
        }
        return $filters;
    }
}
