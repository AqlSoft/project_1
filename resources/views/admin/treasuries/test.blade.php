{{ $master->name }}
<ul>
  @foreach ($master->children as $item => $child)
      <li>{{ $child->id }} {{ $child->name }}</li>
      @if (!empty($child->children))
        <ul>
          @foreach ($child->children as $i => $lastChild)
          <li>{{ $lastChild->id}} {{$lastChild->name }}</li>
          @endforeach
        </ul>
      @endif
  @endforeach
</ul>
