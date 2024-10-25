@extends('auth.layouts')

@section('content')

    <div class="row justify-content-center mt-5">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edit User</div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-error" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Update the form method to PUT for editing -->

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter user name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter user email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password fields can be optional when editing -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password (leave blank if not changing)</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter password">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Confirm password">
                            @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                <option value="" disabled>Select a role</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="dealer" {{ old('role', $user->role) == 'dealer' ? 'selected' : '' }}>Dealer</option>
                            </select>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dealer Information -->
                        <div id="dealer-info" style="{{ old('role', $user->role) == 'dealer' ? 'block' : 'none' }}">
                            <div class="mt-4">
                                <h5>Dealer Information</h5>
                            </div>

                            <div class="mb-3">
                                <label for="INN" class="form-label">INN</label>
                                <input type="text" name="INN" class="form-control @error('INN') is-invalid @enderror" id="INN" placeholder="Enter dealer INN" value="{{ old('INN', $user->dealer->INN ?? '') }}">
                                @error('INN')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="director_name" class="form-label">Director Name</label>
                                <input type="text" name="director_name" class="form-control @error('director_name') is-invalid @enderror" id="director_name" placeholder="Enter director's name" value="{{ old('director_name', $user->dealer->director_name ?? '') }}">
                                @error('director_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="dealer_name" class="form-label">Dealer Name</label>
                                <input type="text" name="dealer_name" class="form-control @error('dealer_name') is-invalid @enderror" id="dealer_name" placeholder="Dealer's name" value="{{ old('dealer_name', $user->dealer->dealer_name ?? '') }}">
                                @error('dealer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="ofice_adres" class="form-label">Office Address</label>
                                <input type="text" name="ofice_adres" class="form-control @error('ofice_adres') is-invalid @enderror" id="ofice_adres" placeholder="Enter office address" value="{{ old('ofice_adres', $user->dealer->ofice_adres ?? '') }}">
                                @error('ofice_adres')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="store_adres" class="form-label">Store Address</label>
                                <input type="text" name="store_adres" class="form-control @error('store_adres') is-invalid @enderror" id="store_adres" placeholder="Enter store address" value="{{ old('store_adres', $user->dealer->store_adres ?? '') }}">
                                @error('store_adres')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" placeholder="Enter phone number" value="{{ old('phone_number', $user->dealer->phone_number ?? '') }}">
                                @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role');
            const dealerInfo = document.getElementById('dealer-info');

            roleSelect.addEventListener('change', function () {
                if (this.value === 'dealer') {
                    dealerInfo.style.display = 'block';
                } else {
                    dealerInfo.style.display = 'none';
                }
            });
        });
    </script>

@endsection
