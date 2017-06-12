@extends('layout')

@section('content')
    <h1>Add a Course</h1>

    <form id="course" class="form-horizontal">
        <div class="form-group">
            <label class="control-label col-sm-2" for="term">Semester:</label>
            <div class="col-sm-10">
                <select class="form-control" id="term" name="term">
                        <option>Spring</option>
                        <option>Summer</option>
                        <option>Fall</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="year">Year:</label>
            <div class="col-sm-10">
                <input id="year" name="year" class="form-control" required
                    type="number" min="{{ date('Y') }}" value="{{ date('Y') }}"
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
$("#course").bind('submit',function(){
   alert('handled');
   return false;
});
</script>
@endsection
