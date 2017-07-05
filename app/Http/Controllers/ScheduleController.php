<?php

namespace App\Http\Controllers;

use App\{
    Schedule,
    Semester
};
use Illuminate\Http\Request;
use App\Http\Middleware\Admin;
use Cache;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware(Admin::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = Schedule::jsDatatable();

        return view('schedules.index', ['schedules' => $schedules]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $semester = new Semester($request->term, $request->year);

        $data = array_merge($request->all(), ['strm' => (string)$semester]);

        $schedule = Schedule::create($data);

        Cache::forget('schedules');

        return redirect(route('schedules.show', $schedule));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        return view('schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        return view('schedules.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        $semester = new Semester($request->term, $request->year);

        $data = array_merge($request->all(), ['strm' => (string)$semester]);

        $schedule->update($data);

        Cache::forget('schedules');

        return redirect(route('schedules.show', $schedule));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        Cache::forget('schedules');

        return redirect(route('schedules.index'));
    }
}
