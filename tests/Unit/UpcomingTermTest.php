<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\UpcomingTerm;

class UpcomingTermTest extends TestCase
{
    public function upcomingTermsDataProvider()
    {
        return [
            ['2017-06-13', ['term' => 'fall',   'year' => 2017]],
            ['2016-12-01', ['term' => 'spring', 'year' => 2017]],
            ['2017-08-30', ['term' => 'fall',   'year' => 2017]],
            ['2017-09-01', ['term' => 'spring', 'year' => 2018]],
            ['2017-02-01', ['term' => 'summer', 'year' => 2017]],
            ['2017-01-31', ['term' => 'spring', 'year' => 2017]],
        ];
    }

    /**
     * @dataProvider upcomingTermsDataProvider
     */
    public function test_returns_upcoming_term(string $date, array $expected)
    {
        $actual = UpcomingTerm::get($date);
        $this->assertEquals($expected, $actual);
    }
}
