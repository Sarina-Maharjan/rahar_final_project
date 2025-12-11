<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Country extends Model
{



    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'iso2',
        'phone_code',
        'zip_format',
        'currency',
        'currency_code',
        'currency_symbol',
    ];


}
