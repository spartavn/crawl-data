<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Page extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = [
        'path',
'title',
'data'
    ];
}
