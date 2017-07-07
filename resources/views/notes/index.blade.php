@extends('layout')

@section('content')
    <h1>Notes</h1>

    <p class="lead">
        <a href="{{ route('notes.create') }}" class="btn btn-success">Add</a>
    </p>

    @foreach ($notes as $note)
        <div class="alert alert-{{ $note->sensitivity }}" role="alert">
            {!! nl2br(e($note->body)) !!}
        </div>
    @endforeach
@endsection
