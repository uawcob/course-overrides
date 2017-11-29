<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\IntendedPlan;

class IntendedPlanSelectTest extends TestCase
{
    use DatabaseMigrations;

    public function test_can_render_multiple_selects()
    {
        IntendedPlan::create([
            'name' => 'Economics—Business Economics',
            'category' => 'Majors',
            'abbr' => '(M)',
        ]);
        IntendedPlan::create([
            'name' => 'Finance—Investments/Banking',
            'category' => 'Minors for Business Majors',
            'abbr' => '(mB)',
        ]);
        IntendedPlan::create([
            'name' => 'Information Systems',
            'category' => 'Minors for Non-Business Majors',
            'abbr' => '(mN)',
        ]);
        IntendedPlan::create([
            'name' => 'Economics—International ECON and Business',
            'category' => 'Majors',
            'abbr' => '(M)',
        ]);
        IntendedPlan::create([
            'name' => 'Finance—Real Estate/Insurance',
            'category' => 'Minors for Business Majors',
            'abbr' => '(mB)',
        ]);
        IntendedPlan::create([
            'name' => 'Enterprise Systems',
            'category' => 'Minors for Non-Business Majors',
            'abbr' => '(mN)',
            ]);

        $options = <<<OPTIONS
<optgroup label="Majors">
        <option value="1">Economics—Business Economics</option>
        <option value="4">Economics—International ECON and Business</option>
    </optgroup>
<optgroup label="Minors for Business Majors">
        <option value="2">Finance—Investments/Banking</option>
        <option value="5">Finance—Real Estate/Insurance</option>
    </optgroup>
<optgroup label="Minors for Non-Business Majors">
        <option value="3">Information Systems</option>
        <option value="6">Enterprise Systems</option>
    </optgroup>

OPTIONS;

        $this->assertSame($options, IntendedPlan::selectOptions());
    }
}
