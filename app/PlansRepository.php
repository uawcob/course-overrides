<?php

namespace App;

use App\RazorbackApi\Plans\PlansApiClient;
use Auth;
use Exception;

class PlansRepository
{
    protected $plans = [];

    public function get() : array
    {
        if (empty($this->plans)) {
            $this->refresh();
        }

        return $this->plans;
    }

    public function refresh()
    {
        $student_id = Auth::user()->student_id;
        $endpoint = config('razorbacksapi.plans.endpoint');
        $token = config('razorbacksapi.plans.token');

        $this->plans = (new PlansApiClient($endpoint, $token))->get($student_id);

        if (is_null($this->plans)) {
            throw new Exception("Plans API Client returned NULL response.");
        }
    }
}
