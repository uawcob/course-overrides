@unless (empty($plans))
<div class="well">
<h2>Academic Plans</h2>
<ul>
@foreach ($plans as $plan)
    @foreach ($plan as $type => $name)
    <li>{{ $type }} : {{ $name }}</li>
    @endforeach
@endforeach
</ul>
</div>
@endunless
