<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Cart;
use Datatables;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cart.index');
    }

    public function data()
    {
        if (empty(Cart::count())) {
            return ['data'=>[]];
        }

        return Datatables::collection(
                Cart::content()->map(function ($item) {
                    return $item->model;
                })
            )->addColumn('remove', function (Course $course) {
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
        Cart::add($course->id, $course->code, 1, 0)->associate(Course::class);
    }

    /**
     * Remove the course from the cart.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function remove(Course $course)
    {
        $items = Cart::search(function ($item) use ($course) {
            return $item->id === $course->id;
        });

        foreach ($items as $item) {
            Cart::remove($item->rowId);
        }
    }
}
