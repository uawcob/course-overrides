<?php

namespace App;

use App\RazorbackApi\Plans\PlansApiClient;
use Auth;
use Exception;

class PlansRepository
{
    public function get() : array
    {
        if (empty($plans = session('plans'))) {
            return $this->query();
        }

        return $plans;
    }

    public function refresh()
    {
        $user = Auth::user();
        $student_id = $user->student_id;
        $endpoint = config('razorbacksapi.plans.endpoint');
        $token = config('razorbacksapi.plans.token');

        $plans = (new PlansApiClient($endpoint, $token))->get($student_id);

        if (is_null($plans)) {
            throw new Exception('Plans API Client returned NULL response.');
        }

        foreach ($plans as $plan) {
            foreach ($plan as $type => $name) {
                $data []= new Plan([
                    'type' => $type,
                    'name' => $name,
                ]);
            }
        }

        if (!empty($data)) {
            foreach ($user->plans as $plan) {
                $plan->delete();
            }
            $user->plans()->saveMany($data);
        }

        session(['plans' => $plans]);

        return $plans;
    }

    protected function query()
    {
        $plans = Auth::user()->plans()->get()->map(function($plan){
            return [$plan->type => $plan->name];
        })->toArray();

        if (empty($plans)) {
            return $this->refresh();
        }

        session(['plans' => $plans]);

        return $plans;
    }
}
