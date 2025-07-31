@extends('layouts.app')

@section('content')
<div class="container py-5" style="min-height: 85vh;">
    <div class="row g-4 align-items-center">

        {{-- Kiri: Card Utama --}}
        <div class="col-12 col-lg-6 d-flex justify-content-center">
            <div class="card shadow-sm p-4 p-md-5 bg-white rounded-4 w-100 animate__animated animate__fadeInUp"
                style="max-width: 500px;">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="bi bi-book-half display-4 text-warning animate__animated animate__fadeInDown"></i>
                    </div>
                    <h1 class="fw-semibold mb-3" style="font-size: 1.75rem;">
                        👋 Selamat Datang di Buku Tamu <span class="text-warning fw-bold">SUA!</span>
                    </h1>
                    <p class="text-muted mb-4" style="font-size: 1rem;">Kami senang Anda berkunjung!</p>

                    <div class="d-grid gap-3">
                        <a href="{{ route('form') }}" class="btn btn-warning btn-lg rounded-pill text-white fw-medium shadow-sm">
                            <i class="bi bi-pencil-square me-2"></i> Isi Buku Tamu
                        </a>
                        <a href="{{ route('history') }}" class="btn btn-outline-secondary btn-lg rounded-pill fw-medium shadow-sm">
                            <i class="bi bi-journal-text me-2"></i> Lihat Riwayat
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <h4 class="text-center fw-semibold mb-4">📊 Statistik Tamu</h4>
            <div class="row row-cols-2 row-cols-md-2 g-3">
                @foreach($jenisStats as $jenis => $jumlah)
                    <div class="col">
                        <div class="card card-stat border-0 shadow-sm h-100 rounded-4" data-jenis="{{ $jenis }}">
                            <div class="card-body text-center py-4">
                                <small>{{ $jenis }}</small>
                                <div class="fs-4 fw-bold">{{ $jumlah }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Styles --}}
@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
        }

        .card {
            border-radius: 1rem;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
        }

        .btn-warning {
            background-color: #FFBD38;
            border: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        

        .btn-warning:hover {
            background-color: #e0a32f;
            transform: translateY(-1px);
        }

        .btn-outline-secondary {
            border-color: #000;
            color: #000;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background-color: #000;
            color: #fff;
            transform: translateY(-1px);
        }

        .fs-4 {
            font-size: 1.5rem;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 1.5rem;
            }

            .fs-4 {
                font-size: 1.25rem !important;
            }
        }
    </style>

        <style>
        /* Card Statistik */
        .card-stat {
            border-radius: 1rem;
            transition: all 0.3s ease;
            background: #fff;
        }

        .card-stat:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
        }

        .card-stat .card-body {
            padding: 1.5rem 1rem;
        }

        .card-stat small {
            font-size: 0.85rem;
            color: #6c757d;
            display: block;
            margin-bottom: 0.3rem;
        }

        .card-stat .fs-4 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #222;
        }

        /* Warna khusus per jenis tamu */
        .card-stat[data-jenis="Tamu Direksi"] .fs-4 { color: #0d6efd; }      /* Biru */
        .card-stat[data-jenis="Tamu Tenant"] .fs-4 { color: #20c997; }       /* Hijau */
        .card-stat[data-jenis="Suplier/Vendor"] .fs-4 { color: #ffc107; }    /* Kuning */
        .card-stat[data-jenis="Tamu Karyawan SUA"] .fs-4 { color: #fd7e14; } /* Oranye */
        .card-stat[data-jenis="FAT"] .fs-4 { color: #6f42c1; }           /* Ungu */

        @media (max-width: 768px) {
            .card-stat .fs-4 {
                font-size: 1.25rem;
            }
        }
    </style>

@endpush

@endsection
