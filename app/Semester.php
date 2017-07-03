<?php

namespace App;

use App\Exceptions\InvalidSemester;

class Semester implements \JsonSerializable
{
    protected $term;
    protected $year;

    public function __construct(string $term = null, int $year = null)
    {
        if (isset($term)) {
            $this->term($term);
        }

        if (isset($year)) {
            $this->year($year);
        }
    }

    public static function createFromStrm(string $strm) : Semester
    {
        if (strlen($strm) !== 4) {
            throw new InvalidSemester("strm must be 4 characters in length: $strm");
        }

        if (!is_numeric($strm)) {
            throw new InvalidSemester("strm must be numeric: $strm");
        }

        $term = static::strmToTerm($strm);
        $year = static::strmToYear($strm);

        return new static($term, $year);
    }

    protected static function strmToTerm(string $strm) : string
    {
        switch(substr($strm, -1)) {
            case 3:
                return 'Spring';
            case 6:
                return 'Summer';
            case 9:
                return 'Fall';
            default:
                throw new InvalidSemester("invalid term: $strm");
        }
    }

    protected static function strmToYear(string $strm) : int
    {
        return (int)substr($strm, 0, 3) + 1900;
    }

    public function term(string $term = null) : string
    {
        if (!isset($term)) {
            return $this->term;
        }

        switch($term = strtolower($term)) {
            case 'spring':
            case 'summer':
            case 'fall':
                $term[0] = strtoupper($term[0]);
                return $this->term = $term;
            default:
                throw new InvalidSemester("invalid term: $term");
        }
    }

    public function year(int $year = null) : int
    {
        if (!isset($year)) {
            return $this->year;
        }

        if ($year < 1945) {
            // schedule of classes not available before World War II
            throw new InvalidSemester("invalid year: $year");
        }

        return $this->year = $year;
    }

    public function string() : string
    {
        if (!isset($this->term, $this->year)) {
            throw new InvalidSemester('Both term and year are required.');
        }

        $prefix = $this->year - 1900;

        if ($prefix < 100) {
            // strm requires leading zero
            $prefix = "0{$prefix}";
        }

        switch($this->term) {
            case 'Spring':
                return "{$prefix}3";
            case 'Summer':
                return "{$prefix}6";
            case 'Fall':
                return "{$prefix}9";
        }
    }

    public function __toString()
    {
        return $this->string();
    }

    public function jsonSerialize()
    {
        return $this->string();
    }

    public static function strm(string $term, int $year) : string
    {
        return (string) new static($term, $year);
    }
}
