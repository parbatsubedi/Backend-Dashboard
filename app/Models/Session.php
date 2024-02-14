<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'sessions';
    protected $connection = 'mysql';


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }
}
