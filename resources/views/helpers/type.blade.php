@switch($type)
  @case('user')
    Vartotojas
    @break
  @case('employee')
    Darbuotojas
    @break
  @case('admin')
    Administratorius
    @break
  @default
    {{ $type }}
@endswitch
