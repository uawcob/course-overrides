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
}