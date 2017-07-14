@extends('layout')

@section('content')
    <h1>Welcome</h1>
    <p class="lead">This is the class override request system for the Sam M. Walton College of Business.</p>

    @if (App\Schedule::isOpen())
        <div class="alert alert-success">
            The override request system is open.
            @if (Auth::guest())
                <a href="{{ route('shibboleth-login') }}" class="btn btn-success">Login</a>
            @else
                <a href="{{ route('courses.index') }}" class="btn btn-success">Add Classes</a>
            @endif
        </div>
    @endif

    @unless (empty($notes))
        @foreach ($notes as $note)
            @include ('include.note')
        @endforeach
    @endunless

    @if (empty($schedules))
        <p><strong>Override requests are not currently being accepted.</strong></p>
    @else
        <h2>Schedule</h2>
        <p>Requests for overrides will be accepted during the following periods:</p>
        <ul>
            {!! $schedules !!}
        </ul>
    @endif
@endsection
