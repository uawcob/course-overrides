<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Cache;

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

    public static function jsDatatable()
    {
        return Cache::rememberForever('schedules', function(){
            $schedules = Schedule::all()->map(function(Schedule $schedule){
                $link = '<a class="btn btn-default" href="%s">View</a>';
                $row['link'] = sprintf($link, route('schedules.show', $schedule));

                $row['start'] = "{$schedule->start}";
                $row['finish'] = "{$schedule->finish}";

                $semester = Semester::createFromStrm($schedule->strm);
                $row['semester'] = $semester->term();
                $row['year'] = $semester->year();

                return $row;
            });
            return str_replace('\\', '\\\\', json_encode($schedules));
        });
    }

    public static function upcomingWelcomeLis()
    {
        return Cache::rememberForever('upcomingWelcomeLis', function(){
            return Schedule::where('finish', '>', new Carbon)
                ->orderBy('start')
                ->get()
                ->map(function(Schedule $schedule){
                    $semester = Semester::createFromStrm($schedule->strm);
                    $semester = "{$semester->term()} {$semester->year()}";

                    $start  = $schedule->start ->format('l, F jS Y, g:i:s A');
                    $finish = $schedule->finish->format('l, F jS Y, g:i:s A');

                    $li = '<li>%s<br>Open %s<br>Close %s</li>';
                    return sprintf($li, $semester, $start, $finish);
                })
                ->implode('');
        });
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
