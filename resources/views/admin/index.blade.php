@extends('layout')

@section('content')
    <h1>Administration</h1>

    <ul>
        <li><a href="{{ route('schedules.index') }}" class="btn btn-default">Schedules</a></li>
        <li><a href="{{ route('notes.index') }}" class="btn btn-default">Notes</a></li>
        <li><a href="{{ route('courses.create') }}" class="btn btn-default">Create Course</a></li>
    </ul>
@endsection
