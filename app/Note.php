<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at',
    ];

    protected $fillable = [
        'body',
        'sensitivity',
    ];

    // hack fix for SQL Server date format .000
    protected function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }

    public function getSensitivityOptions() : string
    {
        $html = '';

        foreach (['success', 'info', 'warning', 'danger'] as $sensitivity) {
            $selected = ($this->attributes['sensitivity'] === $sensitivity)
                ? ' selected'
                : '';

            $html .= "<option value=\"$sensitivity\"$selected>$sensitivity</option>";
        }

        return $html;
    }

    public function contexts()
    {
        return $this->hasMany(Context::class);
    }

    public static function forContext(string ...$keys)
    {
        return static::join('contexts', 'notes.id', '=', 'contexts.note_id')
            ->whereIn('key', $keys)->get();
    }
}
