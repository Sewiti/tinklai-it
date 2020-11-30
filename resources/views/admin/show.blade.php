@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Darbo peržiūra</div>

        @include('problem.single-view', ['user' => $user])

        <div class="card-body">
          <h5 class="card-title h4">Priskirtas darbuotojas</h5>
          <p class="card-text">
            @include('helpers.user', ['user' => $employee, 'noType' => true])
          </p>
          <a class="btn btn-outline-dark" href="{{ route('messages.show', ['recipientId' => $employee->id]) }}">
            Parašyti žinutę
          </a>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Ištrinti gedimą</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Ar tikrai norite ištrinti šį gedimą?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Uždaryti</button>

        <form action="{{ route('problems.destroy', ['problemId' => $problem->id]) }}" method="POST">
          @method('DELETE')
          @csrf
          <button type="submit" class="btn btn-danger">Ištrinti</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
