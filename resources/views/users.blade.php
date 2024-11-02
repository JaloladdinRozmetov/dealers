@extends('auth.layouts')

@section('content')

    <div class="row justify-content-center mt-5">
        <div class="col-md-112">
            <div class="card">
                <div class="card-header d-flex">Dillerlar
                    <a class="btn btn-success ms-auto" href="{{ route('users.create') }}">Yaratish</a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Ism</th>
                        <th scope="col">Email</th>
                        <th scope="col">Tashkilot</th>
                        <th scope="col">Direktor Ismi</th>
                        <th scope="col">INN</th>
                        <th scope="col">Yuridik M</th>
                        <th scope="col">Do'kon M</th>
                        <th scope="col">Tel</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <th scope="row">{{$user->id}}</th>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{ $user->dealer ? $user->dealer->name : 'N/A' }}</td>
                            <td>{{ $user->dealer ? $user->dealer->director_name : 'N/A' }}</td>
                            <td>{{ $user->dealer ? $user->dealer->INN : 'N/A' }}</td>
                            <td>{{ $user->dealer ? $user->dealer->ofice_adres : 'N/A' }}</td>
                            <td>{{ $user->dealer ? $user->dealer->store_adres : 'N/A' }}</td>
                            <td>{{ $user->dealer ? $user->dealer->phone_number : 'N/A' }}</td>
                            <td>
                                <div class="d-flex">
                                    <form action="{{route('users.destroy',$user->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                    <a class="btn btn-primary ms-2" href="{{route('users.edit',$user->id)}}"><i class="bi bi-pencil-fill"></i></a>
                                    <a class="btn btn-success ms-2" href="{{route('users.show',$user->id)}}"><i class="bi bi-eye"></i></a>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
