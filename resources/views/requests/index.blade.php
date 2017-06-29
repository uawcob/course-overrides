@extends('layout')

@section('content')
    <h1>Requests</h1>

    @if (empty(session('cart')))
        <p class="lead">
            <a href="{{ route('courses.index') }}" class="btn btn-primary">Add Classes</a>
        </p>
    @else
        @include('include.cart-items')
    @endif
@endsection
