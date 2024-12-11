@extends('auth.layouts')

@section('content')

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex">
                    <h4>Hisoblagich ma'lumotlari</h4>
                    <a class="btn btn-primary ms-auto" href="{{ route('counters') }}">Hisoblagichlar</a>
                </div>
                <div class="card-body">

                    <!-- Counter Information Table -->
                    <table class="table mb-4">
                        <tbody>
                        <tr>
                            <th>Hisoblagich ID</th>
                            <td>{{ $counter->id }}</td>
                        </tr>
                        <tr>
                            <th>Seriya raqami</th>
                            <td>{{ $counter->serial_number }}</td>
                        </tr>
                        <tr>
                            <th>Kalibiri</th>
                            <td>{{ $counter->caliber }}</td>
                        </tr>
                        <tr>
                            <th>Imei</th>
                            <td>{{ $counter->imei }}</td>
                        </tr>
                        <tr>
                            <th>Iccid</th>
                            <td>{{ $counter->iccid }}</td>
                        </tr>
                        <tr>
                            <th>Tel raqam</th>
                            <td>{{ $counter->phone_number }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $counter->status }}</td>
                        </tr>
                        <tr>
                            <th>Yaratilgan sana</th>
                            <td>{{ $counter->created_at }}</td>
                        </tr>
                        </tbody>
                    </table>

                    <!-- Dealer Information Table -->
                    @if($counter->dealer)
                        <h5>Diller ma'lumoti</h5>
                        <table class="table mb-4">
                            <tbody>
                            <tr>
                                <th>Diller ID</th>
                                <td>{{ $counter->dealer->id }}</td>
                            </tr>
                            <tr>
                                <th>Tashkilot nomi</th>
                                <td>{{ $counter->dealer->name }}</td>
                            </tr>
                            <tr>
                                <th>Direktor nomi</th>
                                <td>{{ $counter->dealer->director_name }}</td>
                            </tr>
                            <tr>
                                <th>INN</th>
                                <td>{{ $counter->dealer->INN }}</td>
                            </tr>
                            <tr>
                                <th>Ofis manzili</th>
                                <td>{{ $counter->dealer->ofice_adres }}</td>
                            </tr>
                            <tr>
                                <th>Do'kon manzili</th>
                                <td>{{ $counter->dealer->store_adres }}</td>
                            </tr>
                            <tr>
                                <th>Tel raqam</th>
                                <td>{{ $counter->dealer->phone_number }}</td>
                            </tr>
                            </tbody>
                        </table>
                    @else
                        <p>Bu hisoblagichda hali diller ma'lumotlari mavjud emas.</p>
                    @endif

                    <!-- Customer Information Table -->
                    @if($counter->customer)
                        <h5>Mijoz ma'lumotlari</h5>
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>Mijoz ID</th>
                                <td>{{ $counter->customer->id }}</td>
                            </tr>
                            <tr>
                                <th>Tashkilot nomi</th>
                                <td>{{ $counter->customer->organization_name }}</td>
                            </tr>
                            <tr>
                                <th>Shaxsiy hisob raqami</th>
                                <td>{{ $counter->customer->personal_account_number }}</td>
                            </tr>
                            <tr>
                                <th>INN/PINFL</th>
                                <td>{{ $counter->customer->organization_INN }}</td>
                            </tr>
                            <tr>
                                <th>DIREKTOR F.I.O</th>
                                <td>{{ $counter->customer->director_name }}</td>
                            </tr>
                            <tr>
                                <th>Hisoblagich o’rnatiladigan manzil</th>
                                <td>{{$counter->customer->region->region_name}}: {{ $counter->customer->counter_address }}</td>
                            </tr>
                            <tr>
                                <th>Tel raqam</th>
                                <td>{{ $counter->customer->phone_number }}</td>
                            </tr>
                            </tbody>
                        </table>
                    @else
                        <p>Hisoblagichga hali mijoz biriktirilmagan.</p>
                    @endif

                    <a href="{{ route('counters.edit', $counter->id) }}" class="btn btn-primary mt-3">O'zgartirish</a>
                </div>
            </div>
        </div>
    </div>

@endsection
