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

                @if ($errors->has('error'))
                    <div class="p-3 mb-3 text-white bg-danger">
                        {{ $errors->first('error') }}
                    </div>
                @endif

                <!-- Search Form -->
                <form method="GET" action="{{ route('search') }}" class="mb-3 d-flex">
                    <input type="text" name="search" id="search" class="form-control me-2" placeholder="Seriya raqam..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Qidirish</button>
                </form>

                    <div class="table-responsive">
                        <table class="table">
                            <tbody id="counterTableBody">
                            @if($counter)
                                <tr class="d-none d-md-table-row">
                                    <th scope="col">ID</th>
                                    <th scope="col">Seriya raqam</th>
                                    <th scope="col">Kalibiri</th>
                                    <th scope="col">IMEI</th>
                                    <th scope="col">ICCID</th>
                                    <th scope="col">Hisoblagich telefon raqam</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Diller</th>
                                </tr>
                                <!-- Desktop view -->
                                <tr class="d-none d-md-table-row">
                                    <th scope="row">{{ $counter->id }}</th>
                                    <td>{{ $counter->serial_number }}</td>
                                    <td>{{ $counter->caliber }}</td>
                                    <td>{{ $counter->imei }}</td>
                                    <td>{{ $counter->iccid }}</td>
                                    <td>{{ $counter->phone_number ?? 'N/A' }}</td>
                                    <td>{{ $counter->status}}</td>
                                    <td>{{ $counter->dealer ? $counter->dealer->name : 'N/A' }}</td>
                                </tr>

                                <!-- Mobile view -->
                                <tr class="d-md-none">
                                    <td><strong>ID:</strong> {{ $counter->id }}</td>
                                </tr>
                                <tr class="d-md-none">
                                    <td><strong>Seriya raqam:</strong> {{ $counter->serial_number }}</td>
                                </tr>
                                <tr class="d-md-none">
                                    <td><strong>Kalibiri:</strong> {{ $counter->caliber }}</td>
                                </tr>
                                <tr class="d-md-none">
                                    <td><strong>IMEI:</strong> {{ $counter->imei }}</td>
                                </tr>
                                <tr class="d-md-none">
                                    <td><strong>ICCID:</strong> {{ $counter->iccid }}</td>
                                </tr>
                                <tr class="d-md-none">
                                    <td><strong>Hisoblagich telefon raqami:</strong> {{ $counter->phone_number ?? 'N/A' }}</td>
                                </tr>
                                <tr class="d-md-none">
                                    <td><strong>Status:</strong> {{ $counter->status}}</td>
                                </tr>
                                <tr class="d-md-none">
                                    <td><strong>Diller:</strong> {{ $counter->dealer ? $counter->dealer->name : 'N/A' }}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                @if($counter and !$counter->dealer)
                    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                        Mijoz kiritish
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
                            <h5 class="modal-title" id="addCustomerModalLabel">Mijoz qo'shish</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="organization_name" class="form-label">Tashkilot nomi</label>
                                <input type="text" name="organization_name" id="organization_name" class="form-control" value="{{ old('organization_name') }}">
                                @error('organization_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="personal_account_number" class="form-label">O'zsuvta'minot hisob raqami</label>
                                <input type="text" name="personal_account_number" id="personal_account_number" class="form-control" value="{{ old('personal_account_number') }}">
                                @error('personal_account_number')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="organization_INN" class="form-label">INN/PINFL</label>
                                <input type="text" name="organization_INN" id="organization_INN" class="form-control" value="{{ old('organization_INN') }}" required>
                                @error('organization_INN')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="director_name" class="form-label">DIREKTOR F.I.O</label>
                                <input type="text" name="director_name" id="director_name" class="form-control" value="{{ old('director_name') }}">
                                @error('director_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="region_id" class="form-label">Viloyat</label>
                                <select name="region_id" id="region_id" class="form-control" required>
                                    <option value="" disabled selected>Viloyatni tanlang</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                            {{ $region->region_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('region_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="counter_address" class="form-label">Hisoblagich o’rnatiladigan manzil</label>
                                <input type="text" name="counter_address" id="counter_address" class="form-control" value="{{ old('counter_address') }}">
                                @error('counter_address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Mijoz telefon raqami</label>
                                <input type="text" name="phone_number" id="phone_number" placeholder="913334567" class="form-control" value="{{ old('phone_number') }}">
                                @error('phone_number')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <input type="hidden" name="counter_id" id="counter_id" class="form-control" value="{{ $counter->id }}">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
                            <button type="submit" class="btn btn-primary">Saqlash</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    <style>
        #barcode-scanner {
            position: relative;
            width: 100%;
            max-width: 640px;
            margin: 0 auto;
        }
        #scanner-viewport {
            width: 100%;
            height: auto;
        }
        .scanner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 2px solid red;
            box-sizing: border-box;
            pointer-events: none;
        }
    </style>

    <div class="w-full max-w-md p-4">
        <h1 class="text-2xl font-bold text-center mb-4">Hisoblagich skaneri</h1>
        <div id="barcode-scanner" class="bg-white p-4 rounded shadow">
            <div id="scanner-viewport">
                <video id="camera-feed" autoplay playsinline class="w-full"></video>
                <div class="scanner-overlay"></div>
            </div>
            <p id="result" class="mt-4 text-center text-lg">shtrix kod...</p>
        </div>
        <button id="start-scanner" class="mt-4 w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Kamerani yoqish</button>
        <button id="stop-scanner" class="mt-2 w-full bg-red-500 text-white py-2 rounded hover:bg-red-600 hidden">Kamerani o'chirish</button>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/quagga@0.12.1/dist/quagga.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const startButton = document.getElementById('start-scanner');
            const stopButton = document.getElementById('stop-scanner');
            const resultDisplay = document.getElementById('result');
            let stream = null;

            startButton.addEventListener('click', async () => {
                try {
                    // Request camera access
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'environment' }
                    });

                    const video = document.getElementById('camera-feed');
                    video.srcObject = stream;
                    video.play();

                    // Initialize QuaggaJS
                    Quagga.init({
                        inputStream: {
                            name: 'Live',
                            type: 'LiveStream',
                            target: video,
                            constraints: {
                                facingMode: 'environment'
                            }
                        },
                        decoder: {
                            readers: ['ean_reader', 'code_128_reader', 'upc_reader']
                        }
                    }, (err) => {
                        if (err) {
                            console.error('Quagga init error:', err);
                            resultDisplay.textContent = 'Error initializing scanner';
                            return;
                        }
                        Quagga.start();
                        startButton.classList.add('hidden');
                        stopButton.classList.remove('hidden');
                    });

                    // Handle barcode detection
                    Quagga.onDetected((data) => {
                        const code = data.codeResult.code;
                        resultDisplay.textContent = `Barcode: ${code}`;

                        // Stop scanner to prevent multiple detections
                        Quagga.stop();
                        stopCamera();

                        console.log(code)
                        // Construct and redirect to the new URL
                        const newUrl = "{{ route('search') }}?search="+code;
                        window.location.href = newUrl;
                    });

                } catch (error) {
                    console.error('Camera access error:', error);
                    resultDisplay.textContent = 'Error accessing camera';
                }
            });

            stopButton.addEventListener('click', () => {
                Quagga.stop();
                stopCamera();
                startButton.classList.remove('hidden');
                stopButton.classList.add('hidden');
                resultDisplay.textContent = 'Scan a barcode...';
            });

            function stopCamera() {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                    const video = document.getElementById('camera-feed');
                    video.srcObject = null;
                }
            }
        });
    </script>
@endpush
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var addCustomerModal = new bootstrap.Modal(document.getElementById('addCustomerModal'));
            addCustomerModal.show();
        });
    </script>
@endif

