@extends('layouts.app')

@section('title', 'Daftar Tamu - ' . $event->nama_event)

@section('content')
<div class="container py-5">

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
        <h3 class="fw-bold mb-0 text-dark">{{ $event->nama_event }}</h3>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('events.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <a href="{{ route('events.guests.create', $event->id) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-person-plus me-1"></i> Tambah Tamu
            </a>
            <a href="{{ route('events.guests.export', $event->id) }}" class="btn btn-success btn-sm">
                <i class="bi bi-file-earmark-excel me-1"></i> Export
            </a>
        </div>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Import Excel -->
    <form action="{{ route('events.guests.import', $event->id) }}" method="POST" enctype="multipart/form-data" class="mb-4 d-flex gap-2">
        @csrf
        <input type="file" name="file" class="form-control form-control-sm" required>
        <button class="btn btn-primary btn-sm">Import Excel
        </button>
    </form>

    <!-- Tabel Daftar Tamu -->
    <div class="table-responsive shadow-sm rounded-3">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-center">
                <tr>
                    <th style="width:5%">No</th>
                    <th class="text-start">Nama Tamu</th>
                    <th style="width:15%">Kehadiran</th>
                    <th style="width:15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($event->guests as $guest)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-start">{{ $guest->nama_tamu }}</td>
                        <td>
                            <span class="badge {{ $guest->kehadiran ? 'bg-success' : 'bg-secondary' }}">
                                {{ $guest->kehadiran ? 'Hadir' : 'Belum Hadir' }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('events.guests.attendance', ['event_id' => $event->id, 'guest_id' => $guest->id]) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm {{ $guest->kehadiran ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                    {{ $guest->kehadiran ? 'Batalkan' : 'Hadir' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Belum ada tamu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }

    .btn-outline-success {
        color: #198754;
        border-color: #198754;
    }
    .btn-outline-success:hover {
        background-color: #198754;
        color: #fff;
    }

    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-primary {
        background-color: #0d6efd;
        border: none;
    }
    .btn-primary:hover {
        background-color: #0b5ed7;
    }

    .badge {
        font-size: 0.85rem;
        padding: 0.45em 0.7em;
    }

    @media (max-width: 576px) {
        .table-responsive {
            overflow-x: auto;
        }

        .d-flex.flex-md-row {
            flex-direction: column !important;
            align-items: flex-start !important;
        }
    }
</style>
@endpush
@endsection
