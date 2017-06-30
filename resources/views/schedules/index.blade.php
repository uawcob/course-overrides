@extends('layout')

@section('content')
    <h1>Schedules</h1>

    <p>
    <a href="{{ route('schedules.create') }}" class="btn btn-success">Add</a>
    </p>

    <table class="table table-bordered datatable" id="schedules-table">
        <thead>
            <tr>
                <th>Start</th>
                <th>Finish</th>
                <th>Semester</th>
                <th>Year</th>
                <th>Edit</th>
            </tr>
        </thead>
    </table>
@endsection
