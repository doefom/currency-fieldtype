<?php

namespace Doefom\CurrencyFieldtype\Filters;

use Statamic\Query\Scopes\Filters\Fields\FieldtypeFilter;
use Statamic\Query\Scopes\Filters\Fields\Number as NumberFilter;

class CurrencyFilter extends NumberFilter
{
    protected function valueFieldtype()
    {
        return 'currency';
    }

    public function apply($query, $handle, $values)
    {
    	if($this->fieldtype->usesSubUnitStorage()){
    		$values['value'] *= 100;
    	}

    	return parent::apply($query, $handle, $values);
    }
}