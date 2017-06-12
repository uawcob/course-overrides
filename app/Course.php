<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $semester;

    protected $fillable = [
        'number',
        'CourseID',
        'section',
        'title',
        'time',
        'note',
    ];

    public function semester(Semester $semester)
    {
        $this->semester = $semester;
    }
}
