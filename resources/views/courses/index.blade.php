@extends('layout')

@section('content')
    <h1>Courses</h1>

    <table class="table table-bordered" id="courses-table">
        <thead>
            <tr>
                <th>Course</th>
                <th>Title</th>
                <th>Section</th>
                <th>Time</th>
                <th>Cart</th>
            </tr>
        </thead>
    </table>
@stop

@push('scripts')
<script>
$(function() {
    $('#courses-table').DataTable({
        ajax: '{!! route('courses.data') !!}',
        columns: [
            { data: 'code', name: 'code' },
            { data: 'title', name: 'title' },
            { data: 'section', name: 'section' },
            { data: 'time', name: 'time' },
            { data: 'add', name: 'add' },
        ]
    });
});
</script>
@endpush
