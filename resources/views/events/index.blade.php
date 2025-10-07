@extends('layouts.app')

@section('title', 'Daftar Event')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title mb-0">Daftar Event</h1>
        <a href="{{ route('events.create') }}" class="btn btn-warning rounded-3 shadow-sm">
            <i class="bi bi-plus-lg"></i> Tambah Event
        </a>
    </div>

    <!-- Alert Sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Jika belum ada event -->
    @if($events->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-calendar-x display-4 text-muted"></i>
            <h5 class="mt-3 text-muted">Belum ada event</h5>
            <p class="text-secondary">Klik tombol <strong>Tambah Event</strong> untuk memulai.</p>
        </div>
    @else
        <!-- List Event dalam Grid -->
        <div class="row g-4">
            @foreach($events as $event)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body text-center p-4">

                            <!-- Tanggal Event -->
                            <span class="badge bg-light text-dark mb-3 px-3 py-2 rounded-pill">
                                {{ \Carbon\Carbon::parse($event->tanggal_event)->format('d M Y') }}
                            </span>

                            <!-- Nama Event -->
                            <h5 class="fw-bold text-dark mb-2">{{ $event->nama_event }}</h5>

                            <!-- Jumlah Tamu -->
                            <p class="text-muted mb-4">
                                <i class="bi bi-people-fill me-1"></i>
                                {{ $event->guests_count }} Tamu
                            </p>

                            <!-- Tombol Aksi -->
                            <a href="{{ route('events.guests', $event->id) }}" 
                               class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                <i class="bi bi-eye me-1"></i> Lihat Tamu
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
    }

    .card {
        transition: all 0.2s ease;
        background: #fff;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    }

    .btn-warning {
        background-color: #FFBD38;
        border: none;
        font-weight: 500;
    }

    .btn-warning:hover {
        background-color: #e0a32f;
    }
</style>
@endpush
@endsection
