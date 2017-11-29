<?php

namespace App\Http\Controllers;

use App\User;
use App\IntendedPlan;
use Illuminate\Http\Request;
use Auth;

class IntendedPlanUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user()->intendedPlans()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IntendedPlan $intendedPlan)
    {
        Auth::user()->intendedPlans()->attach($intendedPlan);
        return response()->json(null, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IntendedPlanUser  $intendedPlanUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(IntendedPlan $intendedPlan)
    {
        Auth::user()->intendedPlans()->detach($intendedPlan);
        return response()->json(null, 204);
    }
}
