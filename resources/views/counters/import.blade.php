@extends('auth.layouts')

@section('content')
    <div class="container">
        <h2>Hisoblagich ma'lumotlarni yuklash</h2>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Fayilni yuklang</label>
                <input type="file" name="file" class="form-control" required><br>
                @error('file')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Ma'lumotlarni yuklash</button>
        </form>
    </div>
@endsection
