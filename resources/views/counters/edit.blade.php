@extends('auth.layouts')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edit Counter</div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-error" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('counters.update', $counter->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="serial_number" class="form-label">Serial Number</label>
                            <input type="number" name="serial_number" class="form-control @error('serial_number') is-invalid @enderror" id="serial_number" value="{{ old('serial_number', $counter->serial_number) }}" required>
                            @error('serial_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="caliber" class="form-label">Caliber</label>
                            <input type="text" name="caliber" class="form-control @error('caliber') is-invalid @enderror" id="caliber" value="{{ old('caliber', $counter->caliber) }}" required>
                            @error('caliber')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="imei" class="form-label">IMEI</label>
                            <input type="number" name="imei" class="form-control @error('imei') is-invalid @enderror" id="imei" value="{{ old('imei', $counter->imei) }}" required>
                            @error('imei')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="iccid" class="form-label">ICCID</label>
                            <input type="number" name="iccid" class="form-control @error('iccid') is-invalid @enderror" id="iccid" value="{{ old('iccid', $counter->iccid) }}" required>
                            @error('iccid')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="number" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" value="{{ old('phone_number', $counter->phone_number) }}">
                            @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Dealer Information -->
                        <div class="mt-4">
                            <h5>Dealer Information</h5>
                        </div>

                        <div class="mb-3">
                            <label for="dealer_name" class="form-label">Dealer Name</label>
                            <input type="text" name="dealer_name" class="form-control" id="dealer_name" value="{{ $counter->dealer ? $counter->dealer->name : 'No dealer assigned' }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="director_name" class="form-label">Director Name</label>
                            <input type="text" name="director_name" class="form-control" id="director_name" value="{{ $counter->dealer ? $counter->dealer->director_name : 'No director assigned' }}" readonly>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Counter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
