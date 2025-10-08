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

    <!-- Tabel Daftar Tamu -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th class="text-start">Nama Tamu</th>
                            <th class="text-start">Jenis Tamu</th>
                            <th class="text-start">No Telp</th>
                            <th>Kehadiran</th>
                            <th>Aksi</th>
                            <th>Detail</th>
                        </tr>
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
                                    @if(!$guest->kehadiran)
                                        <button type="button" 
                                            class="btn btn-sm btn-success rounded-3 shadow-sm open-camera-btn"
                                            data-event-id="{{ $event->id }}" 
                                            data-guest-id="{{ $guest->id }}">
                                            <i class="bi bi-camera"></i> Ambil Foto
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-outline-danger rounded-3 shadow-sm" disabled>
                                            <i class="bi bi-person-check me-1"></i> Sudah Hadir
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary rounded-3 shadow-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $guest->id }}">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Detail -->
                            <div class="modal fade" id="detailModal{{ $guest->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content rounded-4 border-0 shadow-lg">
                                        <div class="modal-header bg-dark text-white rounded-top-4">
                                            <h5 class="modal-title">Detail Kehadiran - {{ $guest->nama_tamu }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row align-items-start">
                                                <div class="col-md-6 text-center mb-3 mb-md-0">
                                                    @if($guest->attendance && $guest->attendance->foto)
                                                        <img src="{{ asset('storage/' . $guest->attendance->foto) }}" 
                                                             class="img-fluid rounded-4 shadow-sm" 
                                                             style="max-height: 250px; object-fit: cover;">
                                                    @else
                                                        <div class="text-muted fst-italic">Belum ada foto kehadiran</div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item"><strong>Nama:</strong> {{ $guest->nama_tamu }}</li>
                                                        <li class="list-group-item"><strong>Jenis Tamu:</strong> {{ $guest->jenis_tamu ?? '-' }}</li>
                                                        <li class="list-group-item"><strong>No Telp:</strong> {{ $guest->no_telp ?? '-' }}</li>
                                                        <li class="list-group-item"><strong>Status:</strong>
                                                            <span class="badge {{ $guest->kehadiran ? 'bg-success' : 'bg-secondary' }}">
                                                                {{ $guest->kehadiran ? 'Hadir' : 'Belum Hadir' }}
                                                            </span>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <strong>Waktu Kehadiran:</strong>
                                                            @if($guest->attendance)
                                                                {{ \Carbon\Carbon::parse($guest->attendance->waktu_hadir)->translatedFormat('d F Y - H:i') }}
                                                            @else
                                                                <span class="text-muted">Belum tercatat</span>
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
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

<!-- Modal Kamera -->
<div class="modal fade" id="cameraModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Ambil Foto Kehadiran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <video id="cameraStream" autoplay playsinline class="w-100 rounded mb-3" style="max-height:300px;"></video>
                <canvas id="photoCanvas" class="d-none"></canvas>
                <button id="captureBtn" class="btn btn-success rounded-3 px-4"><i class="bi bi-camera"></i> Jepret</button>
            </div>
        </div>
    </div>
</div>

<form id="photoForm" method="POST" enctype="multipart/form-data" style="display:none;">
    @csrf
    <input type="hidden" name="foto" id="fotoBase64">
</form>

@push('scripts')
<script>
let currentEventId, currentGuestId, stream;

document.querySelectorAll('.open-camera-btn').forEach(btn => {
    btn.addEventListener('click', async function() {
        currentEventId = this.dataset.eventId;
        currentGuestId = this.dataset.guestId;

        const modal = new bootstrap.Modal(document.getElementById('cameraModal'));
        modal.show();

        const video = document.getElementById('cameraStream');
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } });
            video.srcObject = stream;
        } catch (err) {
            alert('Gagal mengakses kamera: ' + err.message);
        }
    });
});

document.getElementById('captureBtn').addEventListener('click', async function() {
    const canvas = document.getElementById('photoCanvas');
    const video = document.getElementById('cameraStream');
    const context = canvas.getContext('2d');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0);

    const dataUrl = canvas.toDataURL('image/jpeg');
    document.getElementById('fotoBase64').value = dataUrl;

    // hentikan kamera
    stream.getTracks().forEach(track => track.stop());
    bootstrap.Modal.getInstance(document.getElementById('cameraModal')).hide();

    // kirim ke server
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('foto', dataUrl);

    const response = await fetch(`/events/${currentEventId}/guests/${currentGuestId}/attendance`, {
        method: 'POST',
        body: formData
    });

    if (response.ok) {
        location.reload();
    } else {
        alert('Gagal menyimpan foto.');
    }
});
</script>
@endpush
@endsection
