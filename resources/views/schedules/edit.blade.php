@extends('layout')

@push('head')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/css/jquery-ui-timepicker-addon.min.css"/>
@endpush

@section('content')
    <h1>Edit Schedule</h1>

    <p>
        <a href="{{ route('schedules.index') }}" class="btn btn-default">Index</a>
    </p>

    <form class="form-horizontal" method="POST"
        action="{{ route('schedules.update', $schedule) }}"
    >
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <div class="form-group">
            <label class="control-label col-sm-2" for="term">Semester:</label>
            <div class="col-sm-10">
                <select class="form-control" id="term" name="term">
                    {!! App\UpcomingTerm::getTermOptions($schedule->term()) !!}
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="year">Year:</label>
            <div class="col-sm-10">
                <input id="year" name="year" class="form-control" required
                    type="number" value="{{ $schedule->year() }}"
                >
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="start">Start:</label>
            <div class="col-sm-10">
                <input id="start" name="start" class="form-control" type="text" value="{{ $schedule->start->format('Y-m-d H:i') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="finish">Finish:</label>
            <div class="col-sm-10">
                <input id="finish" name="finish" class="form-control" type="text" value="{{ $schedule->finish->format('Y-m-d H:i') }}" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@push('scripts')
<script src="/js/jquery-ui-timepicker-addon.min.js"></script>
<script>
$(function(){
    var startDateTextBox = $('#start');
    var endDateTextBox = $('#finish');

    startDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm',
        onClose: function(dateText, inst) {
            if (endDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker('getDate');
                if (testStartDate > testEndDate)
                    endDateTextBox.datetimepicker('setDate', testStartDate);
            }
            else {
                endDateTextBox.val(dateText);
            }
        },
        onSelect: function (selectedDateTime){
            endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate') );
        }
    });
    endDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm',
        onClose: function(dateText, inst) {
            if (startDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker('getDate');
                if (testStartDate > testEndDate)
                    startDateTextBox.datetimepicker('setDate', testEndDate);
            }
            else {
                startDateTextBox.val(dateText);
            }
        },
        onSelect: function (selectedDateTime){
            startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate') );
        }
    });
});
</script>
@endpush
