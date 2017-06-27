<?php

namespace App;

use App\RazorbackApi\Plans\PlansApiClient;
use Auth;
use Exception;

class PlansRepository
{
    public function get() : array
    {
        if (empty(session('plans'))) {
            $this->refresh();
        }

        return session('plans');
    }

    public function refresh()
    {
        $student_id = Auth::user()->student_id;
        $endpoint = config('razorbacksapi.plans.endpoint');
        $token = config('razorbacksapi.plans.token');

        $plans = (new PlansApiClient($endpoint, $token))->get($student_id);

        if (is_null($plans)) {
            throw new Exception('Plans API Client returned NULL response.');
        }

        session(['plans' => $plans]);
    }
}
