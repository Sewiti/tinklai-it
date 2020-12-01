@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Visi darbai</div>

        <div class="card-body">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif

          <table class="table">
            <thead>
              <tr>
                <th class="text-nowrap">Data ir laikas</th>
                <th>Darbuotojas</th>
                <th>Problema</th>
                <th>Statusas</th>
                <th>Peržiūra</th>
                <th>Parašyti žinutę</th>
              </tr>
            </thead>
            <tbody>
            @forelse ($problems as $problem)
              <tr class="{{
                  $problem->status=='finished' ? 'table-default' :
                  ($problem->status=='in_progress' ? 'table-info' :
                  (strtotime("now") - strtotime($problem->created_at) >= 7200 ? 'table-danger' : 'table-warning'))
                }}">

                <td  class="align-middle">
                  {{ $problem->created_at->format('Y-m-d H:i') }}
                </td>

                <td  class="align-middle">
                  @include('helpers.user', ['user' => $problem, 'noType' => true])
                </td>

                <td  class="align-middle">{{ $problem->title }}</td>

                <td  class="align-middle">

                  @include('helpers.status', ['status' => $problem->status])
                </td>

                <td  class="align-middle">
                  <a class="btn btn-outline-dark" href="{{ route('admin.show', ['problemId' => $problem->id]) }}" role="button">
                    Peržiūrėti
                  </a>
                </td>

                {{-- @if ($problem->status=='registered' && strtotime("now") - strtotime($problem->created_at) >= 7200) --}}
                <td  class="align-middle">
                  <a class="btn btn-outline-dark" href="{{ route('messages.show', ['recipientId' => $problem->employee_id]) }}" role="button">
                    Parašyti
                  </a>
                </td>
                {{-- @endif --}}

              </tr>
            @empty
              <tr>
                <td colspan="4" style="width: 100%;" class="align-middle text-center alert alert-light">
                  Darbų nėra.
                </td>
              </tr>
            @endforelse
            </tbody>
          </table>

          {{ $problems->links() }}
        </div>
      </div>


    </div>
  </div>
</div>
@endsection
