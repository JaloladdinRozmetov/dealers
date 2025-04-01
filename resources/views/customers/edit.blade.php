@extends('auth.layouts')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Mijoz o'zgartirish</div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-error" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="organization_name" class="form-label">Tashkilot nomi</label>
                            <input type="text" name="organization_name" class="form-control @error('organization_name') is-invalid @enderror" id="organization_name" value="{{ old('organization_name', $customer->organization_name) }}" required>
                            @error('organization_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="personal_account_number" class="form-label">O'zsuvta'minot hisob raqami</label>
                            <input type="text" name="personal_account_number" class="form-control @error('personal_account_number') is-invalid @enderror" id="personal_account_number" value="{{ old('personal_account_number', $customer->personal_account_number) }}" required>
                            @error('caliber')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="organization_INN" class="form-label">INN/PINFL</label>
                            <input type="number" name="organization_INN" class="form-control @error('organization_INN') is-invalid @enderror" id="organization_INN" value="{{ old('organization_INN', $customer->organization_INN) }}" required>
                            @error('organization_INN')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="director_name" class="form-label">Direktor F.I.O</label>
                            <input type="text" name="director_name" class="form-control @error('director_name') is-invalid @enderror" id="director_name" value="{{ old('director_name', $customer->director_name) }}" required>
                            @error('director_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="region" class="form-label">Viloyat</label>
                            <select name="region" id="region" class="form-control @error('region') is-invalid @enderror" required>
                                <option value="" disabled>Regionni tanlang</option>
                                @foreach($regions as $region)
                                    <option value="{{$region->id}}" {{ old('region', $customer->region->region_name) == $region->region_name ? 'selected' : '' }} @if($region->region_name == $customer->region->region_name) selected @endif >{{$region->region_name}}</option>
                                @endforeach
                            </select>
                            @error('region')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Telefon raqam</label>
                            <input type="number" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" value="{{ old('phone_number', $customer->phone_number) }}" required>
                            @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">O'zgartirish</button>
                    </form>
                </div>
            </div>
            @if($counters->isNotEmpty())
                <div class="mt-5">
                <h5>Hisoblagichlar  ({{count($counters)}})</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Seriya raqami</th>
                            <th>imei</th>
                            <th>Tel raqam</th>
                            <th>Yaratilgan sana</th>
                            <th>Amallar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($counters as $counter)
                            <tr>
                                <td>{{ $counter->id }}</td>
                                <td>{{ $counter->serial_number }}</td>
                                <td>{{ $counter->imei }}</td>
                                <td>{{ $counter->phone_number }}</td>
                                <td>{{ $counter->created_at }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{route('counters.show',$counter->id)}}"><i class="bi bi-eye"></i></a>

                                    @if(auth()->user()->role == 'admin')
                                        <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $counter->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $counter->id }}" action="{{ route('counters.remove', $counter->id) }}" method="post" style="display: none;">
                                            @csrf
                                            @method('PUT')
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $counters->appends(request()->except('page'))->links() }}
                    </div>

                </div>
                </div>
            @else
                <p>Mijozda hali hisoblagichlar mavjud emas.</p>
            @endif
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
