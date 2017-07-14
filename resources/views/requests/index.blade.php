@extends('layout')

@section('content')
    <h1>Requests</h1>

    @foreach ($notes as $note)
        @include ('include.note')
    @endforeach

    @unless (empty(session('cart')))
        @include('include.cart-items')
    @endunless

    <table class="table table-bordered datatable" id="requests-table">
        <thead>
            <tr>
                <th>Class</th>
                <th>Link</th>
                <th>Created</th>
                <th>Updated</th>
            </tr>
        </thead>
    </table>

    <p>
        <a href="{{ route('courses.index') }}" class="btn btn-success">Add Classes</a>
    </p>
@endsection

@push('scripts')
<script>
$(function() {
    $('#requests-table').DataTable({
        responsive: true,
        data: JSON.parse('{!! $requests !!}'),
        columns: [
            { data: 'class', name: 'class' },
            { data: 'link', name: 'link' },
            { data: 'created_at', name: 'created' },
            { data: 'updated_at', name: 'updated' },
        ],
    });
});
</script>
@endpush
