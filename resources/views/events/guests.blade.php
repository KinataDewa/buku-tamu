@extends('layouts.app')

@section('title', 'Daftar Tamu - ' . $event->nama_event)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Daftar Tamu: {{ $event->nama_event }}</h3>
        <div>
            <a href="{{ route('events.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('events.guests.export', $event->id) }}" class="btn btn-success">Export Excel</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Import Excel -->
    <form action="{{ route('events.guests.import', $event->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        <div class="input-group">
            <input type="file" name="file" class="form-control" required>
            <button class="btn btn-primary" type="submit">Import Excel</button>
        </div>
    </form>

    <!-- Tabel Daftar Tamu -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tamu</th>
                <th>Kehadiran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($event->guests as $guest)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $guest->nama_tamu }}</td>
                    <td>
                        @if($guest->kehadiran)
                            <span class="badge bg-success">Hadir</span>
                        @else
                            <span class="badge bg-secondary">Belum Hadir</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('events.guests.attendance', $guest->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm {{ $guest->kehadiran ? 'btn-danger' : 'btn-success' }}">
                                {{ $guest->kehadiran ? 'Batalkan' : 'Hadir' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada tamu</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
