<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntendedPlan extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'category',
        'abbr',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // hack fix for SQL Server date format .000
    protected function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }
}
