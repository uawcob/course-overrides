@extends('layout')

@section('content')
    <h1>Add a Course</h1>

    <form id="course-form" class="form-horizontal" method="POST"
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

    <div style="margin:10px; display:none" id="course-return"></div>
@endsection

@section('scripts')
<script>
var frm = $('#course-form');

frm.submit(function (e) {

    e.preventDefault();

    var res = $('#course-return');

    res.slideUp(400, function(){
        $(this).html('');
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                res.html('<pre>'+JSON.stringify(data, undefined, 4)+'</pre>').slideDown();
            },
            error: function (data) {
                res.html('<div class="alert alert-danger" role="alert">Error: Nothing returned.</div>').slideDown();
                console.log(data);
            },
        });
    });
});
</script>
@endsection
