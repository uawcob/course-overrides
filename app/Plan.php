<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'type',
        'name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
