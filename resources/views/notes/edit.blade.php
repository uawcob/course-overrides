@extends('layout')

@push('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet">
@endpush

@section('content')
    <h1>Edit Note</h1>

    <p class="lead">
        <a href="{{ route('notes.index') }}" class="btn btn-default">Index</a>
    </p>

    <form class="form-horizontal" method="POST"
        action="{{ route('notes.update', $note) }}"
    >
        {{ method_field('PUT') }}
        {{ csrf_field() }}

        <div class="panel panel-default">
            <div class="panel-heading">
                <label class="control-label" for="comment">Message Body</label>
            </div>
            <div class="panel-body">
                <textarea class="form-control" rows="10" name="body">{{ $note->body }}</textarea>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <label class="control-label" for="context">Context</label>
            </div>
            <div class="panel-body">
                <select id="context" name="context[]"
                    class="js-example-basic-multiple"
                    style="width:100%"
                    multiple
                    required
                >
                    @foreach ($note->contexts->pluck('key') as $context)
                        <option value="{{ $context }}" selected>{{ $context }}</option>
                    @endforeach
                    @foreach ($contexts as $context)
                        <option value="{{ $context }}">{{ $context }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <label class="control-label" for="sensitivity">Sensitivity</label>
            </div>
            <div class="panel-body">
                <select class="form-control" id="sensitivity" name="sensitivity">
                    {!! $note->getSensitivityOptions() !!}
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
$(function(){
    $('#context').select2();
});
</script>
@endpush
