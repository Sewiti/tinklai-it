@switch($status)
  @case('registered')
    Registruota
    @break
  @case('in_progress')
    Šalinama
    @break
  @case('finished')
    Sutvarkyta
    @break
  @default
    {{ $status }}
@endswitch
