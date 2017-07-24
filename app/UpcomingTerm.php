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

    public static function getTermOptions(string $date) : string
    {
        $date = strtolower($date);

        if (in_array($date, ['spring', 'summer', 'fall'])) {
            $selected = $date;
        } else {
            $selected = static::get($date)['term'];
        }

        $options = '';

        foreach (['Spring', 'Summer', 'Fall'] as $term) {
            if (strtolower($term) === $selected) {
                $options .= "<option selected>$term</option>";
            } else {
                $options .= "<option>$term</option>";
            }
        }

        return $options;
    }

    public static function getGraduationYearOptions(string $date, int $count = 6) : string
    {
        if ($count < 1) {
            throw new \Exception("Graduation year count must be more than zero.");
        }

        $year = static::get($date)['year'];

        $options = '';
        while ($count--) {
            $options .= "<option>$year</option>";
            $year++;
        }
        return $options;
    }
}
