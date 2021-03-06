@extends('layout')

@section('content')
    <h1>Cart</h1>

    <p class="lead">
        Here you can remove any classes you don't want in your cart.
        When you are happy with your selections, then
        proceed to <a href="{{ route('requests.create') }}">checkout</a>.
    </p>

    @unless (empty($notes))
        @foreach ($notes as $note)
            @include ('include.note')
        @endforeach
    @endunless

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

    <a href="{{ route('courses.index') }}" class="btn btn-primary">Add Classes</a>
    @unless(empty(session('cart')))
        <a href="{{ route('requests.create') }}" class="btn btn-success">Checkout</a>
    @endunless
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
