<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\PlansRepository;

class PlansRepositoryTest extends TestCase
{
    public function test_instantiates_class()
    {
        $this->assertInstanceOf(PlansRepository::class, new PlansRepository);
    }
}
