@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Darbo peržiūra</div>

          @include('problem.single-view', ['user' => $user])

          <div class="card-body">
            <button class="btn btn-primary" data-toggle="modal" data-target="#editModal">
              Pakeisti statusą
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('jobs.update', ['problemId' => $problem->id]) }}" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Statuso pakeitimas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label for="status" class="form-label">Statusas</label>
          <select
            id="status"
            name="status"
            class="form-control">

            <option value="registered" {!! $problem->status == "registered" ? "selected" : "" !!}>
              Registruota
            </option>

            <option value="in_progress" {!! $problem->status == "in_progress" ? "selected" : "" !!}>
              Šalinama
            </option>

            <option value="finished" {!! $problem->status == "finished" ? "selected" : "" !!}>
              Sutvarkyta
            </option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Uždaryti</button>
          @method('PUT')
          @csrf
          <button type="submit" class="btn btn-primary">Išsaugoti</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
