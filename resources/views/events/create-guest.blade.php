@extends('layouts.app')

@section('title', 'Tambah Tamu - ' . $event->nama_event)

@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-4">Tambah Tamu untuk {{ $event->nama_event }}</h3>

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

<form action="{{ route('events.guests.store', $event->id) }}" method="POST">
        @csrf

        <div id="guest-list">
            <div class="guest-item border rounded-4 p-3 mb-3">
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Nama Tamu</label>
                        <input type="text" name="guests[0][nama_tamu]" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Instansi</label>
                        <input type="text" name="guests[0][instansi]" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" name="guests[0][no_hp]" class="form-control">
                    </div>
                    <div class="col-md-1 text-center">
                        <button type="button" class="btn btn-danger btn-sm remove-guest mt-3" disabled>
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <button type="button" class="btn btn-secondary" id="addGuestBtn">
                <i class="bi bi-person-plus"></i> Tambah Tamu
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan Semua
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let index = 1;
    const guestList = document.getElementById('guest-list');
    const addBtn = document.getElementById('addGuestBtn');

    addBtn.addEventListener('click', () => {
        const newGuest = document.createElement('div');
        newGuest.classList.add('guest-item', 'border', 'rounded-4', 'p-3', 'mb-3');
        newGuest.innerHTML = `
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Nama Tamu</label>
                    <input type="text" name="guests[${index}][nama_tamu]" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Instansi</label>
                    <input type="text" name="guests[${index}][instansi]" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" name="guests[${index}][no_hp]" class="form-control">
                </div>
                <div class="col-md-1 text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-guest mt-3">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        guestList.appendChild(newGuest);
        index++;
        updateRemoveButtons();
    });

    guestList.addEventListener('click', (e) => {
        if (e.target.closest('.remove-guest')) {
            e.target.closest('.guest-item').remove();
            updateRemoveButtons();
        }
    });

    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.remove-guest');
        removeButtons.forEach(btn => {
            btn.disabled = document.querySelectorAll('.guest-item').length === 1;
        });
    }
});
</script>
@endsection
