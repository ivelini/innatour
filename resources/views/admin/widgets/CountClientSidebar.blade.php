@if ($count > 0)
    <span class="badge
     @if ($status == 'new')
            {{ 'bg-danger' }}
     @elseif ($status == 'active')
            {{ 'bg-blue-400' }}
    @elseif ($status == 'closed')
            {{ 'bg-green-400' }}
    @endif
     align-self-center ml-auto">{{ $count }}</span>
@endif