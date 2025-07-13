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
        <form method="GET" action="{{ route('history') }}" class="row g-2 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Cari nama tamu...">
            </div>
            <div class="col-md-3">
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
            </div>
            <div class="col-md-3">
                <select name="jenis_tamu" class="form-select">
                    <option value="">-- Semua Jenis Tamu --</option>
                    <option value="Tamu Direksi" {{ request('jenis_tamu') == 'Tamu Direksi' ? 'selected' : '' }}>Tamu Direksi
                    </option>
                    <option value="Suplier/Vendor" {{ request('jenis_tamu') == 'Suplier/Vendor' ? 'selected' : '' }}>
                        Suplier/Vendor</option>
                    <option value="Customer/Owners" {{ request('jenis_tamu') == 'Customer/Owners' ? 'selected' : '' }}>
                        Customer/Owners</option>
                    <option value="Tamu Tenant" {{ request('jenis_tamu') == 'Tamu Tenant' ? 'selected' : '' }}>Tamu Tenant
                    </option>
                    <option value="Tamu Karyawan" {{ request('jenis_tamu') == 'Tamu Karyawan' ? 'selected' : '' }}>Tamu
                        Karyawan
                    </option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-warning text-white" type="submit">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <a href="{{ route('history') }}" class="btn btn-outline-secondary w-100 mt-2">
                    <i class="bi bi-x-circle me-1"></i> Reset
                </a>

            </div>
        </form>


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
                                @if ($tamu->nama_penerima && $tamu->nama_penerima !== '-')
                                    <li><strong>Penerima:</strong> {{ $tamu->nama_penerima }}</li>
                                @endif
                                <li><strong>Jam:</strong> {{ \Carbon\Carbon::parse($tamu->created_at)->format('H:i') }}</li>
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
                <div class="mt-4 d-flex justify-content-center">
                    {{ $tamus->withQueryString()->links() }}
                </div>

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

                <style>.pagination {
                    justify-content: center;
                }

                .pagination .page-link {
                    color: #FFBD38;
                    border: none;
                    font-weight: 500;
                }

                .pagination .page-item.active .page-link {
                    background-color: #FFBD38;
                    color: #fff;
                    border-radius: 50px;
                }
            </style>

            </style>
        @endpush
@endsection