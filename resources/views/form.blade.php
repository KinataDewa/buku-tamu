@extends('layouts.app')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .card {
            border: 1px solid #FFBD38;
        }

        h4.card-title {
            color: #000;
            font-weight: 600;
        }

        label.form-label {
            font-weight: 500;
            color: #000;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #FFBD38;
            box-shadow: 0 0 0 0.2rem rgba(255, 189, 56, 0.25);
        }

        .btn-primary {
            background-color: #FFBD38;
            border-color: #FFBD38;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #e6a800;
            border-color: #e6a800;
            color: #fff;
        }

        .btn-success {
            background-color: #000;
            border-color: #000;
            font-weight: 500;
        }

        .btn-success:hover {
            background-color: #333;
            border-color: #333;
        }

        .btn-outline-secondary {
            border-color: #000;
            color: #000;
        }

        .btn-outline-secondary:hover {
            background-color: #000;
            color: #fff;
        }

        .alert-success,
        .alert-danger {
            border-left: 5px solid #FFBD38;
        }

        .form-select {
            background-color: #fff;
            color: #000;
            border: 1px solid #FFBD38;
            font-weight: 500;
        }

        .form-select option {
            color: #000;
        }

        select.form-select {
            font-size: 16px;
            padding: 0.6rem 1rem;
        }
    </style>
@endpush

@section('content')
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h4 class="card-title mb-4 text-center">Form Buku Tamu</h4>

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

                                <div class="mb-3">
                                    <label class="form-label">Pilih Keperluan</label>
                                    <select class="form-select" name="keperluan" id="keperluan" required onchange="handleKeperluanChange()">
                                        <option value="">-- Pilih Keperluan --</option>
                                        <option value="FAT" {{ old('keperluan') == 'FAT' ? 'selected' : '' }}>Tukar Faktur (FAT)
                                        </option>
                                        <option value="janji" {{ old('keperluan') == 'janji' ? 'selected' : '' }}>Janji Ketemu
                                        </option>
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

                                            <!-- Asal Perusahaan -->
                                            <div class="mb-3" id="ptWrapper" style="display: none;">
                                                <label class="form-label">Asal Perusahaan</label>
                                                <input type="text" class="form-control" name="dari_pt" id="dari_pt">
                                                <input type="hidden" name="dari_pt_hidden" id="dari_pt_hidden" value="-">
                                            </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Tamu</label>
                                    <input type="text" class="form-control" name="nama_tamu" value="{{ old('nama_tamu') }}" required>
                                    </div>

                                <div class="mb-3">
                                    <label class="form-label">Nomor Telepon</label>
                                    <input type="tel" class="form-control" name="telepon" placeholder="08xxxxxxxxxx" value="{{ old('telepon') }}" required>
                                    </div>

                                <div class="mb-3" id="namaPenerimaWrapper" style="display: none;">
                                    <label class="form-label">Nama Penerima</label>
                                    <input type="text" class="form-control" name="nama_penerima" id="nama_penerima"
                                        value="{{ old('nama_penerima', '-') }}">
                                </div>

                                <input type="hidden" name="tanggal_kunjungan" value="{{ date('Y-m-d') }}" required>

                                <input type="hidden" name="jam_kunjungan" id="jam_kunjungan" required>

                                <div class="mb-3">
                                    <label class="form-label">Nomor Kartu</label>
                                    <input type="text" class="form-control" name="nomor_kartu" value="{{ old('nomor_kartu') }}" required>
                                    </div>

                                <div class="mb-3">
                                    <label class="form-label">Ambil Foto dari Kamera</label><br>
                                    <video id="video" autoplay playsinline class="border rounded w-100 mb-2"
                                        style="max-height: 300px; display: none; transform: scaleX(-1);"></video>
                                    <canvas id="canvas" style="display:none;"></canvas>
                                    <img id="previewFoto" class="img-thumbnail mb-2" style="max-width: 100%; display: none;" alt="Preview Foto">
                                    <input type="hidden" name="foto" id="fotoInput" required>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <button type="button" id="btnAmbil" class="btn btn-success" onclick="ambilFoto()" disabled>Ambil Foto</button>
                                        </div>
                                        </div>

                                <div class="d-grid mt-4">
                                    <button type="button" class="btn btn-primary btn-lg" id="btnSubmit">Kirim</button>
                                </div>
                                </form>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>

        {{-- Script handle jenis tamu --}}
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

            // Tampilkan PT jika jenis tamu Suplier/Vendor atau Tamu Tenant
            if (jenis === 'Suplier/Vendor' || jenis === 'Tamu Tenant') {
                ptWrapper.style.display = 'block';
                dariPT.value = '';
                dariPTHidden.value = '';
            } else {
                ptWrapper.style.display = 'none';
                dariPT.value = '-';
                dariPTHidden.value = '-';
            }

            // Nama penerima hanya untuk Tamu Karyawan SUA
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

            // Auto jam kunjungan
            const jamInput = document.getElementById('jam_kunjungan');
            const now = new Date();
            const jamSekarang = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
            jamInput.value = jamSekarang;

            document.getElementById('keperluan').addEventListener('change', handleKeperluanChange);

            document.getElementById('jenis_tamu').addEventListener('change', function () {
                const jenis = this.value;
                document.getElementById('jenis_tamu_hidden').value = jenis;
                updateJenisTamuEffects(jenis);
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
