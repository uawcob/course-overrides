@extends('layout')

@section('content')
    <h1>Cart</h1>

    <table class="table table-bordered datatable" id="courses-table">
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

    @if(empty(session('cart')))
        <a href="{{ route('courses.index') }}" class="btn btn-success">Add Some Classes</a>
    @else
        <a href="{{ route('requests.create') }}" class="btn btn-success">Checkout</a>
    @endif
@endsection

@push('scripts')
<script>
$(function() {
    var table = $('#courses-table');

    table.DataTable({
        responsive: true,
        ajax: '{!! route('cart.data') !!}',
        columns: [
            { data: 'code', name: 'code' },
            { data: 'title', name: 'title' },
            { data: 'section', name: 'section' },
            { data: 'time', name: 'time' },
            { data: 'remove', name: 'remove' },
        ],
        drawCallback: function(settings, json) {
            removeCourseAjaxEventListener('tr');
        }
    }).on( 'responsive-display', function ( e, settings, column, state ) {
        removeCourseAjaxEventListener('li');
    } );
});

function removeCourseAjaxEventListener(tag)
{
    $('.btn-cart').off('click').click(function(){
        var btn = $(this);
        $.ajax({
            method: 'post',
            data: {'_token': '{{ csrf_token() }}'},
            url: btn.data('url'),
            success: function(data) {
                $('#courses-table')
                    .DataTable()
                    .row(btn.parents(tag)[0])
                    .remove()
                    .draw();
            }
        });
    });
}
</script>
@endpush
