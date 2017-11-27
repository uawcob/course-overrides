<?php

namespace App\Policies;

use App\User;
use App\IntendedPlan;
use Illuminate\Auth\Access\HandlesAuthorization;

class IntendedPlanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the intendedPlan.
     *
     * @param  \App\User  $user
     * @param  \App\IntendedPlan  $intendedPlan
     * @return mixed
     */
    public function view(User $user, IntendedPlan $intendedPlan)
    {
        return true;
    }

    /**
     * Determine whether the user can create intendedPlans.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the intendedPlan.
     *
     * @param  \App\User  $user
     * @param  \App\IntendedPlan  $intendedPlan
     * @return mixed
     */
    public function update(User $user, IntendedPlan $intendedPlan)
    {
        //
    }

    /**
     * Determine whether the user can delete the intendedPlan.
     *
     * @param  \App\User  $user
     * @param  \App\IntendedPlan  $intendedPlan
     * @return mixed
     */
    public function delete(User $user, IntendedPlan $intendedPlan)
    {
        //
    }
}
