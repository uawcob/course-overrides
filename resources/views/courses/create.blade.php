@extends('layout')

@section('content')
    <h1>Add a Course</h1>

    <form id="course" class="form-horizontal" method="POST"
        action="{{ route('courses.fetch') }}"
    >
        {{ csrf_field() }}
        <div class="form-group">
            <label class="control-label col-sm-2" for="term">Semester:</label>
            <div class="col-sm-10">
                <select class="form-control" id="term" name="term">
                    {!! App\UpcomingTerm::getTermOptions(date('Y-m-d')) !!}
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="year">Year:</label>
            <div class="col-sm-10">
                <input id="year" name="year" class="form-control" required
                    type="number" min="{{ date('Y') }}"
                    value="{{ App\UpcomingTerm::get(date('Y-m-d'))['year'] }}"
                >
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="number">Course Number:</label>
            <div class="col-sm-10">
                <input id="number" name="number" class="form-control" required
                    type="number" min="1"
                >
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Fetch</button>
    </form>
@endsection

@section('scripts')
<script>
var frm = $('#course');

frm.submit(function (e) {

    e.preventDefault();

    $.ajax({
        type: frm.attr('method'),
        url: frm.attr('action'),
        data: frm.serialize(),
        success: function (data) {
            console.log(data);
        },
        error: function (data) {
            console.log(data);
        },
    });
});
</script>
@endsection
