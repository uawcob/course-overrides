@extends('razorbacks::layout')

@section('navbar-right')
    @if (Auth::guest())
        <li><a href="/shibboleth-login">Login</a></li>
    @else
        <li>
            <a href="/shibboleth-logout">
                Logout {{ Auth::user()->name }}
            </a>
        </li>
    @endif
@endsection

@section('navbar')
    @can('view', App\Course::class)
        <li><a href="{{ route('courses.index') }}">Request</a></li>
    @endcan

    @can('create', App\Course::class)
        <li><a href="{{ route('courses.create') }}">Add</a></li>
    @endcan
@endsection
