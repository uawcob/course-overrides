<?php

namespace App\Http\Controllers;

use App\IntendedPlan;
use Illuminate\Http\Request;

class IntendedPlanController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(IntendedPlan::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return IntendedPlan::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $intendedPlan = IntendedPlan::create($request->all());

        return redirect(route('intended-plans.show', $intendedPlan));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IntendedPlan  $intendedPlan
     * @return \Illuminate\Http\Response
     */
    public function show(IntendedPlan $intendedPlan)
    {
        return $intendedPlan;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IntendedPlan  $intendedPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(IntendedPlan $intendedPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IntendedPlan  $intendedPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IntendedPlan $intendedPlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IntendedPlan  $intendedPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(IntendedPlan $intendedPlan)
    {
        //
    }
}
