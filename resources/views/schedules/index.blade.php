@extends('layout')

@section('content')
    <h1>Schedules</h1>

    <p>
    <a href="{{ route('schedules.create') }}" class="btn btn-success">Add</a>
    </p>

    <table class="table table-bordered datatable" id="schedules-table">
        <thead>
            <tr>
                <th>Semester</th>
                <th>Year</th>
                <th>Open</th>
                <th>Close</th>
                <th>View</th>
            </tr>
        </thead>
    </table>
@endsection

@push('scripts')
<script>
$(function() {
    $('#schedules-table').DataTable({
        responsive: true,
        data: JSON.parse('{!! $schedules !!}'),
        columns: [
            { data: 'semester', name: 'semester' },
            { data: 'year', name: 'year' },
            { data: 'start', name: 'start' },
            { data: 'finish', name: 'finish' },
            { data: 'link', name: 'link' },
        ],
        "order": [[ 2, "asc" ]],
    });
});
</script>
@endpush
