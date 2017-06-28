<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $semester;

    protected $fillable = [
        'number',
        'code',
        'section',
        'title',
        'time',
    ];

    public function semester(Semester $semester)
    {
        $this->semester = $semester;
    }

    public function requests()
    {
        return $this->belongsToMany(Request::class);
    }

    // hack fix for SQL Server date format .000
    protected function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }
}
