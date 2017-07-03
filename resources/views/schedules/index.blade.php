@extends('layout')

@section('content')
    <h1>Schedules</h1>

    <p>
    <a href="{{ route('schedules.create') }}" class="btn btn-success">Add</a>
    </p>

    <table class="table table-bordered datatable" id="schedules-table">
        <thead>
            <tr>
                <th>Start</th>
                <th>Finish</th>
                <th>Semester</th>
                <th>Year</th>
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
            { data: 'start', name: 'start' },
            { data: 'finish', name: 'finish' },
            { data: 'semester', name: 'semester' },
            { data: 'year', name: 'year' },
            { data: 'link', name: 'link' },
        ],
    });
});
</script>
@endpush
