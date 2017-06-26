<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\MajorMinorsApi\MajorMinorsApiClient;

class MajorMinorsApiTest extends TestCase
{
    public function test_instantiates_class()
    {
        $this->assertInstanceOf(MajorMinorsApiClient::class, new MajorMinorsApiClient);
    }

    public function test_returns_majors_and_minors()
    {
        $port = getenv('TEST_SERVER_PORT');
        $endpoint = "http://localhost:$port/majorminors";
        $authtoken = 'AuthToken';
        $student_id = 900000001;

        $expected = [
            ['Major' => 'Marketing'],
            ['Minor' => 'Minor in Finance-Ins/Re'],
        ];

        $actual = (new MajorMinorsApiClient($endpoint, $authtoken))->get($student_id);

        $this->assertEquals($actual, $expected);
    }
}
