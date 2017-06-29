@extends('layout')

@section('content')
    <h1>Create Request</h1>

    @if (empty($courses))
        <a href="{{ route('courses.index') }}" class="btn btn-success">Add Some Classes</a>
    @else
    <form class="form-horizontal" method="POST"
        action="{{ route('requests.store') }}"
    >
        {{ csrf_field() }}

        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title">{{ $courses['code']->code }} : {{ $courses['code']->title }}</h2>
            </div>
            <div class="panel-body">
                <p class="lead">Drag and drop the sections in order of your preference.</p>
                <ol id="sortable">
                    @foreach ($courses['sections'] as $course)
                    <li>
                        <span class="btn btn-default">
                            {{ $course->time }}
                            <br>
                            Section {{ $course->section }} : #{{ $course->number }}
                        </span>
                        <input type="hidden" name="id[{{ $loop->iteration }}]" value="{{ $course->id }}">
                    </li>
                    @endforeach
                </ol>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <label class="control-label" for="enrolled">Are you currently registered for another section of this course?</label>
            </div>
            <div class="panel-body">
                <div class="radio">
                    <label><input type="radio" name="enrolled" value="1" required>Yes</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="enrolled" value="0">No</label>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <label class="control-label" for="required">Is this SPECIFIC course required for your degree?</label>
            </div>
            <div class="panel-body">
                <div class="radio">
                    <label><input type="radio" name="required" value="1" required>Yes</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="required" value="0">No</label>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <label class="control-label" for="comment">Comment</label>
            </div>
            <div class="panel-body">
                <p class="lead">
                    Add any additional comments regarding your override request below.
                    Include the most important details (i.e. athlete-name of sport, etc.)
                    in the first 10 words if possible.
                </p>
                <textarea class="form-control" rows="10" name="comment"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    @endif
@endsection

@push('scripts')
<script>
  $( function() {
    $( "#sortable" ).sortable({
        stop: function(event, ui) {
            $( "#sortable input" ).each(function(k, v){
                $(v).attr('name', 'id['+(k+1)+']');
            });
        }
    });
  } );
</script>
@endpush
