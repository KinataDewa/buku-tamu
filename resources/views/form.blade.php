@extends('layouts.app')

@push('styles')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }

    .form-wrapper {
        background: #fff;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .form-wrapper:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }

    .section-title {
        font-weight: 600;
        color: #222;
        font-size: 1.05rem;
        border-left: 4px solid #FFBD38;
        padding-left: 10px;
        margin-bottom: 1rem;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        border: 1px solid #ddd;
        padding: 0.65rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #FFBD38;
        box-shadow: 0 0 0 3px rgba(255, 189, 56, 0.2);
    }

    .btn-primary {
        background-color: #FFBD38;
        border: none;
        color: #fff;
        font-weight: 500;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #e6a800;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(255,189,56,0.3);
    }

    .btn-success {
        background-color: #000;
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background-color: #333;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(0,0,0,0.2);
    }

    .page-title {
        font-weight: 700;
        color: #222;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 767px) {
        .form-wrapper {
            padding: 1.2rem;
        }
        .section-title {
            font-size: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <h1 class="page-title">Form Buku Tamu</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="formTamu" method="POST" action="{{ route('form.store') }}" autocomplete="off">
        @csrf
        <input type="hidden" name="tanggal_kunjungan" value="{{ date('Y-m-d') }}">
        <input type="hidden" name="jam_kunjungan" id="jam_kunjungan">

        <div class="row g-4">
            {{-- ✅ Kolom Kiri --}}
            <div class="col-12 col-lg-6">
                <div class="form-wrapper h-100">
                    <h5 class="section-title">👤 Data Tamu</h5>

                    <div class="mb-3">
                        <label class="form-label">Nama Tamu</label>
                        <input type="text" class="form-control" name="nama_tamu" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control" name="telepon" placeholder="08xxxxxxxxxx" required>
                    </div>

                    <h5 class="section-title mt-4">📌 Data Kunjungan</h5>
                    <div class="mb-3">
                        <label class="form-label">Pilih Keperluan</label>
                        <select class="form-select" name="keperluan" id="keperluan" required onchange="handleKeperluanChange()">
                            <option value="">-- Pilih Keperluan --</option>
                            <option value="FAT">Tukar Faktur (FAT)</option>
                            <option value="janji">Janji Ketemu</option>
                        </select>
                    </div>

                    <div class="mb-3" id="jenisTamuWrapper">
                        <label class="form-label">Jenis Tamu</label>
                        <select class="form-select" id="jenis_tamu">
                            <option value="">-- Pilih Jenis Tamu --</option>
                            <option value="Tamu Direksi">Tamu Direksi</option>
                            <option value="Suplier/Vendor">Suplier/Vendor</option>
                            <option value="Customer/Owners">Customer/Owners</option>
                            <option value="Tamu Tenant">Tamu Tenant</option>
                            <option value="Tamu Karyawan SUA">Tamu Karyawan SUA</option>
                        </select>
                        <input type="hidden" name="jenis_tamu" id="jenis_tamu_hidden">
                    </div>

                    <div class="mb-3" id="ptWrapper" style="display:none;">
                        <label class="form-label">Asal Perusahaan</label>
                        <input type="text" class="form-control" name="dari_pt" id="dari_pt">
                        <input type="hidden" name="dari_pt_hidden" id="dari_pt_hidden" value="-">
                    </div>

                    <div class="mb-3" id="namaPenerimaWrapper" style="display:none;">
                        <label class="form-label">Nama Penerima</label>
                        <input type="text" class="form-control" name="nama_penerima" id="nama_penerima" value="-">
                    </div>
                </div>
            </div>

            {{-- ✅ Kolom Kanan --}}
            <div class="col-12 col-lg-6">
                <div class="form-wrapper h-100">
                    <h5 class="section-title">📷 Ambil Foto</h5>

                    <video id="video" autoplay playsinline class="w-100 mb-2"
                        style="max-height: 240px; display:none; border-radius: 12px; transform: scaleX(-1);"></video>

                    <canvas id="canvas" style="display:none;"></canvas>

                    <img id="previewFoto" class="img-thumbnail mb-2"
                        style="width: 100%; max-height: 240px; object-fit: cover; display:none; border-radius: 12px;" alt="Preview Foto">

                    <input type="hidden" name="foto" id="fotoInput" required>

                    <button type="button" id="btnAmbil" class="btn btn-success w-100 mb-3" onclick="ambilFoto()" disabled>
                        Ambil Foto
                    </button>

                    <div class="mb-3">
                        <label class="form-label">Nomor Kartu</label>
                        <input type="text" class="form-control" name="nomor_kartu" required>
                    </div>

                    <div class="d-grid mt-3">
                        <button type="button" class="btn btn-primary btn-lg" id="btnSubmit">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
{{-- Script untuk logika interaktif --}}
<script>
    function handleKeperluanChange() {
        const keperluan = document.getElementById('keperluan').value;
        const jenisTamuWrapper = document.getElementById('jenisTamuWrapper');
        const jenisTamuSelect = document.getElementById('jenis_tamu');
        const jenisTamuHidden = document.getElementById('jenis_tamu_hidden');
        const namaPenerimaWrapper = document.getElementById('namaPenerimaWrapper');
        const namaPenerimaInput = document.getElementById('nama_penerima');
        const ptWrapper = document.getElementById('ptWrapper');
        const dariPT = document.getElementById('dari_pt');
        const dariPTHidden = document.getElementById('dari_pt_hidden');

        if (keperluan === 'FAT') {
            jenisTamuWrapper.style.display = 'block';
            jenisTamuSelect.value = 'Suplier/Vendor';
            jenisTamuSelect.disabled = true;
            jenisTamuHidden.value = 'Suplier/Vendor';

            ptWrapper.style.display = 'block';
            dariPT.value = '';
            dariPTHidden.value = '';

            namaPenerimaWrapper.style.display = 'none';
            namaPenerimaInput.value = '-';
        } else if (keperluan === 'janji') {
            jenisTamuWrapper.style.display = 'block';
            jenisTamuSelect.disabled = false;
            jenisTamuHidden.value = jenisTamuSelect.value;
            updateJenisTamuEffects(jenisTamuSelect.value);
        } else {
            jenisTamuWrapper.style.display = 'none';
            jenisTamuSelect.value = '';
            jenisTamuSelect.disabled = true;
            jenisTamuHidden.value = '-';

            ptWrapper.style.display = 'none';
            dariPT.value = '-';
            dariPTHidden.value = '-';

            namaPenerimaWrapper.style.display = 'none';
            namaPenerimaInput.value = '-';
        }
    }

    function updateJenisTamuEffects(jenis) {
        const namaPenerimaWrapper = document.getElementById('namaPenerimaWrapper');
        const namaPenerimaInput = document.getElementById('nama_penerima');
        const ptWrapper = document.getElementById('ptWrapper');
        const dariPT = document.getElementById('dari_pt');
        const dariPTHidden = document.getElementById('dari_pt_hidden');

        if (jenis === 'Suplier/Vendor' || jenis === 'Tamu Tenant') {
            ptWrapper.style.display = 'block';
            dariPT.value = '';
            dariPTHidden.value = '';
        } else {
            ptWrapper.style.display = 'none';
            dariPT.value = '-';
            dariPTHidden.value = '-';
        }

        if (jenis === 'Tamu Karyawan SUA') {
            namaPenerimaWrapper.style.display = 'block';
            namaPenerimaInput.value = '';
        } else {
            namaPenerimaWrapper.style.display = 'none';
            namaPenerimaInput.value = '-';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        handleKeperluanChange();

        const jamInput = document.getElementById('jam_kunjungan');
        const now = new Date();
        const jamSekarang = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
        jamInput.value = jamSekarang;

        document.getElementById('keperluan').addEventListener('change', handleKeperluanChange);
        document.getElementById('jenis_tamu').addEventListener('change', function () {
            document.getElementById('jenis_tamu_hidden').value = this.value;
            updateJenisTamuEffects(this.value);
        });
    });
</script>

{{-- Script Kamera --}}
<script>
    let videoStream = null;
    let sudahAmbilFoto = false;

    window.addEventListener('DOMContentLoaded', () => {
        const video = document.getElementById('video');
        const preview = document.getElementById('previewFoto');
        const btnAmbil = document.getElementById('btnAmbil');

        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                videoStream = stream;
                video.srcObject = stream;
                video.style.display = 'block';
                btnAmbil.disabled = false;
                preview.style.display = 'none';
                sudahAmbilFoto = false;
            })
            .catch(error => {
                alert('Tidak bisa mengakses kamera: ' + error);
            });
    });

    function ambilFoto() {
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const preview = document.getElementById('previewFoto');
        const fotoInput = document.getElementById('fotoInput');
        const btnAmbil = document.getElementById('btnAmbil');

        if (sudahAmbilFoto) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    videoStream = stream;
                    video.srcObject = stream;
                    video.style.display = 'block';
                    btnAmbil.textContent = 'Ambil Foto';
                    preview.style.display = 'none';
                    sudahAmbilFoto = false;
                })
                .catch(error => {
                    alert('Tidak bisa mengakses kamera: ' + error);
                });
            return;
        }

        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth || 640;
        canvas.height = video.videoHeight || 480;

        context.translate(canvas.width, 0);
        context.scale(-1, 1);
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const dataURL = canvas.toDataURL('image/jpeg');
        fotoInput.value = dataURL;
        preview.src = dataURL;
        preview.style.display = 'block';

        if (videoStream) {
            videoStream.getTracks().forEach(track => track.stop());
            videoStream = null;
        }

        video.style.display = 'none';
        sudahAmbilFoto = true;
        btnAmbil.textContent = 'Ganti Foto';
    }
</script>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Konfirmasi Submit --}}
<script>
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('formTamu');
        const submitBtn = document.getElementById('btnSubmit');

        submitBtn.addEventListener('click', function (e) {
            e.preventDefault();

            swalWithBootstrapButtons.fire({
                title: "Kirim Form?",
                text: "Pastikan data sudah benar sebelum dikirim.",
                icon: "warning",
                width: '360px',
                showCancelButton: true,
                confirmButtonText: "Ya, kirim!",
                cancelButtonText: "Batal",
                reverseButtons: true,
                didRender: () => {
                    const buttons = document.querySelectorAll('.swal2-actions .btn');
                    if (buttons.length === 2) {
                        buttons[0].style.marginRight = '10px';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Dibatalkan",
                        text: "Form tidak jadi dikirim.",
                        icon: "error",
                        width: '360px',
                    });
                }
            });
        });
    });
</script>
@endsection
