<?php

namespace App;

use Carbon\Carbon;

class UpcomingTerm
{
    protected static $cutoffs = [
        'January'   => 'spring',
        'February'  => 'summer',
        'March'     => 'summer',
        'April'     => 'summer',
        'May'       => 'summer',
        'June'      => 'fall',
        'July'      => 'fall',
        'August'    => 'fall',
        'September' => 'spring',
        'October'   => 'spring',
        'November'  => 'spring',
        'December'  => 'spring',
    ];

    public static function get(string $date) : array
    {
        $date = new Carbon($date);

        $month = $date->format('F');
        $year = (int)$date->format('Y');

        $return['term'] = static::$cutoffs[$month];

        if ('spring' === $return['term']) {
            $return['year'] = $year + 1;
        } else {
            $return['year'] = $year;
        }

        if ('January' === $month) {
            $return['year']--;
        }

        return $return;
    }
}
