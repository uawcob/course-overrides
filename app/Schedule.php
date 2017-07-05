<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedule extends Model
{
    protected static $cache;
    protected $fillable = [
        'strm',
        'start',
        'finish',
    ];

    public static function isOpen(string $datetime = null) : bool
    {
        return is_string(static::openStrm($datetime ?? ''));
    }

    public static function openStrm(string $datetime = null)
    {
        $key = "$datetime";
        if (empty($datetime)) {
            $datetime = Carbon::now();
            $key = 'now';
        }

        return static::$cache[$key] ?? static::$cache[$key] =
            static::where('finish', '>', $datetime)
                ->where('start', '<', $datetime)
                ->first()
                ->strm ?? false;
    }

    public static function flushCache()
    {
        static::$cache = null;
    }

    public function semester() : string
    {
        return (Semester::createFromStrm($this->strm))->canonical();
    }

    public function term() : string
    {
        return (Semester::createFromStrm($this->strm))->term();
    }

    public function year() : int
    {
        return (Semester::createFromStrm($this->strm))->year();
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
