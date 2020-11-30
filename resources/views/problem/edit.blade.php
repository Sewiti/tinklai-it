@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Gedimo redagavimas</div>

        <div class="card-body">
          {{-- <form method="POST" action="{{ url('/my-problems/'.$problem->id) }}"> --}}
          <form method="POST" action="{{ route('problems.update', ['problemId' => $problem->id]) }}">
            @csrf
            @method('PUT')
            @include('problem.form')

            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-3">
                <button type="submit" class="btn btn-primary">
                  Išsaugoti
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
