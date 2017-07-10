<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Schedule;
use App\Note;

class WelcomeController extends Controller
{
    public function index()
    {
        $data = [
            'schedules' => Schedule::upcomingWelcomeLis(),
            'notes' => Note::forContext('welcome'),
        ];

        return view('welcome', $data);
    }
}
