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

    public function term(string $term = null) : string
    {
        if (!isset($term)) {
            return $this->term;
        }

        switch($term = strtolower($term)) {
            case 'spring':
            case 'summer':
            case 'fall':
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
            case 'spring':
                return "{$prefix}3";
            case 'summer':
                return "{$prefix}6";
            case 'fall':
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
