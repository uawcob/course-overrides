@extends('layout')

@section('content')
    <h1>Admin</h1>

    <ul>
        @can('create', App\Course::class)
        <li><a href="{{ route('courses.create') }}" class="btn btn-default">Create New Course</a></li>
        @endcan
    </ul>
@endsection
