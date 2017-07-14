@extends('layout')

@section('content')
    <h1>Classes</h1>

    <p class="lead">
        There are multiple sections for some courses.
        Select all sections for which you would be willing to accept an override.
        When you are finished,
        then you can review your <a href="{{ route('cart.index') }}">cart</a>
        or proceed directly to <a href="{{ route('requests.create') }}">checkout</a>.
        You can always come back here later and add more classes if you need.
    </p>

    @unless (empty($notes))
        @foreach ($notes as $note)
            @include ('include.note')
        @endforeach
    @endunless

    @if (Auth::user()->isAdmin())
    <div class="semesterSelector" style="padding:10px">
        <form class="form-inline" action="{{ route('courses.term') }}">
            <div class="form-group">
                <label for="semester">Semester:</label>
                <select class="form-control" id="semester" name="semester" required>
                    {!! $semesterOptions !!}
                </select>
            </div>

            <div class="form-group">
                <label for="year">Year:</label>
                <input id="year" name="year" class="form-control" required
                    type="number"
                    value="{{ $year }}"
                >
            </div>

            <button type="submit" class="btn btn-default">Filter</button>
        </form>
    </div>
    @endif

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
    @if (empty(session('cart')))
        <style>
            .btn-checkout {display: none}
        </style>
    @endif
    <a href="{{ route('requests.create') }}" class="btn btn-success btn-checkout">Checkout</a>
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
                $('.btn-checkout').css("display", "inline-block");
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
