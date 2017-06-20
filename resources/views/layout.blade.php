@extends('razorbacks::layout')

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
@stack('head')
@endsection

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

@section('scripts')
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
@stack('scripts')
@endsection
