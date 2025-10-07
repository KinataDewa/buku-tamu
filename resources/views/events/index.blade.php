@extends('layouts.app')

@section('title', 'Daftar Event')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h1 class="page-title">📅 Daftar Event</h1>
        <a href="{{ route('events.create') }}" class="btn btn-dark rounded-3 shadow-sm">
            <i class="bi bi-plus-lg"></i> Tambah Event
        </a>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
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
        <!-- Grid modern -->
        <div class="row g-4">
            @php
                $accentColors = ['#FFBD38', '#0d6efd', '#20c997', '#6f42c1', '#fd7e14', '#dc3545'];
            @endphp

            @foreach($events as $index => $event)
                @php $accent = $accentColors[$index % count($accentColors)]; @endphp

                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="event-card border-0 shadow-sm rounded-4 h-100"
                         style="--accent: {{ $accent }}">

                        <div class="card-body p-4 d-flex flex-column">

                            <!-- Header dengan accent -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge text-dark fw-semibold px-3 py-2 rounded-pill" 
                                      style="background-color: var(--accent, #FFBD38)1A;">
                                    {{ \Carbon\Carbon::parse($event->tanggal_event)->format('d M Y') }}
                                </span>
                                <div class="rounded-circle p-2" style="background-color: var(--accent, #FFBD38); opacity: 0.15;">
                                    <i class="bi bi-calendar-event text-dark"></i>
                                </div>
                            </div>

                            <!-- Nama Event -->
                            <h5 class="fw-bold text-dark mb-1">{{ $event->nama_event }}</h5>

                            <!-- Jenis Event -->
                            <p class="text-secondary small mb-1">
                                <i class="bi bi-tags me-1 text-muted"></i> {{ $event->jenis_event ?? '-' }}
                            </p>

                            <!-- PT -->
                            <p class="text-secondary small mb-3">
                                <i class="bi bi-building me-1 text-muted"></i> {{ $event->pt_penyelenggara ?? '-' }}
                            </p>

                            <div class="mt-auto">
                                <hr class="my-3">

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted small">
                                        <i class="bi bi-people me-1"></i> {{ $event->guests_count }} tamu
                                    </div>

                                    <a href="{{ route('events.guests', $event->id) }}" 
                                       class="btn btn-sm rounded-3 fw-semibold px-3 py-2"
                                       style="background-color: var(--accent); color: #fff;">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>
                                </div>
                            </div>
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
        background-color: #f8fafc;
    }

    .event-card {
        background: #fff;
        border-radius: 1rem;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .event-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: 5px;
        width: 100%;
        background-color: var(--accent, #FFBD38);
    }

    .event-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 26px rgba(0, 0, 0, 0.08);
    }

    .badge {
        background-color: rgba(255, 189, 56, 0.1);
    }

    .btn-warning {
        background-color: #FFBD38;
        border: none;
        color: #222;
    }

    .btn-warning:hover {
        background-color: #e6a92c;
        color: #000;
    }

    hr {
        opacity: 0.1;
    }

    @media (max-width: 576px) {
        .event-card {
            margin-bottom: 1rem;
        }
    }
</style>
@endpush
@endsection
