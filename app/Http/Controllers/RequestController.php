<?php

namespace App\Http\Controllers;

use App\Request as Req;
use Illuminate\Http\Request;
use DB;
use App\PlansRepository;
use Auth;
use App\Note;
use Validator;

class RequestController extends Controller
{
    protected $plans;

    public function __construct(PlansRepository $plans)
    {
        $this->plans = $plans;
        $this->authorizeResource(Req::class, 'req');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'requests' => $this->getRequests(),
            'notes' => Note::forContext('request-index'),
        ];

        return view('requests.index', $data);
    }

    public function getRequests(bool $cache = true)
    {
        if ($cache && !empty($requests = session('requests'))) {
            return $requests;
        }

        $requests = $this->data()->map(function(Req $request){
            $class = $request->courses->first();
            $link = '<a class="btn btn-default" href="%s">View</a>';
            $link = sprintf($link, route('requests.show', $request));
            return [
                'class' => "{$class->code} - {$class->title}",
                'created_at' => "{$request->created_at}",
                'updated_at' => "{$request->updated_at}",
                'link' => $link,
            ];
        });

        // escape backslashes for embedding JS string in HTML
        $requests = str_replace('\\', '\\\\', json_encode($requests));

        session(['requests' => $requests]);

        return $requests;
    }

    public function data()
    {
        return Req::with('courses')->where('user_id', Auth::user()->id)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (empty(session('cart'))) {
            return redirect(route('courses.index'));
        }

        foreach (session('cart') as $course) {
            $data[$course->code]['code'] = $course;
            $data[$course->code]['sections'] []= $course;
        }

        $data = [
            'courses' => current($data),
            'plans' => $this->plans->get(),
            'notes' => Note::forContext(current($data)['code']->code, 'request-create'),
        ];

        return view('requests.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make([
            'graduation_strm' => Auth::user()->graduation_strm,
        ], [
            'graduation_strm' => 'required',
        ], [
            'graduation_strm' => 'Graduation date is required.'
        ]);

        if ($validator->fails()) {
            flash('Graduation date is required.')->error();
            return redirect(route('requests.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $req = Req::make($request->all());

        $request->user()->requests()->save($req);

        foreach ($request->id as $priority => $course) {
            $courses[$course] = ['priority' => $priority];
        }

        $req->courses()->sync($courses);

        foreach ($request->id as $course) {
            session()->forget("cart.$course");
        }

        // refresh the cache
        $this->getRequests($cache = false);

        flash('New override request submitted successfully!')->success();

        return redirect(route('requests.show', $req));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Req  $req
     * @return \Illuminate\Http\Response
     */
    public function show(Req $req, Request $request)
    {
        $req->courses = $req->courses()->orderBy('priority')->get();

        if ($request->has('json')) {
            return $req;
        }

        $data = [
            'class' => $req->courses->first(),
            'request' => $req,
            'notes' => Note::forContext('request-show'),
        ];

        return view('requests.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Req  $req
     * @return \Illuminate\Http\Response
     */
    public function edit(Req $req)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Req  $req
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Req $req)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Req  $req
     * @return \Illuminate\Http\Response
     */
    public function destroy(Req $req)
    {
        $req->delete();

        // refresh the cache
        $this->getRequests($cache = false);

        return 'Request Deleted';
    }
}
