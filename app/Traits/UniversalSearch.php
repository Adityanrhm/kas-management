<?php

namespace App\Traits;

trait UniversalSearch
{
    public function scopeSearch($query, $keyword, array $fields = [], $operator = 'ILIKE')
    {
        if (empty($keyword) || empty($fields)) {
            return $query;
        }

        return $query->where(function ($mainQuery) use ($keyword, $fields, $operator) {
            foreach ($fields as $field) {
                if (str_contains($field, '.')) {
                    // Field berelasi
                    $fieldParts = explode('.', $field);
                    $finalField = array_pop($fieldParts);
                    $relationPath = implode('.', $fieldParts);

                    $mainQuery->orWhereHas($relationPath, function ($relationQuery) use ($keyword, $finalField, $operator) {
                        $relationQuery->where($finalField, $operator, "%$keyword%");
                    });
                } else {
                    // Field langsung
                    $mainQuery->orWhere($field, $operator, "%$keyword%");
                }
            }
        });
    }
}
