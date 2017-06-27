<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;
use App\RazorbackApi\Plans\PlansApiClient;
use Auth;

class PlanController extends Controller
{
    public function index()
    {
        $student_id = Auth::user()->student_id;
        $endpoint = config('razorbacksapi.plans.endpoint');
        $token = config('razorbacksapi.plans.token');
        return (new PlansApiClient($endpoint, $token))->get($student_id);
    }

    public function requests()
    {
        $data = [
            'plans' => $this->index(),
        ];

        return view('requests.index', $data);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        //
    }
}
