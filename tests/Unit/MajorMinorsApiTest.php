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
}
