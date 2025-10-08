@extends('layouts.app')

@section('title', 'Daftar Tamu - ' . $event->nama_event)

@section('content')
<div class="container py-5">

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <h3 class="fw-bold mb-0 text-dark">
            <i class="page-title"></i> {{ $event->nama_event }}
        </h3>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('events.guests.create', $event->id) }}" class="btn btn-dark rounded-3 shadow-sm">
                <i class="bi bi-person-plus me-1"></i> Tambah Tamu
            </a>
            <a href="{{ route('events.guests.export', $event->id) }}" class="btn btn-success rounded-3 shadow-sm">
                <i class="bi bi-file-earmark-excel me-1"></i> Export
            </a>
        </div>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Import Excel -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('events.guests.import', $event->id) }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column flex-sm-row gap-2">
                @csrf
                <input type="file" name="file" class="form-control form-control-sm rounded-3 shadow-sm" required>
                <button class="btn btn-dark btn-sm rounded-3 shadow-sm px-4">Import
                </button>
            </form>
        </div>
    </div>

    <!-- Tabel Daftar Tamu -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th style="width:5%">No</th>
                            <th class="text-start">Nama Tamu</th>
                            <th class="text-start">Jenis Tamu</th>
                            <th class="text-start">No Telp</th>
                            <th style="width:15%">Kehadiran</th>
                            <th style="width:20%">Aksi</th>
                            <th class="text-start">Detail</th>                        </tr>
                    </thead>
                    <tbody>
                        @forelse($event->guests as $guest)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start fw-medium">{{ $guest->nama_tamu }}</td>
                                <td class="text-start fw-medium">{{ $guest->jenis_tamu }}</td>
                                <td class="text-start fw-medium">{{ $guest->no_telp }}</td>
                                <td>
                                    <span class="badge px-3 py-2 rounded-pill {{ $guest->kehadiran ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $guest->kehadiran ? 'Hadir' : 'Belum Hadir' }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('events.guests.attendance', ['event_id' => $event->id, 'guest_id' => $guest->id]) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm px-3 rounded-3 shadow-sm {{ $guest->kehadiran ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                            {{ $guest->kehadiran ? 'Batalkan' : 'Hadir' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="bi bi-person-x fs-4 d-block mb-2"></i>
                                    Belum ada tamu yang terdaftar
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
    }

    /* Hover pada tabel */
    .table-hover tbody tr:hover {
        background-color: #f1f3f5;
        transition: background-color 0.2s ease-in-out;
    }

    /* Style badge */
    .badge {
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* Tombol outline success */
    .btn-outline-success {
        color: #198754;
        border-color: #198754;
        transition: 0.2s;
    }
    .btn-outline-success:hover {
        background-color: #198754;
        color: #fff;
    }

    /* Tombol outline danger */
    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
        transition: 0.2s;
    }
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    /* Untuk layar kecil */
    @media (max-width: 576px) {
        .d-flex.flex-md-row {
            flex-direction: column !important;
            align-items: flex-start !important;
        }

        .table thead {
            font-size: 0.85rem;
        }

        .table tbody td {
            font-size: 0.9rem;
        }
    }
</style>
@endpush
@endsection