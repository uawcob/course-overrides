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
            <p><strong>Start</strong>: {{ $schedule->start->format('l, F jS Y, h:i:s A') }}</p>
            <p><strong>Finish</strong>: {{ $schedule->finish->format('l, F jS Y, h:i:s A') }}</p>
        </div>
        <div class="panel-footer">
            <a href="{{ route('schedules.edit', $schedule) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
@endsection
