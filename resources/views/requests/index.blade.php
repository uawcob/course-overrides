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
@endsection

@push('scripts')
<script>
function refreshPlans(){
    var divPlans = $('#div-plans');

    divPlans.slideUp(400, function(){
        $('#plans-fetch-error').hide();
        $.ajax({
            url: '/plans?html=1&refresh=1',
            success: function (data) {
                $('#ul-plans').html(data);
            },
            error: function (data) {
                $('#plans-fetch-error').show();
                console.log(data);
            },
            complete: function() {
                divPlans.slideDown();
            }
        });
    });
}
</script>
@endpush
