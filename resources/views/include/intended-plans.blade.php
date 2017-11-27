@foreach ($intendedPlanOptions as $category => $options)
<optgroup label="{{ $category }}">
    @foreach ($options as $option)
    <option value="{{ $option->id }}">{{ $option->name }}</option>
    @endforeach
</optgroup>
@endforeach
