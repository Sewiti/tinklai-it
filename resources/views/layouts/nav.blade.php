<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">
      {{ config('app.name', 'Laravel') }}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Side Of Navbar -->
      @auth
        <ul class="navbar-nav mr-auto">
          <li>
            <a class="nav-link" href="{{ route('home') }}">Pagrindinis</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="problemsDropdown" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Gedimai
            </a>
            <div class="dropdown-menu" aria-labelledby="problemsDropdown">
              <a class="dropdown-item" href="{{ route('problems.index') }}">Mano gedimai</a>
              <a class="dropdown-item" href="{{ route('problems.create') }}">Naujas gedimas</a>
              {{-- <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a> --}}
            </div>
          </li>
          @if (Auth::user()->type == 'employee')
          <li>
            <a class="nav-link text-nowrap" href="{{ route('jobs.index') }}">Mano darbai</a>
          </li>
          @endif
          <li>
            <a class="nav-link" href="{{ route('messages.index') }}">Pokalbiai</a>
          </li>
          @if (Auth::user()->type == 'admin')
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="jobsDropdown" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Administravimas
            </a>
            <div class="dropdown-menu" aria-labelledby="jobsDropdown">
              <a class="dropdown-item" href="{{ route('admin.index') }}">Visi darbai</a>
              <a class="dropdown-item" href="{{ route('admin.stats') }}">Statistika</a>
            </div>
          </li>
          @endif
        </ul>
      @endauth

      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav ml-auto">
      <!-- Authentication Links -->
      @guest
        @if (Route::has('login'))
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">Prisijungti</a>
        </li>
        @endif

        @if (Route::has('register'))
        <li class="nav-item">
          <a class="nav-link" href="{{ route('register') }}">Registruotis</a>
        </li>
        @endif
      @else
        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            @include('helpers.user', ['user' => Auth::user(), 'noEmail' => true])
          </a>

          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              Atsijungti
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </div>
        </li>
      @endguest
      </ul>
    </div>
  </div>
</nav>
