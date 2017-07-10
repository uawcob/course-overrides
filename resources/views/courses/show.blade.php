@extends('layout')

@section('content')
    <h1>{{ $course->title }}</h1>
    <p class="lead">
        {{ $course->code }} : {{ $course->section }}
        - {{ (App\Semester::createFromStrm($course->semester))->canonical() }}
        #{{ $course->number }}
    </p>
    <p>{{ $course->time }} </p>

    @foreach ($notes as $note)
        @include ('include.note')
    @endforeach
@endsection
