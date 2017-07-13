<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use App\Semester;
use App\RazorbackApi\Courses\CoursesApiClient;
use App\CoursesRepository;
use App\UpcomingTerm;
use App\Note;

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
        $data = [
            'notes' => Note::forContext('courses'),
            'route' => route('courses.data'),
            'year' => UpcomingTerm::get(date('Y-m-d'))['year'],
            'semesterOptions' => UpcomingTerm::getTermOptions(date('Y-m-d')),
        ];

        return view('courses.index', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function term(Request $request)
    {
        $strm = new Semester($request->semester, $request->year);

        $data = [
            'route' => route('courses.data')."?strm=$strm",
            'year' => $request->year,
            'semesterOptions' => UpcomingTerm::getTermOptions($request->semester),
        ];

        return view('courses.index', $data);
    }

    public function data(Request $request)
    {
        $this->authorize('view', Course::class);

        return $this->courses->dtJson($request->strm);
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

        $this->courses->refresh($request->strm);

        return redirect(route('courses.show', $course));
    }

    public function refresh(Request $request)
    {
        $semester = new Semester($request->semester, $request->year);

        if (!$semester instanceof Semester) {
            return response('invalid semester', 404);
        }

        $this->courses->refresh($semester->string());

        $query = "?semester={$semester->term()}&year={$semester->year()}";

        return redirect(route('courses.term').$query);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $data = [
            'notes' => Note::forContext($course->code),
            'course' => $course,
        ];

        return view('courses.show', $data);
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
