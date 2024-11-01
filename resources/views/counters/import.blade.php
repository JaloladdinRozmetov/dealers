@extends('auth.layouts')

@section('content')
    <div class="container">
        <h2>Import Excel Data</h2>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Choose Excel File</label>
                <input type="file" name="file" class="form-control" required><br>
                @error('file')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Import Data</button>
        </form>
    </div>
@endsection
