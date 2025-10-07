@extends('layouts.app')

@section('title', 'Tambah Event')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title mb-0 fw-bold">Tambah Event</h1>
        <a href="{{ route('events.index') }}" class="btn btn-outline-secondary rounded-3 shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('events.store') }}" method="POST">
                @csrf

                {{-- Nama Event --}}
                <div class="mb-3">
                    <label for="nama_event" class="form-label fw-semibold">Nama Event</label>
                    <input type="text" 
                           name="nama_event" 
                           id="nama_event" 
                           class="form-control rounded-3" 
                           placeholder="Masukkan nama event"
                           required>
                </div>

                {{-- Tanggal Event --}}
                <div class="mb-4">
                    <label for="tanggal_event" class="form-label fw-semibold">Tanggal Event</label>
                    <input type="date" 
                           name="tanggal_event" 
                           id="tanggal_event" 
                           class="form-control rounded-3" 
                           required>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-dark text-white rounded-3 shadow-sm px-4">
                        <i class="bi bi-send"></i> Simpan
                    </button>
                    <a href="{{ route('events.index') }}" class="btn btn-light border rounded-3 px-4">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
