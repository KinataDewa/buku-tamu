@extends('layouts.app')

@section('title', 'Riwayat Buku Tamu')

@section('content')
<div class="container py-5" style="font-family: 'Poppins', sans-serif;">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <h1 class="page-title mb-4" style="font-family: 'Poppins', sans-serif;">History Buku Tamu</h1>

        <a href="{{ route('history.export') }}" class="btn btn-success rounded-3 px-4">
            <i class="bi bi-file-earmark-arrow-down me-2"></i> Export
        </a>
    </div>

    {{-- Filter --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 p-4">
        <form method="GET" action="{{ route('history') }}" class="row gy-3 gx-4 align-items-end">
            <div class="col-md-4">
                <label class="form-label text-muted">Cari Nama</label>
                <input type="text" name="search" class="form-control rounded-3" placeholder="Masukkan nama tamu..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted">Tanggal Kunjungan</label>
                <input type="date" name="tanggal" class="form-control rounded-3" value="{{ request('tanggal') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted">Jenis Tamu</label>
                <select name="jenis_tamu" class="form-select rounded-3">
                    <option value="">Semua Jenis</option>
                    @foreach (['Tamu Direksi', 'Suplier/Vendor', 'Customer/Owners', 'Tamu Tenant', 'Tamu Karyawan'] as $jenis)
                        <option value="{{ $jenis }}" {{ request('jenis_tamu') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-grid gap-2">
                <button type="submit" class="btn btn-dark">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
                <a href="{{ route('history') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>

    {{-- Data --}}
    @if ($tamus->isEmpty())
        <div class="alert alert-warning text-center rounded-4">Belum ada data tamu yang tercatat.</div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($tamus as $tamu)
            <div class="col">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('storage/foto/' . $tamu->foto) }}"
                            onerror="this.onerror=null; this.src='{{ asset('img/avatar-default.png') }}';"
                            class="rounded-3 me-3" style="width: 55px; height: 55px; object-fit: cover;">
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $tamu->nama_tamu }}</h6>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($tamu->tanggal_kunjungan)->format('d M Y') }}</small>
                        </div>
                    </div>

                    <ul class="list-unstyled small text-dark mb-3">
                        <li><i class="bi bi-telephone me-2 text-muted"></i> {{ $tamu->telepon }}</li>
                        <li><i class="bi bi-person-badge me-2 text-muted"></i> {{ $tamu->jenis_tamu }}</li>
                        <li><i class="bi bi-card-heading me-2 text-muted"></i> Kartu: <strong>{{ $tamu->nomor_kartu ?? '-' }}</strong></li>
                        @if ($tamu->dari_pt && $tamu->dari_pt !== '-') <li><i class="bi bi-building me-2 text-muted"></i> {{ $tamu->dari_pt }}</li>@endif
                        @if ($tamu->nama_penerima && $tamu->nama_penerima !== '-') <li><i class="bi bi-person-check me-2 text-muted"></i> Penerima: {{ $tamu->nama_penerima }}</li>@endif
                        <li>
                            <i class="bi bi-clock me-2 text-muted"></i> 
                            {{ $tamu->jam_kunjungan }} 
                            @if ($tamu->jam_keluar)
                                – {{ $tamu->jam_keluar }}
                            @else
                                <span class="badge bg-warning text-dark ms-2">Masih di lokasi</span>
                            @endif
                        </li>
                    </ul>

                    <div class="d-flex gap-2">
                        @if (!$tamu->jam_keluar)
                            <form method="POST" action="{{ route('history.keluar', $tamu->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-sm w-100" onclick="return confirm('Tamu akan dicatat sudah keluar?')">
                                    <i class="bi bi-door-closed me-1"></i> Keluar
                                </button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('history.destroy', $tamu->id) }}" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm w-100">
                                <i class="bi bi-trash3 me-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $tamus->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
