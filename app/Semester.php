<?php

namespace App;

use App\Exceptions\InvalidSemester;

class Semester
{
    public static function strm(string $term, int $year) : string
    {
        if ($year < 1945) {
            // schedule of classes not available before World War II
            throw new InvalidSemester("invalid year: $year");
        }

        $prefix = $year - 1900;

        if ($prefix < 100) {
            // strm requires leading zero
            $prefix = "0{$prefix}";
        }

        switch(strtolower($term)) {
            case 'spring':
                return "{$prefix}3";
            case 'summer':
                return "{$prefix}6";
            case 'fall':
                return "{$prefix}9";
        }

        throw new InvalidSemester("invalid semester: $term, $year");
    }
}
