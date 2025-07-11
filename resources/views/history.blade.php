@extends('layouts.app')

@section('content')
    <div class="container my-5" style="font-family: 'Poppins', sans-serif;">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <h4 class="fw-bold mb-3" style="font-size: 1.75rem;">
                <span class="text-dark">Riwayat</span> <span style="color: #FFBD38;">Buku Tamu</span>
            </h4>
            <a href="{{ route('history.export') }}" class="btn btn-success rounded-pill px-4 py-2">
                <i class="bi bi-file-earmark-spreadsheet me-2"></i> Export
            </a>
        </div>

        @if ($tamus->isEmpty())
            <div class="alert alert-warning text-center py-4 rounded-4">
                Belum ada data tamu yang tercatat.
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($tamus as $tamu)
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0 rounded-4 p-3 bg-white">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset('storage/foto/' . $tamu->foto) }}" class="rounded-circle shadow-sm me-3"
                                    style="width: 60px; height: 60px; object-fit: cover;">
                                <div>
                                    <h6 class="fw-bold mb-0">{{ $tamu->nama_tamu }}</h6>
                                    <small
                                        class="text-muted">{{ \Carbon\Carbon::parse($tamu->tanggal_kunjungan)->format('d M Y') }}</small>
                                </div>
                            </div>

                            <ul class="list-unstyled mb-3 small text-dark">
                                <li><strong>Telepon:</strong> {{ $tamu->telepon }}</li>
                                <li><strong>Keperluan:</strong> {{ $tamu->keperluan }}</li>
                                <li><strong>Jenis Tamu:</strong> {{ $tamu->jenis_tamu }}</li>
                            </ul>

                            <form action="{{ route('history.destroy', $tamu->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm w-100 rounded-pill">
                                    <i class="bi bi-trash3 me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Custom Styles --}}
    @push('styles')
        <style>
            body {
                background-color: #f8f9fa;
            }

            .card {
                transition: all 0.3s ease;
            }

            .card:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.06);
            }

            .btn-success {
                background-color: #28a745;
                border: none;
            }

            .btn-success:hover {
                background-color: #218838;
            }

            .btn-outline-danger:hover {
                background-color: #dc3545;
                color: #fff;
            }
        </style>
    @endpush
@endsection