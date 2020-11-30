@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Darbuotojų statistika</div>

        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th style="width: 25%;">Darbuotojas</th>
                <th style="width: 25%;">Bendras šalinimo laikas</th>
                <th style="width: 25%;">Vidutinis šalinimo laikas</th>
                <th style="width: 25%;">Vidutinis sureagavimo laikas</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($stats as $stat)
              <tr>
                <td style="width: 25%;" class="align-middle">
                  @include('helpers.user', ['user' => $stat, 'noType' => true])
                </td>

                <td style="width: 25%;" class="align-middle">
                  {{-- {{ Carbon\Carbon::createFromTimestamp($stat->total_work_time)->format('Y-m-d H:i') }} | --}}
                  {{ sprintf("%dd %02d:%02d", floor($stat->total_work_time/86400), floor($stat->total_work_time/3600)%24, floor($stat->total_work_time/60)%60) }}
                </td>

                <td style="width: 25%;" class="align-middle">
                  {{ sprintf("%dd %02d:%02d", floor($stat->avg_work_time/86400), floor($stat->avg_work_time/3600)%24, floor($stat->avg_work_time/60)%60) }}
                </td>

                <td style="width: 25%;" class="align-middle">
                  {{ sprintf("%dd %02d:%02d", floor($stat->avg_reaction_time/86400), floor($stat->avg_reaction_time/3600)%24, floor($stat->avg_reaction_time/60)%60) }}
                </td>

              </tr>
            @endforeach
            </tbody>
          </table>

          {{ $stats->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
