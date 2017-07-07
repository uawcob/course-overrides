@extends('layout')

@section('content')
    <h1>Create Note</h1>

    <p class="lead">
        <a href="{{ route('notes.index') }}" class="btn btn-default">Index</a>
    </p>

    <form class="form-horizontal" method="POST"
        action="{{ route('notes.store') }}"
    >
        {{ csrf_field() }}

        <div class="panel panel-default">
            <div class="panel-heading">
                <label class="control-label" for="comment">Message Body</label>
            </div>
            <div class="panel-body">
                <textarea class="form-control" rows="10" name="body"></textarea>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <label class="control-label" for="sensitivity">Sensitivity</label>
            </div>
            <div class="panel-body">
                <select class="form-control" id="sensitivity" name="sensitivity">
                    <option value="success">success</option>
                    <option value="info" selected>info</option>
                    <option value="warning">warning</option>
                    <option value="danger">danger</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
