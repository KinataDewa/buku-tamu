@extends('layouts.app')

@section('title', 'Tambah Event')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-4">Tambah Event</h3>

    <form action="{{ route('events.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_event" class="form-label">Nama Event</label>
            <input type="text" name="nama_event" id="nama_event" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_event" class="form-label">Tanggal Event</label>
            <input type="date" name="tanggal_event" id="tanggal_event" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
