<?php

namespace App\Models\Log;

use App\Filters\ApiLog\ApiLogFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\Model;

class ErrorLog extends Model
{
    protected $collection = 'error_logs';
    protected $connection = 'mongodb';
    protected $table = 'error_logs';

    protected $guarded = [];

    protected $dates = ['datetime'];

    public function scopeFilter(Builder $builder, Request $request, array $filters = [])
    {
        return (new ApiLogFilters($request))->add($filters)->filter($builder);
    }
}
