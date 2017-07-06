<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use App\Semester;
use App\RazorbackApi\Courses\CoursesApiClient;
use Cache;
use App\CoursesRepository;

class CourseController extends Controller
{
    protected $courses;

    public function __construct(CoursesRepository $courses)
    {
        $this->authorizeResource(Course::class);
        $this->courses = $courses;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('courses.index');
    }

    public function data()
    {
        $this->authorize('view', Course::class);

        return $this->courses->dtJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('courses.create');
    }

    public function fetch(Request $request)
    {
        $this->authorize('create', Course::class);

        $semester = new Semester($request->term, $request->year);

        $api = new CoursesApiClient($semester);

        return $api->get($request->number);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $course = Course::make($request->all());
        $course->semester = Semester::createFromStrm($request->strm);
        $course->save();

        Cache::forget('courses');

        return redirect(route('courses.show', $course));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return $course;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }
}
