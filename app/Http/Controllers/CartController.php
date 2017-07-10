<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Datatables;
use App\Note;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'notes' => Note::forContext('cart'),
        ];

        return view('cart.index', $data);
    }

    public function data()
    {
        if (empty(session('cart'))) {
            return ['data'=>[]];
        }

        return Datatables::collection(session('cart'))
            ->addColumn('remove', function (Course $course) {
                $link = '<button class="btn-cart btn btn-danger" data-url="%s">Remove</button>';
                return sprintf($link, route('cart.remove', $course));
            })
            ->rawColumns(['remove'])
            ->make(true);
    }

    /**
     * Add a course to the shopping cart.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function add(Course $course)
    {
        session(["cart.{$course->id}" => $course]);

        return response(null, 204);
    }

    /**
     * Remove the course from the cart.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function remove(Course $course)
    {
        session()->forget("cart.{$course->id}");

        return response(null, 204);
    }
}
