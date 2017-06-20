<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Semester;

class SemesterTest extends TestCase
{
    public function strmDataProvider()
    {
        return [
            ['spring', 2017, '1173'],
            ['Summer', 2017, '1176'],
            ['Fall',   2017, '1179'],
            ['Fall',   2099, '1999'],
            ['Fall',   2100, '2009'], // century boundary condition (not actual century)
            ['Fall',   2101, '2019'],
            ['fall', '2018', '1189'],
            ['spring', 1999, '0993'],
        ];
    }

    /**
     * @dataProvider strmDataProvider
     */
    public function test_returns_strm_for_semester(string $term, int $year, string $expected)
    {
        $actual = Semester::strm($term, $year);

        $this->assertSame($expected, $actual);
    }

    public function invalidStrmDataProvider()
    {
        return [
            ['Winter', 2017],
            ['Spring', -217],
        ];
    }

    /**
     * @dataProvider invalidStrmDataProvider
     * @expectedException \App\Exceptions\InvalidSemester
     */
    public function test_invalidates_semester(string $term, int $year)
    {
        Semester::strm($term, $year);
    }

    /**
     * @dataProvider strmDataProvider
     */
    public function test_creates_semester_from_strm(string $term, int $year, string $strm)
    {
        $semester = Semester::createFromStrm($strm);
        $this->assertSame(strtolower($term), strtolower($semester->term()));
        $this->assertSame($year, $semester->year());
    }
}
