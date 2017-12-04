<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseRequest extends Model
{
    protected $table = 'course_request';
    public $timestamps = false;

    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
