<?php

namespace App;

use App\RazorbackApi\Plans\PlansApiClient;
use Auth;

class PlansRepository
{
    public function get()
    {
        $student_id = Auth::user()->student_id;
        $endpoint = config('razorbacksapi.plans.endpoint');
        $token = config('razorbacksapi.plans.token');
        return (new PlansApiClient($endpoint, $token))->get($student_id);
    }
}
