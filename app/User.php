<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use StudentAffairsUwm\Shibboleth\Entitlement;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'student_id',
        'email',
        'password',
        'graduation_strm',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The entitlements that belong to the user.
     */
    public function entitlements()
    {
        return $this->belongsToMany(Entitlement::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function intendedPlans()
    {
        return $this->belongsToMany(IntendedPlan::class);
    }

    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function isAdmin() : bool
    {
        return Entitlement::has(config('admin.entitlement'));
    }

    // hack fix for SQL Server date format .000
    protected function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }
}
