@extends('layouts.app')

@section('title', 'Tambah Tamu Manual')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-4">Tambah Tamu Manual - {{ $event->nama_event }}</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('events.guests.store', $event->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_tamu" class="form-label">Nama Tamu</label>
            <input type="text" name="nama_tamu" id="nama_tamu" class="form-control" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('events.guests', $event->id) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
