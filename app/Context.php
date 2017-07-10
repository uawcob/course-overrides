<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Context extends Model
{
    protected $fillable = [
        'key',
    ];

    public function note()
    {
        return $this->belongsTo(Note::class);
    }

    public static function common()
    {
        return [
            'welcome',
            'courses',
            'cart',
            'request',
        ];
    }
}
