@extends('layout')

@section('content')
    <h1>Request</h1>

    @include('flash::message')

    @unless(empty(session('cart')))
        @include('include.cart-items')
    @endunless

    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="panel-title">{{ $class->code }} {{ $class->title }}</h2>
        </div>
        <div class="panel-body">
            <p>Sections listed in order of preference:</p>
            <ol>
                @foreach($request->courses as $course)
                <li>
                    {{ $course->time }}
                    <br>
                    Section {{ $course->section }} : #{{ $course->number }}
                </li>
                @endforeach
            </ol>

            @if($request->required)
                <p>Required for graduation.</p>
            @else
                <p>Not required for graduation.</p>
            @endif

            @if($request->enrolled)
                <p>Enrolled in a different section.</p>
            @else
                <p>Not enrolled in any section.</p>
            @endif
        </div>
    </div>

    @unless(empty($request->comment))
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="panel-title">Comment</h2>
        </div>
        <div class="panel-body">
            {!! nl2br(e($request->comment)) !!}
        </div>
    </div>
    @endunless

    <p>Created {{ $request->created_at }}</p>
    <p>Updated {{ $request->updated_at }}</p>
@endsection
