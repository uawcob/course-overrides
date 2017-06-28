@extends('layout')

@section('content')
    <h1>Create Request</h1>

    @if (empty($courses))
        <a href="{{ route('courses.index') }}" class="btn btn-success">Add Some Classes</a>
    @else
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="panel-title">{{ $courses['code']->code }} : {{ $courses['code']->title }}</h2>
        </div>
        <div class="panel-body">
            <ol>
                @foreach ($courses['sections'] as $course)
                <li>{{ $course->time }}, Section {{ $course->section }}, Number {{ $course->number }}</li>
                @endforeach
            </ol>
        </div>
        <div class="panel-footer">
            <a class="btn btn-default" href="{{ route('cart.index') }}">Edit</a>
        </div>
    </div>
    @endif
@endsection
