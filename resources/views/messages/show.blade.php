@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12 align-self-stretch">
      <div class="card ">
        <div class="card-header">
          @include('helpers.user', ['user' => $recipient])
        </div>



        <div id="chatContainer" style="height: 75vh;" class="card-body pt-4 pb-1 overflow-auto">
          <div class="container">
            @forelse ($messages as $message)
              <div class="row {{ $message->from == $recipient->id ? '' : 'justify-content-end' }}">

                @if($message->from != $recipient->id)
                <div class="small mx-2 my-auto text-muted">
                  {{ $message->created_at->diffForHumans() }}
                </div>
                @endif

                <div style="max-width: 69%; border-radius: 1em; margin-bottom: 0.125rem; margin-top: 0.125rem; " class="border border-primary px-2 py-1 {{ $message->from == $recipient->id ? 'text-primary' : 'align-self-end text-light bg-primary' }}">
                  {{ $message->message }}
                </div>

                @if($message->from == $recipient->id)
                <div class="small mx-2 my-auto text-muted">
                  {{ $message->created_at->diffForHumans() }}
                </div>
                @endif
              </div>
            @empty
              <div class="row justify-content-center">
                Žinučių nėra.
              </div>
            @endforelse
          </div>
        </div>

        <div class="card-body pt-2">
          <form method="POST" action="{{ route('messages.store') }}">
            <div class="input-group">
              @csrf
              <input type="hidden" name="recipientId" value={{ $recipient->id }}>

              <input
                id="message"
                type="text"
                class="form-control @error('message') is-invalid @enderror"
                name="message"
                value="{{ old('message') ?? '' }}"
                placeholder="Žinutė"
                maxlength="500"
                autocomplete="off"
                autofocus>

              <span class="input-group-btn ml-2">
                <button type="submit" class="btn btn-primary">
                  Siųsti
                </button>
              </span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
window.onload=function () {
  var objDiv = document.getElementById("chatContainer");
  objDiv.scrollTop = objDiv.scrollHeight;
}
</script>
@endsection
