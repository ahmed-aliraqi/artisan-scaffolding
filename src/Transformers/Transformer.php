<?php

namespace Aliraqi\Artisan\Scaffolding\Transformers;

use Illuminate\Pagination\LengthAwarePaginator;

abstract class Transformer
{
    /**
     * Transform a collection of items.
     *
     * @param \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator $items
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|array
     */
    public function collection($items)
    {
        $map = $items->map(function ($item) {
            return $this->model($item);
        })->toArray();

        // Determine if items is a paginator instance.
        if ($items instanceof LengthAwarePaginator) {
            $map = paginate($map, $items->perPage());
        }

        return $map;
    }

    /**
     * Transform a model instance.
     *
     * @param $item
     *
     * @return array
     */
    abstract public function model($model);
}
