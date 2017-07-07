@extends('layout')

@section('content')
    <h1>Note</h1>

    <p class="lead">
        <a href="{{ route('notes.index') }}" class="btn btn-default">Index</a>
    </p>

    @include ('notes.ui')
@endsection
