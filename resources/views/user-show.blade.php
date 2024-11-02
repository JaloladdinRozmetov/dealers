@extends('auth.layouts')

@section('content')

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex">
                    <h4>User and Dealer Details</h4>
                    <a class="btn btn-primary ms-auto" href="{{ route('users') }}">Back to Users</a>
                </div>
                <div class="card-body">
                    <!-- User Information Table -->
                    <table class="table mb-4">
                        <tbody>
                        <tr>
                            <th>User ID</th>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
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
                        <h5>Dealer Information</h5>
                        <table class="table mb-4">
                            <tbody>
                            <tr>
                                <th>Dealer ID</th>
                                <td>{{ $user->dealer->id }}</td>
                            </tr>
                            <tr>
                                <th>Organization</th>
                                <td>{{ $user->dealer->name }}</td>
                            </tr>
                            <tr>
                                <th>Director's Name</th>
                                <td>{{ $user->dealer->director_name }}</td>
                            </tr>
                            <tr>
                                <th>INN</th>
                                <td>{{ $user->dealer->INN }}</td>
                            </tr>
                            <tr>
                                <th>Office Address</th>
                                <td>{{ $user->dealer->ofice_adres }}</td>
                            </tr>
                            <tr>
                                <th>Store Address</th>
                                <td>{{ $user->dealer->store_adres }}</td>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <td>{{ $user->dealer->phone_number }}</td>
                            </tr>
                            </tbody>
                        </table>

                        <!-- Counters Table -->
                        @if($user->dealer->counters->isNotEmpty())
                            <h5>Counters</h5>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Serial Number</th>
                                    <th>imei</th>
                                    <th>phone_number</th>
                                    <th>Created at</th>
                                    <th>Actions</th>
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
                        @else
                            <p>No counters available for this dealer.</p>
                        @endif
                    @else
                        <p>This user does not have an associated dealer.</p>
                    @endif

                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary mt-3">Edit User</a>
                </div>
            </div>
        </div>
    </div>

@endsection
