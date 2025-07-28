@extends('layouts.app')

@section('title', 'Tamu Tukar Faktur')

@section('content')
<div class="container py-5" style="font-family: 'Poppins', sans-serif;">
    <h1 class="page-title mb-4">Daftar Tamu Tukar Faktur (FAT)</h1>

    @if ($tamus->isEmpty())
        <div class="alert alert-warning text-center rounded-4">
            Belum ada tamu tukar faktur di lokasi saat ini.
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($tamus as $tamu)
            <div class="col">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('storage/foto/' . $tamu->foto) }}"
                            onerror="this.onerror=null; this.src='{{ asset('img/avatar-default.png') }}';"
                            class="rounded-3 me-3"
                            style="width: 55px; height: 55px; object-fit: cover; cursor:pointer"
                            data-bs-toggle="modal" data-bs-target="#fotoModal{{ $tamu->id }}">
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $tamu->nama_tamu }}</h6>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($tamu->tanggal_kunjungan)->format('d M Y') }}</small>
                        </div>
                    </div>

                    <ul class="list-unstyled small text-dark mb-3">
                        <li><i class="bi bi-telephone me-2 text-muted"></i> {{ $tamu->telepon }}</li>
                        <li><i class="bi bi-clipboard-check me-2 text-muted"></i> Keperluan: {{ $tamu->keperluan }}</li>
                        @if ($tamu->dari_pt && $tamu->dari_pt !== '-')
                            <li><i class="bi bi-building me-2 text-muted"></i> {{ $tamu->dari_pt }}</li>
                        @endif
                        @if ($tamu->nama_penerima && $tamu->nama_penerima !== '-')
                            <li><i class="bi bi-person-check me-2 text-muted"></i> Penerima: {{ $tamu->nama_penerima }}</li>
                        @endif
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
                </div>
            </div>

            <!-- Modal Foto Tamu -->
            <div class="modal fade" id="fotoModal{{ $tamu->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $tamu->nama_tamu }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="{{ asset('storage/foto/' . $tamu->foto) }}"
                                onerror="this.onerror=null; this.src='{{ asset('img/avatar-default.png') }}';"
                                class="img-fluid rounded-3">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
