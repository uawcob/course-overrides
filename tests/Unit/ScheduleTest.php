<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Schedule;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;

class ScheduleTest extends TestCase
{
    use DatabaseMigrations;

    public function scheduleDataProvider()
    {
        $chicago = function(){
            return (new Carbon)->timezone('America/Chicago');
        };

        return [
            ['2017-06-30 08:00:00', '2017-07-01 17:00:00', '2017-07-01 18:00:00', true],
            [$chicago()->subMonth(), $chicago()->addMonth(), new Carbon, true],
            [$chicago()->subHour(), $chicago()->addHour(), new Carbon, true],
            [$chicago()->subHour(), $chicago()->addHour(), $chicago(), false],
        ];
    }

    /**
     * @dataProvider scheduleDataProvider
     */
    public function test_returns_open($start, $finish, $test, $expected)
    {
        Schedule::create([
            'strm' => '1179',
            'start' => $start,
            'finish' => $finish,
        ]);

        $this->assertSame($expected, Schedule::isOpen($test));
    }
}
