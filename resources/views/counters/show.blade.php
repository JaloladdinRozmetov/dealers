@extends('auth.layouts')

@section('content')

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex">
                    <h4>Counter Details</h4>
                    <a class="btn btn-primary ms-auto" href="{{ route('counters') }}">Back to Counters</a>
                </div>
                <div class="card-body">

                    <!-- Counter Information Table -->
                    <h5>Counter Information</h5>
                    <table class="table mb-4">
                        <tbody>
                        <tr>
                            <th>Counter ID</th>
                            <td>{{ $counter->id }}</td>
                        </tr>
                        <tr>
                            <th>Serial number</th>
                            <td>{{ $counter->serial_number }}</td>
                        </tr>
                        <tr>
                            <th>Caliber</th>
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
                            <th>Phone number</th>
                            <td>{{ $counter->phone_number }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $counter->created_at }}</td>
                        </tr>
                        </tbody>
                    </table>

                    <!-- Dealer Information Table -->
                    @if($counter->dealer)
                        <h5>Dealer Information</h5>
                        <table class="table mb-4">
                            <tbody>
                            <tr>
                                <th>Dealer ID</th>
                                <td>{{ $counter->dealer->id }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $counter->dealer->name }}</td>
                            </tr>
                            <tr>
                                <th>Director's Name</th>
                                <td>{{ $counter->dealer->director_name }}</td>
                            </tr>
                            <tr>
                                <th>INN</th>
                                <td>{{ $counter->dealer->INN }}</td>
                            </tr>
                            <tr>
                                <th>Office Address</th>
                                <td>{{ $counter->dealer->ofice_adres }}</td>
                            </tr>
                            <tr>
                                <th>Store Address</th>
                                <td>{{ $counter->dealer->store_adres }}</td>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <td>{{ $counter->dealer->phone_number }}</td>
                            </tr>
                            </tbody>
                        </table>
                    @else
                        <p>No dealer associated with this counter.</p>
                    @endif

                    <!-- Customer Information Table -->
                    @if($counter->customer)
                        <h5>Customer Information</h5>
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>Customer ID</th>
                                <td>{{ $counter->customer->id }}</td>
                            </tr>
                            <tr>
                                <th>Organization name</th>
                                <td>{{ $counter->customer->organization_name }}</td>
                            </tr>
                            <tr>
                                <th>INN</th>
                                <td>{{ $counter->customer->organization_INN }}</td>
                            </tr>
                            <tr>
                                <th>Director name</th>
                                <td>{{ $counter->customer->director_name }}</td>
                            </tr>
                            <tr>
                                <th>Counter Address</th>
                                <td>{{ $counter->customer->counter_address }}</td>
                            </tr>
                            <tr>
                                <th>Phone number</th>
                                <td>{{ $counter->customer->phone_number }}</td>
                            </tr>
                            </tbody>
                        </table>
                    @else
                        <p>No customer associated with this counter.</p>
                    @endif

                    <a href="{{ route('counters.edit', $counter->id) }}" class="btn btn-primary mt-3">Edit Counter</a>
                </div>
            </div>
        </div>
    </div>

@endsection
