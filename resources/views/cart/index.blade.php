@extends('layout')

@section('content')
    <h1>Cart</h1>

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
    var table = $('#courses-table');

    table.DataTable({
        ajax: '{!! route('cart.data') !!}',
        columns: [
            { data: 'code', name: 'code' },
            { data: 'title', name: 'title' },
            { data: 'section', name: 'section' },
            { data: 'time', name: 'time' },
            { data: 'remove', name: 'remove' },
        ],
        initComplete: function(settings, json) {
            $('.btn-cart').click(function(){
                var btn = $(this);
                $.ajax({
                    url: btn.data('url'),
                    success: function(data) {
                        table.DataTable()
                            .row( btn.parents('tr') )
                            .remove()
                            .draw();
                    }
                });
            });
        }
    });
});
</script>
@endpush
