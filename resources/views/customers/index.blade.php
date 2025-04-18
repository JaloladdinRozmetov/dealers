@extends('auth.layouts')

@section('content')

    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex">Hisoblagichlar</div>

                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('customers.index') }}" method="GET" class="m-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Seriya raqamini kiriting"
                               value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Qidirish</button>
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Tozalash</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th></th>
                            <th scope="col">Tashkilot nomi</th>
                            <th scope="col">O'zsuvta'minot hisob raqami</th>
                            <th scope="col">INN/PINFL</th>
                            <th scope="col">Direktor F.I.O</th>
                            <th scope="col">Viloyat</th>
                            <th scope="col">Hisoblagich manzili</th>
                            <th scope="col">Telefon raqam</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="counterTableBody">
                        @foreach($customers as $customer)
                            <tr>
                                <th>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}</th>
                                <td>{{ $customer->organization_name }}</td>
                                <td>{{ $customer->personal_account_number }}</td>
                                <td>{{ $customer->organization_INN }}</td>
                                <td>{{ $customer->director_name }}</td>
                                <td>{{ $customer->region->region_name ?? 'N/A' }}</td>
                                <td>{{ $customer->counter_address}}</td>
                                <td>{{ $customer->phone_number}}</td>
                                <td>
                                    <div class="d-flex">
                                        @if(auth()->user()->role == 'admin')
                                            <a class="btn btn-primary ms-2" href="{{ route('customers.edit', $customer->id) }}">
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
        <div class="d-flex justify-content-center">
            {{ $customers->appends(request()->except('page'))->links() }}
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
