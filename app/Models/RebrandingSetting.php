<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RebrandingSetting extends Model
{

    protected $table = "rebranding_setting";

    protected $fillable = ['site_title', 'logo','favicon', 'smtp_email', 'smtp_password', 'primary_color', 'secondary_color', 'text_color', 'button_text_color', 'hover_color', 'global_text_color'];
}
