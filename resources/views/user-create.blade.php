@extends('auth.layouts')

@section('content')

    <div class="row justify-content-center mt-5">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Foydalanuvchi yaratish</div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-error" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Ismi</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Foydalanuvchi ismi.." value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Foydalanuvchi Email.." value="{{ old('email') }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Parol</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Parolni kiriting" required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Parolni tasdiqlash</label>
                            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Parolni tasdiqlash" required>
                            @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Rol</label>
                            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                <option value="" disabled selected>Rolni tanlang</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="dealer" {{ old('role') == 'dealer' ? 'selected' : '' }}>Dealer</option>
                            </select>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dealer Information -->
                        <div id="dealer-info" style="display: none;">
                            <div class="mt-4">
                                <h5>Diller ma'lumotlari</h5>
                            </div>

                            <div class="mb-3">
                                <label for="INN" class="form-label">INN</label>
                                <input type="text" name="INN" class="form-control @error('INN') is-invalid @enderror" id="INN" placeholder="Enter dealer INN" value="{{ old('INN') }}">
                                @error('INN')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="director_name" class="form-label">Direktor ismi</label>
                                <input type="text" name="director_name" class="form-control @error('director_name') is-invalid @enderror" id="director_name" placeholder="Direktor ismini kiriting.." value="{{ old('director_name') }}">
                                @error('director_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="dealer_name" class="form-label">Tashkilot nmi</label>
                                <input type="text" name="dealer_name" class="form-control @error('dealer_name') is-invalid @enderror" id="dealer_name" placeholder="Tashkilot nomini kiriting.." value="{{ old('dealer_name') }}">
                                @error('dealer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="ofice_adres" class="form-label">Ofis manzili</label>
                                <input type="text" name="ofice_adres" class="form-control @error('ofice_adres') is-invalid @enderror" id="ofice_adres" placeholder="Ofisi manzilini kiriting.." value="{{ old('ofice_adres') }}">
                                @error('ofice_adres')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="store_adres" class="form-label">Do'kon manzili</label>
                                <input type="text" name="store_adres" class="form-control @error('store_adres') is-invalid @enderror" id="store_adres" placeholder="Do'kon manzilini kiriting..." value="{{ old('store_adres') }}">
                                @error('store_adres')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Telefon raqam</label>
                                <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" placeholder="Tel raqamini kiriting.." value="{{ old('phone_number') }}">
                                @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Yaratish</button>
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
                    // Optional: Reset the dealer fields
                    document.getElementById('INN').value = '';
                    document.getElementById('director_name').value = '';
                    document.getElementById('ofice_adres').value = '';
                    document.getElementById('store_adres').value = '';
                    document.getElementById('phone_number').value = '';
                } else {
                    dealerInfo.style.display = 'none';
                }
            });
        });
    </script>

@endsection
