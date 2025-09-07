@extends('layouts.app')

@section('title', 'Daftar Event')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Daftar Event</h3>
        <a href="{{ route('events.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Event
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Event</th>
                <th>Tanggal</th>
                <th>Jumlah Tamu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $event->nama_event }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->tanggal_event)->format('d M Y') }}</td>
                    <td>{{ $event->guests_count }}</td>
                    <td>
                        <a href="{{ route('events.guests', $event->id) }}" class="btn btn-sm btn-info">Lihat Tamu</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada event</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
