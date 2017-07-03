<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedule extends Model
{
    protected $fillable = [
        'strm',
        'start',
        'finish',
    ];

    public function semester() : string
    {
        return (Semester::createFromStrm($this->strm))->canonical();
    }

    // hack fix for SQL Server date format .000
    protected function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }

    public function getStartAttribute($value)
    {
        return (new Carbon($value))->timezone('America/Chicago');
    }

    public function setStartAttribute($value)
    {
        $this->attributes['start'] = (new Carbon($value, 'America/Chicago'))->setTimezone('UTC');
    }

    public function getFinishAttribute($value)
    {
        return (new Carbon($value))->timezone('America/Chicago');
    }

    public function setFinishAttribute($value)
    {
        $this->attributes['finish'] = (new Carbon($value, 'America/Chicago'))->setTimezone('UTC');
    }
}
