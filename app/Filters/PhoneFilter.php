<?php

namespace App\Filters;

class PhoneFilter
{
    /**
     * Create a new class instance.
     */
    public function apply($query, $filters)
    {
        
        if (isset($filters['model'])) {
            $query->where('model', $filters['model']);
        }
        if (isset($filters['name'])) {
            $query->where('name', $filters['name']);
        }
        
        if (isset($filters['price'])) {
            $query->where('price', $filters['price']);
        }
        return $query;
    }
}
    

