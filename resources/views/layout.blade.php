@extends('razorbacks::layout')

@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.15/r-2.1.1/datatables.min.css"/>
<style>
.datatable {
    width: 100% !important;
}
</style>
@stack('head')
@endsection

@section('navbar-right')
    @if (Auth::guest())
        <li><a href="/shibboleth-login">Login</a></li>
    @else
        @if (Auth::user()->isAdmin())
            <li><a href="{{ route('admin.index') }}">Admin</a></li>
        @endif
        <li>
            <a href="/shibboleth-logout">
                Logout {{ Auth::user()->name }}
            </a>
        </li>
    @endif
@endsection

@section('navbar')
    @unless (Auth::guest())
        <li><a href="{{ route('courses.index') }}">Classes</a></li>
        <li><a href="{{ route('cart.index') }}">Cart</a></li>
    @endunless
@endsection

@section('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.15/r-2.1.1/datatables.min.js"></script>
@stack('scripts')
@endsection
