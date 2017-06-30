<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'strm',
        'start',
        'finish',
    ];

    // hack fix for SQL Server date format .000
    protected function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }
}
