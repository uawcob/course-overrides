@extends('layout')

@section('content')
    <h1>Classes</h1>

    <p class="lead">
        There are multiple sections for some courses.
        Select all sections for which you would be willing to accept an override.
        When you are finished,
        then review your <a href="{{ route('cart.index') }}">cart</a>,
        and proceed to checkout.
    </p>

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

    <a href="{{ route('cart.index') }}" class="btn btn-primary">Go to Cart</a>
@endsection

@push('scripts')
<script>
$(function() {
    $('#courses-table').DataTable({
        responsive: true,
        ajax: '{!! $route !!}',
        columns: [
            { data: 'code', name: 'code' },
            { data: 'title', name: 'title' },
            { data: 'section', name: 'section' },
            { data: 'time', name: 'time' },
            { data: 'add', name: 'add' },
        ],
        drawCallback: function(settings, json) {
            addCourseAjaxEventListener('tr');
        }
    }).on( 'responsive-display', function ( e, settings, column, state ) {
        addCourseAjaxEventListener('li');
    } );

});

function addCourseAjaxEventListener(tag)
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
