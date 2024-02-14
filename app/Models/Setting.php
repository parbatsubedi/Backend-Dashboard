<?php

namespace App\Models;

use App\Traits\StoreSetting;
use App\Traits\UploadImage;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use StoreSetting, UploadImage;

    protected static $logAttributes = ['*'];
    //protected static $logOnlyDirty = true;
    protected static $logName = 'Setting';
    protected $connection = "mysql";

    protected $fillable = [
      'option',
      'value'
    ];
}
