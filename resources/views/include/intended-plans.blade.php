@foreach ($intendedPlanOptions as $category => $options)
    <?php $kebabcat = kebab_case(camel_case($category)); ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label for="sel-intended-plans-{{ $kebabcat }}">{{ $category }}:</label>
                <select class="form-control" id="sel-intended-plans-{{ $kebabcat }}" name="sel-intended-plans-{{ $kebabcat }}">
                    @foreach ($options as $option)
                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                    @endforeach
                </select>
            </div>
            <button id='btn-add-intended-plan-{{ $kebabcat }}' type="button" class="btn btn-success" onclick="addIntendedPlan('{{ $kebabcat }}')">Add</button>
        </div>
    </div>
@endforeach
