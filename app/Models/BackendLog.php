<?php


namespace App\Models;

use App\Filters\BackendLog\BackendLogFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class BackendLog extends Activity implements AuditableContract
{
    use Auditable;
    // public function scopeFilter(Builder $builder, Request $request, array $filters = [])
    // {
    //     return (new BackendLogFilters($request))->add($filters)->filter($builder);
    // }
}
