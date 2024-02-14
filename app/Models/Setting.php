<?php

namespace App\Models;

use App\Traits\StoreSetting;
use App\Traits\UploadImage;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Setting extends Model implements AuditableContract
{
    use StoreSetting, UploadImage, Auditable;

    protected static $logAttributes = ['*'];
    //protected static $logOnlyDirty = true;
    protected static $logName = 'Setting';
    protected $connection = "mysql";

    protected $fillable = [
      'option',
      'value'
    ];
}
