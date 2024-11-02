@extends('auth.layouts')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card">
                @if (session('success'))
                    <div class="p-3 mb-3 text-white bg-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Display Error Message -->
                @if ($errors->has('error'))
                    <div class="p-3 mb-3 text-white bg-danger">
                        {{ $errors->first('error') }}
                    </div>
                @endif



                <!-- Search Form -->
                <form method="GET" action="{{ route('search') }}" class="mb-3 d-flex">
                    <input type="text" name="search" id="search" class="form-control me-2" placeholder="Search..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>

                <!-- Add Customer Button (shown only if there are counters) -->

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
                        @if($counter)
                            <tr>
                                <th scope="row">{{ $counter->id }}</th>
                                <td>{{ $counter->serial_number }}</td>
                                <td>{{ $counter->caliber }}</td>
                                <td>{{ $counter->imei }}</td>
                                <td>{{ $counter->iccid }}</td>
                                <td>{{ $counter->phone_number ?? 'N/A' }}</td>
                                <td>{{ $counter->dealer ? $counter->dealer->name : 'N/A' }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                @if($counter)
                    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                        Add Customer
                    </button>
                @endif
            </div>
        </div>
    </div>

    @if($counter)
        <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('sold.counter') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCustomerModalLabel">Add Customer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="organization_name" class="form-label">Organization Name</label>
                                <input type="text" name="organization_name" id="organization_name" class="form-control" value="{{ old('organization_name') }}">
                                @error('organization_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="organization_INN" class="form-label">Organization INN</label>
                                <input type="text" name="organization_INN" id="organization_INN" class="form-control" value="{{ old('organization_INN') }}" required>
                                @error('organization_INN')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="director_name" class="form-label">Director Name</label>
                                <input type="text" name="director_name" id="director_name" class="form-control" value="{{ old('director_name') }}">
                                @error('director_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="counter_address" class="form-label">Counter Address</label>
                                <input type="text" name="counter_address" id="counter_address" class="form-control" value="{{ old('counter_address') }}">
                                @error('counter_address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number') }}">
                                @error('phone_number')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <input type="hidden" name="counter_id" id="counter_id" class="form-control" value="{{ $counter->id }}">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Customer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var addCustomerModal = new bootstrap.Modal(document.getElementById('addCustomerModal'));
            addCustomerModal.show();
        });
    </script>
@endif

