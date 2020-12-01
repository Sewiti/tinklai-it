@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Pokalbiai</div>

        <div class="card-body pb-0">
          <button class="btn btn-primary" data-toggle="modal" data-target="#msgModal">
            Naujas pokalbis
          </button>
        </div>

        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th style="width: 20%;">Data ir laikas</th>
                <th style="width: 20%;">Pašnekovas</th>
                <th style="width: 40%;">Paskutinė žinutė</th>
                <th style="width: 20%;"></th>
              </tr>
            </thead>
            <tbody>
            @forelse ($conversations as $conv)
            <tr class="{{ $conv->from == Auth::user()->id || $conv->read ? 'table-default' : 'table-info' }}">
              <td style="width: 20%;" class="align-middle">
                {{ $conv->created_at->format('Y-m-d H:i') }}
              </td>
              <td style="width: 20%;" class="align-middle">@include('helpers.user', ['user' => $conv, 'noEmail' => true])</td>
              <td style="width: 40%;" class="align-middle">{{ $conv->message }}</td>
              <td style="width: 20%;" class="align-middle">
                <a class="btn btn-outline-dark" href="{{ route('messages.show', ['recipientId' => $conv->id]) }}">
                  Atidaryti
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" style="width: 100%;" class="align-middle text-center alert alert-light">
                Pokalbių nėra.
              </td>
            </tr>
            @endforelse
            </tbody>
          </table>

          {{-- {{ $pairs->links() }} --}}
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="msgModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('messages.new') }}" method="GET">
        <div class="modal-header">
          <h5 class="modal-title" id="msgModalLabel">Naujas pokalbis</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label for="recipientId" class="form-label">Pasirinkite pašnekovą</label>
          <select
            id="recipientId"
            name="recipientId"
            class="form-control">

            <option value="-1" selected>-</option>
            @foreach ($users as $user)
              <option value="{{ $user->id }}">
                @include('helpers.user', ['user' => $user])
              </option>
            @endforeach
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Uždaryti</button>
          @csrf
          <button type="submit" class="btn btn-primary">Rašyti žinutę</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
