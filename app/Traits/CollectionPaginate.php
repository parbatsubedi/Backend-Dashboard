<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Relation for the user
 */
trait CollectionPaginate
{
    public function collectionPaginate($length, $collection, $request, $pageName = 'page')
    {
        $page = request()->get($pageName, 1); // Get the ?page=1 from the url
        $offset = ($page * $length) - $length;

        return  new LengthAwarePaginator(
            $collection->slice($offset, $length),
            count($collection), // Total items
            $length, // Items per page
            $page, // Current page
            ['pageName' => $pageName, 'path' => $request->url()/*, 'query' => $request->query()*/] // We need this so we can keep all old query parameters from the url
        );
    }
}
