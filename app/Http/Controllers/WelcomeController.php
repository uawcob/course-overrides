<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Schedule;

class WelcomeController extends Controller
{
    public function index()
    {
        $schedules = Schedule::upcomingWelcomeLis();

        return view('welcome', compact('schedules'));
    }
}
