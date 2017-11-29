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
<div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label for="sel-intended-plans-majors">Majors:</label>
                <select class="form-control" id="sel-intended-plans-majors" name="sel-intended-plans-majors">
                                            <option value="1">Economics—Business Economics</option>
                                            <option value="4">Economics—International ECON and Business</option>
                                    </select>
            </div>
            <button id='btn-add-intended-plan-majors' type="button" class="btn btn-success" onclick="addIntendedPlan('majors')">Add</button>
        </div>
    </div>
        <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label for="sel-intended-plans-minors-for-business-majors">Minors for Business Majors:</label>
                <select class="form-control" id="sel-intended-plans-minors-for-business-majors" name="sel-intended-plans-minors-for-business-majors">
                                            <option value="2">Finance—Investments/Banking</option>
                                            <option value="5">Finance—Real Estate/Insurance</option>
                                    </select>
            </div>
            <button id='btn-add-intended-plan-minors-for-business-majors' type="button" class="btn btn-success" onclick="addIntendedPlan('minors-for-business-majors')">Add</button>
        </div>
    </div>
        <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label for="sel-intended-plans-minors-for-non-business-majors">Minors for Non-Business Majors:</label>
                <select class="form-control" id="sel-intended-plans-minors-for-non-business-majors" name="sel-intended-plans-minors-for-non-business-majors">
                                            <option value="3">Information Systems</option>
                                            <option value="6">Enterprise Systems</option>
                                    </select>
            </div>
            <button id='btn-add-intended-plan-minors-for-non-business-majors' type="button" class="btn btn-success" onclick="addIntendedPlan('minors-for-non-business-majors')">Add</button>
        </div>
    </div>

OPTIONS;

        $this->assertSame($options, IntendedPlan::selectOptions());
    }
}
