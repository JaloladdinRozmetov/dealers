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

    <div class="w-full max-w-md p-4 mx-auto">
        <h1 class="text-2xl font-bold text-center mb-4 text-gray-800">Hisoblagich skaneri</h1>
        <div id="barcode-scanner" class="bg-white p-4 rounded-lg shadow-lg relative">
            <div id="scanner-viewport" class="relative overflow-hidden rounded-md">
                <video id="camera-feed" autoplay playsinline class="w-full h-auto object-cover"></video>
                <div class="scanner-overlay absolute inset-0 border-4 border-red-500 border-opacity-50 pointer-events-none"></div>
                <div class="scanner-line absolute w-full h-2 bg-red-500 opacity-75 top-1/2 transform -translate-y-1/2 animate-scan"></div>
            </div>
            <p id="result" class="mt-4 text-center text-lg text-gray-600">Shtrix kod...</p>
        </div>
        <button id="start-scanner" class="mt-4 w-full btn btn-success text-white py-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 font-semibold">Kamerani yoqish</button>
    </div>

    <style>
        /* Custom styles for the barcode scanner */
        #barcode-scanner {
            transition: all 0.3s ease;
        }

        #scanner-viewport {
            aspect-ratio: 4 / 3; /* Maintain a consistent aspect ratio for the video */
            max-height: 50vh; /* Limit height on larger screens */
        }

        .scanner-overlay {
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.2); /* Subtle inner shadow for depth */
            border-radius: 8px;
        }

        /* Animated scanning line */
        @keyframes scan {
            0% {
                transform: translateY(-50%) translateX(0);
                opacity: 0.75;
            }
            50% {
                opacity: 1;
            }
            100% {
                transform: translateY(-50%) translateX(0);
                opacity: 0.75;
            }
        }

        .scanner-line {
            animation: scan 2s infinite ease-in-out;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .w-full.max-w-md {
                padding: 1rem; /* Reduce padding on mobile */
            }

            h1 {
                font-size: 1.5rem; /* Smaller heading on mobile */
            }

            #barcode-scanner {
                padding: 1rem; /* Adjust padding for mobile */
            }

            #scanner-viewport {
                aspect-ratio: 1 / 1; /* Square aspect ratio for mobile */
                max-height: 60vh; /* Allow more vertical space on mobile */
            }

            #result {
                font-size: 1rem; /* Smaller text on mobile */
            }

            button {
                font-size: 0.875rem; /* Smaller button text */
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
            }
        }

        /* Improve button focus and active states for accessibility */
        button:focus {
            outline: none;
            ring: 2px solid #3b82f6; /* Tailwind's blue-500 */
            ring-offset: 2px;
        }

        button:active {
            transform: scale(0.98); /* Slight press effect */
        }

        /* Ensure video fits properly */
        #camera-feed {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
    </style>
@endsection
@push('scripts')
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

