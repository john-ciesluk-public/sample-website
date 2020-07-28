<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Property;

class ProductRequest extends FormRequest
{
    private $filterOptions;

    public function authorize()
    {
        return true;
    }

    public function rules() {
        return array();
    }

    public function getVfgOptions()
    {
        if ($this->has('Year') && $this->has('Make') && $this->has('Model')) {
            return $this->only([ 'Year', 'Make', 'Model', 'Submodel', 'TrimOption' ]);
        } else {
            return array();
        }
    }

    public function getFilterOptions()
    {
        if (!$this->filterOptions) {
            $codes = Property::filterable()
                ->pluck('code')
                ->toArray();

            $this->filterOptions = $this->intersect($codes);
        }

        return $this->filterOptions;
    }

    public function cacheKey($label)
    {
        return $label . ':' . serialize([
            'path' => $this->path(),
            'parameters' => $this->all(),
        ]);
    }
}
