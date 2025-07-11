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
            color: #000;
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

        .form-select:focus {
            border-color: #FFBD38;
            box-shadow: 0 0 0 0.2rem rgba(255, 189, 56, 0.25);
            outline: none;
        }

        .form-select option {
            color: #000;
        }

        .btn-primary {
            background-color: #FFBD38;
            border-color: #FFBD38;
            color: #fff;
            /* ubah jadi putih */
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #e6a800;
            border-color: #e6a800;
            color: #fff;
            /* tetap putih saat hover */
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
                                <select class="form-select" name="keperluan" id="keperluan" required
                                    onchange="handleKeperluanChange()">
                                    <option value="">-- Pilih Keperluan --</option>
                                    <option value="FAT" {{ old('keperluan') == 'FAT' ? 'selected' : '' }}>Tukar Faktur (FAT)
                                    </option>
                                    <option value="janji" {{ old('keperluan') == 'janji' ? 'selected' : '' }}>Janji Ketemu
                                    </option>
                                    <option value="lainnya" {{ old('keperluan') == 'lainnya' ? 'selected' : '' }}>Keperluan
                                        Lainnya</option>
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
                                    <option value="Tamu Karyawan">Tamu Karyawan</option>
                                </select>
                                <input type="hidden" name="jenis_tamu" id="jenis_tamu_hidden">
                            </div>


                            {{-- <div class="mb-3">
                                <label class="form-label">Nama Penerima Tamu</label>
                                <input type="text" class="form-control" name="nama_penerima"
                                    value="{{ old('nama_penerima') }}" required>
                            </div> --}}

                            <div class="mb-3">
                                <label class="form-label">Nama Tamu</label>
                                <input type="text" class="form-control" name="nama_tamu" value="{{ old('nama_tamu') }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" name="telepon" placeholder="08xxxxxxxxxx"
                                    value="{{ old('telepon') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Kunjungan</label>
                                <input type="date" class="form-control" name="tanggal_kunjungan" value="{{ date('Y-m-d') }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ambil Foto dari Kamera</label><br>

                                <video id="video" autoplay playsinline class="border rounded w-100 mb-2"
                                    style="max-height: 300px; display: none; transform: scaleX(-1);"></video>


                                <!-- Canvas untuk menangkap gambar (tidak ditampilkan) -->
                                <canvas id="canvas" style="display:none;"></canvas>

                                <!-- Preview gambar langsung tampil di posisi kamera -->
                                <img id="previewFoto" class="img-thumbnail mb-2" style="max-width: 100%; display: none;"
                                    alt="Preview Foto">

                                <!-- Hidden input untuk dikirim ke backend -->
                                <input type="hidden" name="foto" id="fotoInput" required>

                                <div class="d-flex gap-2 flex-wrap">
                                    <button type="button" id="btnKamera" class="btn btn-secondary"
                                        onclick="toggleKamera()">Aktifkan Kamera</button>
                                    <button type="button" id="btnAmbil" class="btn btn-success" onclick="ambilFoto()"
                                        disabled>Ambil Foto</button>
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

    {{-- Script untuk handle jenis tamu --}}
    <script>
        function handleKeperluanChange() {
            const keperluan = document.getElementById('keperluan').value;
            const jenisTamuWrapper = document.getElementById('jenisTamuWrapper');
            const jenisTamuSelect = document.getElementById('jenis_tamu');
            const jenisTamuHidden = document.getElementById('jenis_tamu_hidden');

            if (keperluan === 'janji') {
                jenisTamuWrapper.style.display = 'block';
                jenisTamuSelect.style.display = 'block';
                jenisTamuHidden.value = jenisTamuSelect.value;
            } else {
                jenisTamuWrapper.style.display = 'none';
                jenisTamuSelect.value = '';
                jenisTamuHidden.value = '-';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            handleKeperluanChange();

            document.getElementById('keperluan').addEventListener('change', handleKeperluanChange);
            document.getElementById('jenis_tamu').addEventListener('change', function () {
                document.getElementById('jenis_tamu_hidden').value = this.value;
            });
        });
    </script>

    {{-- Script kamera --}}
    <script>
        let videoStream = null;
        let kameraAktif = false;
        let sudahAmbilFoto = false;

        function toggleKamera() {
            const video = document.getElementById('video');
            const preview = document.getElementById('previewFoto');
            const btnKamera = document.getElementById('btnKamera');
            const btnAmbil = document.getElementById('btnAmbil');

            if (!kameraAktif) {
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(stream => {
                        videoStream = stream;
                        video.srcObject = stream;
                        video.style.display = 'block';
                        kameraAktif = true;

                        btnKamera.textContent = 'Nonaktifkan Kamera';
                        btnKamera.classList.replace('btn-secondary', 'btn-danger');
                        btnKamera.disabled = false;

                        btnAmbil.disabled = false;
                        btnAmbil.textContent = 'Ambil Foto';

                        preview.style.display = 'none';
                        sudahAmbilFoto = false;
                    })
                    .catch(error => {
                        alert('Tidak bisa mengakses kamera: ' + error);
                    });
            } else {
                // Matikan kamera
                if (videoStream) {
                    videoStream.getTracks().forEach(track => track.stop());
                    videoStream = null;
                }
                video.style.display = 'none';
                kameraAktif = false;

                btnKamera.textContent = 'Aktifkan Kamera';
                btnKamera.classList.replace('btn-danger', 'btn-secondary');
                btnKamera.disabled = false;

                btnAmbil.disabled = true;
            }
        }

        function ambilFoto() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const preview = document.getElementById('previewFoto');
            const fotoInput = document.getElementById('fotoInput');
            const btnAmbil = document.getElementById('btnAmbil');
            const btnKamera = document.getElementById('btnKamera');

            // Jika sudah ambil foto, klik selanjutnya akan menyalakan kamera ulang
            if (sudahAmbilFoto) {
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(stream => {
                        videoStream = stream;
                        video.srcObject = stream;
                        video.style.display = 'block';
                        kameraAktif = true;

                        btnKamera.textContent = 'Nonaktifkan Kamera';
                        btnKamera.classList.replace('btn-secondary', 'btn-danger');
                        btnKamera.disabled = false;

                        btnAmbil.disabled = false;
                        btnAmbil.textContent = 'Ambil Foto';

                        preview.style.display = 'none';
                        sudahAmbilFoto = false;
                    })
                    .catch(error => {
                        alert('Tidak bisa mengakses kamera: ' + error);
                    });
                return;
            }

            // Ambil gambar dari video
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

            // Matikan kamera
            if (videoStream) {
                videoStream.getTracks().forEach(track => track.stop());
                videoStream = null;
            }
            video.style.display = 'none';
            kameraAktif = false;
            sudahAmbilFoto = true;

            btnAmbil.textContent = 'Ganti Foto';
            btnKamera.textContent = 'Aktifkan Kamera';
            btnKamera.classList.replace('btn-danger', 'btn-secondary');
            btnKamera.disabled = true; // Saat sudah ada preview
        }
    </script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Submit Form dengan Konfirmasi --}}
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