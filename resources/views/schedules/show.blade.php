@extends('layout')

@section('content')
    <h1>Schedule</h1>

    <p>
        <a href="{{ route('schedules.index') }}" class="btn btn-default">Index</a>
    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="panel-title">{{ $schedule->semester() }}</h2>
        </div>
        <div id="div-plans" class="panel-body">
            <p><strong>Start</strong>: {{ $schedule->start->format('l, F jS Y, g:i:s A') }}</p>
            <p><strong>Finish</strong>: {{ $schedule->finish->format('l, F jS Y, g:i:s A') }}</p>
        </div>
        <div class="panel-footer">
            <a href="{{ route('schedules.edit', $schedule) }}" class="btn btn-warning">Edit</a>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete">Delete</button>
        </div>
    </div>

    <div id="modalDelete" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Delete Schedule</h4>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete this schedule?</p>
          </div>
          <div class="modal-footer">
            <form action="{{ route('schedules.destroy', $schedule) }}" method="post">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection
