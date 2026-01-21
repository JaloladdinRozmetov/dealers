<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DillerControl</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
@stack('styles')
<body>

    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
          <a class="navbar-brand" href="{{ URL('/') }}">DillerControl</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('login')) ? 'active' : '' }}" href="{{ route('login') }}">Kirish</a>
                    </li>
                @else
                    <li class="nav-item">
                        @if (auth()->user() && auth()->user()->role === 'admin')
                            <a class="nav-link {{ request()->is('users') ? 'active' : '' }}" href="{{ route('users') }}">Dillerlar</a>
                        @endif
                    </li>
                    <li class="nav-item">
                        @if (auth()->user() && auth()->user()->role === 'admin')
                            <a class="nav-link {{ request()->is('counters') ? 'active' : '' }}" href="{{ route('counters') }}">Hisoblagichlar</a>
                        @endif
                    </li>
                    <li class="nav-item">
                        @if (auth()->user() && auth()->user()->role === 'admin')
                            <a class="nav-link {{ request()->is('customers') ? 'active' : '' }}" href="{{ route('customers.index') }}">Mijozlar</a>
                        @endif
                    </li>
                    <li class="nav-item">
                        @if (auth()->user() && auth()->user()->role === 'admin')
                                                        <a class="nav-link {{ request()->is('counters/import') ? 'active' : '' }}" href="{{ route('counters.import') }}">Import Excel</a>
                        @endif
                    </li>
                    <li class="nav-item">
                        @if (auth()->user() && auth()->user()->role === 'admin')
                                                        <a class="nav-link {{ request()->is('counters/statistics') ? 'active' : '' }}" href="{{ route('counters.statistics') }}">Statistika</a>
                        @endif
                    </li>
                    @if (auth()->user() && auth()->user()->role === 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('offline_counters.export') ? 'active' : '' }}"
                               href="#"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                Export Excel
                            </a>

                            <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 320px;">
                                <form method="GET" action="{{ route('offline_counters.export') }}">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label class="form-label mb-1">From</label>
                                            <input type="number"
                                                   name="from"
                                                   class="form-control"
                                                   value="{{ request('from') }}"
                                                   placeholder="1000">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label mb-1">To</label>
                                            <input type="number"
                                                   name="to"
                                                   class="form-control"
                                                   value="{{ request('to') }}"
                                                   placeholder="2000">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label mb-1">Name</label>
                                            <input type="text"
                                                   name="name"
                                                   class="form-control"
                                                   value="{{ request('name') }}"
                                                   placeholder="GIDRO">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label mb-1">Caliber</label>
                                            <input type="text"
                                                   name="caliber"
                                                   class="form-control"
                                                   value="{{ request('caliber') }}"
                                                   placeholder="DN15">
                                        </div>

                                        <div class="col-12 d-flex gap-2 mt-2">
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="bi bi-file-earmark-excel"></i> Export
                                            </button>

                                            <a href="{{ route('offline_counters.export') }}" class="btn btn-outline-secondary">
                                                Reset
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                    @endif


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                            >Chiqish</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </li>
                        </ul>
                    </li>
                @endguest
            </ul>
          </div>
        </div>
    </nav>

    <div class="{{ request()->routeIs('login') ? '' : 'container' }}">
        @yield('content')
    </div>

    <script src="https://unpkg.com/quagga@0.12.1/dist/quagga.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    @stack('scripts')

</body>
</html>
