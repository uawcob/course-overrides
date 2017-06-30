<?php

namespace App\Http\Controllers;

use App\Request as Req;
use Illuminate\Http\Request;
use DB;
use App\PlansRepository;
use Auth;

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
        return view('requests.index', ['requests' => $this->getRequests()]);
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
        foreach (session('cart') ?? [] as $course) {
            $data[$course->code]['code'] = $course;
            $data[$course->code]['sections'] []= $course;
        }

        $data = [
            'courses' => current($data ?? []),
            'plans' => $this->plans->get(),
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
        //
    }
}
