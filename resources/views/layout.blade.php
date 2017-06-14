@extends('razorbacks::layout')

@section('navbar-right')
    @if (Auth::guest())
        <li><a href="/idp">Login</a></li>
    @else
        <li>
            <a href="/logout">
                Logout {{ Auth::user()->name }}
            </a>
        </li>
    @endif
@endsection
