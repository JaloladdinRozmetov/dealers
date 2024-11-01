@extends('auth.layouts')

@section('content')

    <div class="row justify-content-center mt-5">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Create New Counter</div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('counters.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="serial_number" class="form-label">Serial Number</label>
                            <input type="text" name="serial_number" class="form-control @error('serial_number') is-invalid @enderror" id="serial_number" placeholder="Enter serial number" value="{{ old('serial_number') }}" required>
                            @error('serial_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="caliber" class="form-label">Caliber</label>
                            <input type="text" name="caliber" class="form-control @error('caliber') is-invalid @enderror" id="caliber" placeholder="Enter caliber" value="{{ old('caliber') }}" required>
                            @error('caliber')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="imei" class="form-label">IMEI</label>
                            <input type="text" name="imei" class="form-control @error('imei') is-invalid @enderror" id="imei" placeholder="Enter IMEI" value="{{ old('imei') }}" required>
                            @error('imei')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="iccid" class="form-label">ICCID</label>
                            <input type="text" name="iccid" class="form-control @error('iccid') is-invalid @enderror" id="iccid" placeholder="Enter ICCID" value="{{ old('iccid') }}" required>
                            @error('iccid')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" placeholder="Enter phone number" value="{{ old('phone_number') }}">
                            @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Create Counter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
