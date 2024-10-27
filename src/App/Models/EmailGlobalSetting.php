<?php

namespace Shaz3e\EmailTemplates\App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailGlobalSetting extends Model
{
    protected $fillable = [
        'name',
        'value',
    ];
}
