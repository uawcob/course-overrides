@extends('layout')

@section('content')
    <h1>Notes</h1>

    <p class="lead">
        <a href="{{ route('notes.create') }}" class="btn btn-success">Add</a>
    </p>

    @foreach ($notes as $note)
        <div class="panel panel-default">
            <div id="div-plans" class="panel-body">
                <div class="alert alert-{{ $note->sensitivity }}" role="alert">
                    {!! nl2br(e($note->body)) !!}
                </div>
            </div>
            <div class="panel-footer">
                <a href="{{ route('notes.show', $note) }}" class="btn btn-default">View</a>
                <a href="{{ route('notes.edit', $note) }}" class="btn btn-primary">Edit</a>
                <button class="btn btn-warning">Disable</button>
                <button class="btn btn-danger">Delete</button>
            </div>
        </div>
    @endforeach
@endsection
