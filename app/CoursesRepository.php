<?php

namespace App;

use Cache;
use Datatables;

class CoursesRepository
{
    public function dtJson($strm = null)
    {
        if (empty($strm)) {
            $strm = Schedule::openStrm();
        }

        $key = "courses$strm";

        return Cache::rememberForever($key, function () use ($strm) {
            return Datatables::collection(
                Course::where('semester', $strm)
                ->where('enabled', true)
                ->get()
            )
            ->addColumn('add', function (Course $course) {
                $link = '<button id="btn-cart-add-%u" class="btn-cart btn btn-cart-add btn-success" data-url="%s" data-add="1" data-courseid="%u">Add</button>';
                return sprintf($link, $course->id, route('cart.add', $course), $course->id);
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
