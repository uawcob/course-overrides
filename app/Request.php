<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = [
        'enrolled',
        'required',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class)->withPivot('priority');
    }

    // hack fix for SQL Server date format .000
    protected function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }
}
