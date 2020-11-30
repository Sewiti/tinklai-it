@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">

      @include('problem.multi-view', [
        'title' => "Mano darbai",
        'show' => "jobs.show",
        'empty' => "Darbų nėra.",
      ])

    </div>
  </div>
</div>
@endsection
