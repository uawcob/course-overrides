@extends('layout')

@section('content')
    <h1>Notes</h1>

    <p class="lead">
        <a href="{{ route('notes.create') }}" class="btn btn-success">Add</a>
    </p>

    @foreach ($notes as $note)
        @include ('notes.ui')
    @endforeach
@endsection
