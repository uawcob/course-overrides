@extends('layout')

@section('content')
    <h1>Add a Course</h1>

    <form id="course-fetch" class="form-horizontal" method="POST"
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
            <label class="control-label col-sm-2" for="number-pre">Course Number:</label>
            <div class="col-sm-10">
                <input id="number-pre" name="number" class="form-control" required
                    type="number" min="1"
                >
            </div>
        </div>

        <button type="submit" class="btn btn-success">Fetch</button>
    </form>

    <div style="margin:10px; display:none" id="course-return">
        <div id="course-fetch-error" class="alert alert-danger" role="alert" style="display:none">
            <button class="btn btn-warning pull-right"
                onclick="$('#course-form').show()"
            >
                OK, let's do it manually.
            </button>
            Error: Nothing returned.
        </div>

        <form id="course-form" class="form-horizontal" method="POST"
            action="{{ route('courses.store') }}"
        >
            {{ csrf_field() }}

            <div class="form-group">
                <label class="control-label col-sm-2" for="term">Course:</label>
                <div class="col-sm-10">
                    <input id="code" name="code" class="form-control" type="text" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="term">Section:</label>
                <div class="col-sm-10">
                    <input id="section" name="section" class="form-control" type="text" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="term">Title:</label>
                <div class="col-sm-10">
                    <input id="title" name="title" class="form-control" type="text" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="term">Times:</label>
                <div class="col-sm-10">
                    <input id="time" name="time" class="form-control" type="text" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="term">Strm:</label>
                <div class="col-sm-10">
                    <input id="strm" name="strm" class="form-control" required
                        type="number" min="1176"
                    >
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="number-post">Number:</label>
                <div class="col-sm-10">
                    <input id="number-post" name="number" class="form-control" required
                        type="number" min="1"
                    >
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection

@push('scripts')
<script>
function populate(frm, data) {
  $.each(data, function(key, value){
    $('[name='+key+']', frm).val(value).show();
  });
}

var frm = $('#course-fetch');

frm.submit(function (e) {

    e.preventDefault();

    var res = $('#course-return');

    res.slideUp(400, function(){
        $('#course-fetch-error').hide();
        $('#course-form')[0].reset();
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                $('#course-form').show();
                populate('#course-form', data);
            },
            error: function (data) {
                $('#course-form').hide();
                $('#course-fetch-error').show();
                console.log(data);
            },
            complete: function() {
                res.slideDown();
            }
        });
    });
});
</script>
@endpush
