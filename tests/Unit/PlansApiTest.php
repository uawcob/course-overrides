<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\RazorbackApi\Plans\PlansApiClient;

class PlansApiTest extends TestCase
{
    public function test_instantiates_class()
    {
        $this->assertInstanceOf(PlansApiClient::class, new PlansApiClient);
    }

    public function test_returns_majors_and_minors()
    {
        $port = getenv('TEST_SERVER_PORT');
        $endpoint = "http://localhost:$port/plans";
        $authtoken = 'AuthToken';
        $student_id = 900000001;

        $expected = [
            ['Major' => 'Marketing'],
            ['Minor' => 'Minor in Finance-Ins/Re'],
        ];

        $actual = (new PlansApiClient($endpoint, $authtoken))->get($student_id);

        $this->assertEquals($actual, $expected);
    }
}
