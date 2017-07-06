<?php

namespace App;

use Cache;
use Datatables;

class CoursesRepository
{
    public function dtJson(string $strm = null)
    {
        if (is_null($strm)) {
            $strm = Schedule::openStrm();
        }

        $key = "courses$strm";

        return Cache::rememberForever($key, function () use ($strm) {
            return Datatables::collection(Course::where('semester', $strm)->get())
            ->addColumn('add', function (Course $course) {
                $link = '<button id="btn-cart-add-%u" class="btn-cart btn btn-success" data-url="%s">Add</button>';
                return sprintf($link, $course->id, route('cart.add', $course));
            })
            ->rawColumns(['add'])
            ->make(true);
        });
    }

    public function refresh(string $strm)
    {
        Cache::forget("courses$strm");
    }
}
