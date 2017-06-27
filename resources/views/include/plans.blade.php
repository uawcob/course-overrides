@foreach ($plans as $plan)
    @foreach ($plan as $type => $name)
    <li>{{ $type }} : {{ $name }}</li>
    @endforeach
@endforeach
