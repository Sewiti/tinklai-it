{{ $user->name }}

@isset($noEmail)
  @if(!$noEmail)
    ({{ $user->email }})
  @endif
@else
  ({{ $user->email }})
@endisset

@isset($noType)
  @if(!$noType)
    |
    @include('helpers.type', ['type' => $user->type])
  @endif
@else
  |
  @include('helpers.type', ['type' => $user->type])
@endisset
