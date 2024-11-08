@extends('auth.layouts')

@section('content')

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex">
                    <h4>Foydalanuvchi va Diller ma'lumoti</h4>
                    <a class="btn btn-primary ms-auto" href="{{ route('users') }}">Dillerlar</a>
                </div>
                <div class="card-body">
                    <!-- User Information Table -->
                    <table class="table mb-4">
                        <tbody>
                        <tr>
                            <th>Foydalanuvchi ID</th>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th>Ism</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        </tbody>
                    </table>

                    <!-- Dealer Information Table -->
                    @if($user->dealer)
                        <h5>Diller ma'lumoti</h5>
                        <table class="table mb-4">
                            <tbody>
                            <tr>
                                <th>Diller ID</th>
                                <td>{{ $user->dealer->id }}</td>
                            </tr>
                            <tr>
                                <th>Tashkilot nomi</th>
                                <td>{{ $user->dealer->name }}</td>
                            </tr>
                            <tr>
                                <th>Direktor nomi</th>
                                <td>{{ $user->dealer->director_name }}</td>
                            </tr>
                            <tr>
                                <th>INN</th>
                                <td>{{ $user->dealer->INN }}</td>
                            </tr>
                            <tr>
                                <th>Ofis manzili</th>
                                <td>{{ $user->dealer->ofice_adres }}</td>
                            </tr>
                            <tr>
                                <th>Do'kon manzili</th>
                                <td>{{ $user->dealer->store_adres }}</td>
                            </tr>
                            <tr>
                                <th>Tel raqam</th>
                                <td>{{ $user->dealer->phone_number }}</td>
                            </tr>
                            </tbody>
                        </table>

                        <!-- Counters Table -->
                        @if($user->dealer->counters->isNotEmpty())
                            <h5>Hisoblagichlar  ({{$counterCount}})</h5>
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
                                @foreach($user->dealer->counters as $counter)
                                    <tr>
                                        <td>{{ $counter->id }}</td>
                                        <td>{{ $counter->serial_number }}</td>
                                        <td>{{ $counter->imei }}</td>
                                        <td>{{ $counter->phone_number }}</td>
                                        <td>{{ $counter->created_at }}</td>
                                        <td>
                                            <a class="btn btn-success" href="{{route('counters.show',$counter->id)}}"><i class="bi bi-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        @else
                            <p>Dillerda hali hisoblagichlar mavjud emas.</p>
                        @endif
                    @else
                        <p>Bu foydalanuvchi diller emas.</p>
                    @endif

                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary mt-3">O'zgartirish</a>
                </div>
            </div>
        </div>
    </div>

@endsection
