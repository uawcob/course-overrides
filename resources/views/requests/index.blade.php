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

    <table class="table table-bordered datatable" id="requests-table">
        <thead>
            <tr>
                <th>Class</th>
                <th>Created</th>
                <th>Updated</th>
            </tr>
        </thead>
    </table>
@endsection

@push('scripts')
<script>
$(function() {
    $('#requests-table').DataTable({
        responsive: true,
        data: JSON.parse('{!! $requests !!}'),
        columns: [
            { data: 'class', name: 'class' },
            { data: 'created_at', name: 'created' },
            { data: 'updated_at', name: 'updated' },
        ],
    });
});
</script>
@endpush
