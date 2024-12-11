@extends('auth.layouts')

@section('content')

    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex">Hisoblagichlar
                    @if(auth()->user()->role == 'admin')
                        <a class="btn btn-success ms-auto" href="{{ route('counters.create') }}">Yaratish</a>
                    @endif
                </div>

                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="GET" action="{{ route('counters') }}" class="mb-3 d-flex">
                    <input type="text" name="search" id="search" class="form-control me-2" placeholder="Qidirish..." value="{{ request('search') }}">

                    <select name="status" id="status" class="form-select me-2">
                        <option value="sold" {{ request('status') === 'sold' || !request()->has('status') ? 'selected' : '' }}>Sotilgan</option>
                        <option value="notSold" {{ request('status') === 'notSold' ? 'selected' : '' }}>Sotilmagan</option>
                    </select>

                    <button type="submit" class="btn btn-primary">Qidiruv</button>
                </form>



                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th></th>
                            <th scope="col">ID</th>
                            <th scope="col">Seriya raqam</th>
                            <th scope="col">Kalibiri</th>
                            <th scope="col">IMEI</th>
                            <th scope="col">ICCID</th>
                            <th scope="col">Tel raqam</th>
                            <th scope="col">Diller</th>
                            <th scope="col">Amallar</th>
                        </tr>
                        </thead>
                        <tbody id="counterTableBody">
                        @foreach($counters as $counter)
                            <tr>
                                <th>{{ ($counters->currentPage() - 1) * $counters->perPage() + $loop->iteration }}</th>
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
                                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $counter->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $counter->id }}" action="{{ route('counters.destroy', $counter->id) }}" method="post" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <a class="btn btn-primary ms-2" href="{{ route('counters.edit', $counter->id) }}">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <a class="btn btn-success ms-2" href="{{route('counters.show',$counter->id)}}"><i class="bi bi-eye"></i></a>
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
        <div class="d-flex justify-content-center">
            {{ $counters->appends(request()->except('page'))->links() }}
        </div>

    </div>
    <script>
        function confirmDelete(counterId) {
            if (confirm('Hisoblagichni o\'chirishga ishonchingiz komilmi?')) {
                document.getElementById(`delete-form-${counterId}`).submit();
            }
        }
    </script>
@endsection
