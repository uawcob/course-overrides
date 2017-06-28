<?php

namespace App\Http\Controllers;

use App\Request as Req;
use Illuminate\Http\Request;
use DB;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Req::class, 'req');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        return redirect(route('requests.show', $req));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Req  $req
     * @return \Illuminate\Http\Response
     */
    public function show(Req $req)
    {
        $req->courses;
        return $req;
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
