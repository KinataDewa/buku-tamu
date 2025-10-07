@extends('layouts.app')

@section('title', 'Tambah Tamu Manual')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Tambah Tamu Manual</h3>
        <span class="text-secondary">{{ $event->nama_event }}</span>
    </div>

    {{-- Alert Error --}}
    @if($errors->any())
        <div class="alert alert-danger rounded-4 shadow-sm">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('events.guests.store', $event->id) }}" method="POST">
                @csrf

                {{-- Nama Tamu --}}
                <div class="mb-3">
                    <label for="nama_tamu" class="form-label fw-semibold">Nama Tamu</label>
                    <input type="text" name="nama_tamu" id="nama_tamu" class="form-control rounded-3" placeholder="Masukkan nama tamu" required>
                </div>

                {{-- Jenis Tamu --}}
                <div class="mb-3">
                    <label for="jenis_tamu" class="form-label fw-semibold">Jenis Tamu</label>
                    <select name="jenis_tamu" id="jenis_tamu" class="form-select rounded-3" required>
                        <option value="" disabled selected>Pilih jenis tamu</option>
                        <option value="VIP">VIP</option>
                        <option value="Undangan">Undangan</option>
                        <option value="Vendor">Vendor</option>
                        <option value="Internal">Internal</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                {{-- Nomor Telepon --}}
                <div class="mb-4">
                    <label for="no_telp" class="form-label fw-semibold">Nomor Telepon</label>
                    <input type="tel" name="no_telp" id="no_telp" class="form-control rounded-3" placeholder="Contoh: 081234567890">
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('events.guests', $event->id) }}" class="btn btn-light border rounded-3 px-4">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-dark rounded-3 px-4 shadow-sm">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    body { background-color: #f8fafc; }
    .card {
        background-color: #fff;
        transition: all .2s ease;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.08);
    }
</style>
@endpush
@endsection
