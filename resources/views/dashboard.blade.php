@extends('layouts.app')

@section('content')
    <div class="container d-flex flex-column justify-content-center align-items-center py-5" style="min-height: 85vh;">
        {{-- Card Utama --}}
        <div class="card shadow-sm p-4 p-md-5 bg-white rounded-4 animate__animated animate__fadeInUp"
            style="max-width: 500px; width: 100%;">
            <div class="card-body text-center">
                <div class="mb-4">
                    <i class="bi bi-book-half display-4 text-warning animate__animated animate__fadeInDown"></i>
                </div>
                <h1 class="fw-semibold mb-3" style="font-size: 1.75rem;">
                    👋 Selamat Datang di Buku Tamu <span class="text-warning fw-bold">SUA!</span>
                </h1>
                <p class="text-muted mb-4" style="font-size: 1rem;">Kami senang Anda berkunjung!</p>

                <div class="d-grid gap-3">
                    <a href="{{ route('form') }}" class="btn btn-warning btn-lg rounded-pill text-white fw-medium">
                        <i class="bi bi-pencil-square me-2"></i> Isi Buku Tamu
                    </a>
                    <a href="{{ route('history') }}" class="btn btn-outline-secondary btn-lg rounded-pill fw-medium">
                        <i class="bi bi-journal-text me-2"></i> Lihat Riwayat
                    </a>
                </div>
            </div>
        </div>

        {{-- Statistik Tamu --}}
        <div class="container mt-5">
            <h4 class="text-center fw-semibold mb-4">📊 Statistik Tamu</h4>
            <div class="row row-cols-2 row-cols-md-4 g-3">
                @php
                    $stats = [
                        ['label' => 'Hari Ini', 'value' => $hariIni, 'color' => 'text-primary'],
                        ['label' => 'Minggu Ini', 'value' => $mingguIni, 'color' => 'text-success'],
                        ['label' => 'Bulan Ini', 'value' => $bulanIni, 'color' => 'text-warning'],
                        ['label' => 'Total', 'value' => $total, 'color' => 'text-dark']
                    ];
                @endphp

                @foreach($stats as $index => $stat)
                    <div class="col">
                        <div class="card border-0 shadow-sm h-100 animate__animated animate__fadeInUp"
                            style="animation-delay: {{ 1 + ($index * 0.2) }}s;">
                            <div class="card-body text-center py-4">
                                <small class="text-muted">{{ $stat['label'] }}</small>
                                <div class="fs-4 fw-bold {{ $stat['color'] }}">{{ $stat['value'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
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
                transition: all 0.3s ease;
            }

            .btn-warning:hover {
                background-color: #e0a32f;
                transform: translateY(-1px);
            }

            .btn-outline-secondary:hover {
                background-color: #f1f1f1;
                color: #000;
                transform: translateY(-1px);
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
    @endpush

    @push('scripts')
    @endpush
@endsection