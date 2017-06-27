@extends('layout')

@section('content')
    <h1>Requests</h1>

    @unless (empty($plans))
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="panel-title">Academic Plans</h2>
        </div>
        <div id="div-plans" class="panel-body">
            <div id="plans-fetch-error" class="alert alert-danger" role="alert" style="display:none">
                Error: No plans found.
            </div>
            <ul id="ul-plans">
                @include('include.plans')
            </ul>
        </div>
        <div class="panel-footer">
            <button class="btn btn-default" onclick="refreshPlans()">Refresh</button>
        </div>
    </div>
    @endunless
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
