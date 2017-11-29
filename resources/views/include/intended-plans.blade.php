{{-- @foreach ($intendedPlanOptions as $category => $options)
<optgroup label="{{ $category }}">
    @foreach ($options as $option)
    <option value="{{ $option->id }}">{{ $option->name }}</option>
    @endforeach
</optgroup>
@endforeach --}}

<div class="form-group">
    <label for="sel-intended-plans-majors">Majors:</label>
    <select class="form-control" id="sel-intended-plans-majors" name="sel-intended-plans-majors">
        <option value="1">Economics—Business Economics</option>
        <option value="4">Economics—International ECON and Business</option>
    </select>
</div>
<button id='btn-add-intended-plan-majors' type="button" class="btn btn-success" onclick="addIntendedPlan()">Add</button>

<div class="form-group">
    <label for="sel-intended-plans-minors-for-business-majors">Minors for Business Majors:</label>
    <select class="form-control" id="sel-intended-plans-minors-for-business-majors" name="sel-intended-plans-minors-for-business-majors">
        <option value="2">Finance—Investments/Banking</option>
        <option value="5">Finance—Real Estate/Insurance</option>
    </select>
</div>
<button id='btn-add-intended-plan-minors-for-business-majors' type="button" class="btn btn-success" onclick="addIntendedPlan()">Add</button>

<div class="form-group">
    <label for="sel-intended-plans-minors-for-non-business-majors">Minors for Non-Business Majors:</label>
    <select class="form-control" id="sel-intended-plans-minors-for-non-business-majors" name="sel-intended-plans-minors-for-non-business-majors">
        <option value="3">Information Systems</option>
        <option value="6">Enterprise Systems</option>
    </select>
</div>
<button id='btn-add-intended-plan-minors-for-non-business-majors' type="button" class="btn btn-success" onclick="addIntendedPlan()">Add</button>
