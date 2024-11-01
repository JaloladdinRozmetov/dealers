@extends('auth.layouts')

@section('content')

    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex">Counters
                    @if(auth()->user()->role == 'admin')
                        <a class="btn btn-success ms-auto" href="{{ route('counters.create') }}">Create</a>
                    @endif
                </div>

                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="GET" action="{{ route('counters') }}" class="mb-3 d-flex">
                    <input type="text" name="search" id="search" class="form-control me-2" placeholder="Search..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Serial Number</th>
                            <th scope="col">Caliber</th>
                            <th scope="col">IMEI</th>
                            <th scope="col">ICCID</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Dealer</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="counterTableBody">
                        @foreach($counters as $counter)
                            <tr>
                                <th scope="row">{{ $counter->id }}</th>
                                <td>{{ $counter->serial_number }}</td>
                                <td>{{ $counter->caliber }}</td>
                                <td>{{ $counter->imei }}</td>
                                <td>{{ $counter->iccid }}</td>
                                <td>{{ $counter->phone_number ?? 'N/A' }}</td>
                                <td>{{ $counter->dealer ? $counter->dealer->name : 'N/A' }}</td>
                                <td>
                                    <div class="d-flex">
                                        @if(auth()->user()->role == 'admin')
                                            <form action="{{ route('counters.destroy', $counter->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                            <a class="btn btn-primary ms-2" href="{{ route('counters.edit', $counter->id) }}">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-felx justify-content-center">
            {{ $counters->links() }}
        </div>
    </div>

@endsection
