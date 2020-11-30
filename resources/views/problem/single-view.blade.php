<div class="card-body">
  <h5 class="card-title h4">Problema</h5>
  <p class="card-text">{{ $problem->title }}</p>
</div>

<div class="card-body">
  <h5 class="card-title h4">Aprašymas</h5>
  <p class="card-text">{{ $problem->desc }}</p>
</div>

<div class="card-body">
  <h5 class="card-title h4">Statusas</h5>
  <p class="card-text">
    @include('helpers.status', ['status' => $problem->status])
  </p>
  <p class="card-text">
    Sukurta: {{ $problem->created_at->format('Y-m-d H:i') }}<br>
    @if (!is_null($problem->started_at))
      Pradėta: {{ $problem->started_at->format('Y-m-d H:i') }}<br>
    @endif
    @if (!is_null($problem->finished_at))
      Baigta: &nbsp; {{ $problem->finished_at->format('Y-m-d H:i') }}<br>
    @endif
  </p>
</div>

@isset($user)
<div class="card-body">
  <h5 class="card-title h4">Sukūrė</h5>
  <p class="card-text">
    @include('helpers.user', ['user' => $user])
  </p>
  <a class="btn btn-outline-dark" href="{{ route('messages.show', ['recipientId' => $user->id]) }}">
    Parašyti žinutę
  </a>
</div>
@endisset
