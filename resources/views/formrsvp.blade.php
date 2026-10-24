<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Form RSVP</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('sbadmin') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sbadmin') }}/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <!-- 1. GAMBAR KHUSUS MOBILE (Hanya muncul di HP/Tablet kecil, sembunyi di Laptop) -->
                    <div class="col-12 d-block d-lg-none p-0 bg-gray-900 text-center">
                        <img src="{{ asset('gambar_banner/'.$data_undangan->gambar1) }}" 
                            class="w-100" style="max-height: 220px; object-fit: cover;" 
                            alt="Banner Mobile">
                    </div>

                    <!-- 2. GAMBAR KHUSUS DESKTOP (Sembunyi di HP, muncul di Laptop/Desktop) -->
                    <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center bg-gray-900 p-0">
                        <img src="{{ asset('gambar_banner/'.$data_undangan->gambar2) }}" 
                            class="w-100 h-100" style="object-fit: cover;" 
                            alt="Banner Desktop">
                    </div>
                    
                    <!-- Kolom Form -->
                    <div class="col-lg-6">
                        <div class="p-3 p-lg-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-1">Form RSVP Media Liputan Acara</h1>
                                <p class="text-gray-900 mb-2">
                                    @if ($data_undangan->jenis == "PC") <span class="badge badge-info text-light">Press Conference</span>
                                    @else <span class="badge badge-success text-light">Konser</span>
                                    @endif
                                </p>
                            </div>
                            <form class="user" action="{{ route('liputan.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <input type="email" class="form-control" placeholder="Email Address" aria-label="email" aria-describedby="button-addon2" name="email" value="{{ $email }}" readonly>
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            placeholder="Nama" value="{{ $cek_email?->nama ?? $input_data_null ?? '' }}">
                                    </div>
                                    <div class="col-sm-6">
                                        @php
                                            $rawPhone = $cek_email?->phone ?? $input_data_null ?? '';
                                            $maskedPhone = '';

                                            if(!empty($rawPhone)){
                                                $len = strlen($rawPhone);
                                                if($len > 6){
                                                    $maskedPhone = substr($rawPhone, 0, 4) . '****' . substr($rawPhone, -3);
                                                }else{
                                                    $maskedPhone = '****';
                                                }
                                            }
                                        @endphp
                                        <input type="text" class="form-control" id="phone_masked" placeholder="Phone" value="{{ $maskedPhone }}" data-original="{{ $rawPhone }}">
                                        <input type="hidden" id="phone_real" name="phone" value="{{ $rawPhone }}">
                                        <input type="hidden" name="jenis_undangan" value="{{ $data_undangan->jenis }}">
                                        <input type="hidden" name="kode_undangan" value="{{ $data_undangan->id_undangan }}">
                                        <input type="hidden" name="judul" value="{{ $data_undangan->judul }}">
                                        <input type="hidden" name="kode_liputan" value="{{ $cek_email?->id_liputan ?? '' }}">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3">
                                        <input type="text" class="form-control"
                                            id="media" placeholder="Nama Media" name="media" value="{{ $cek_email?->media ?? $cek_email ?? '' }}">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-3">
                                        <select class="custom-select form-control" placeholder="Jabatan" id="jabatan" name="jabatan">
                                        <option value="" selected disabled hidden>Jabatan...</option>
                                        <option value="JR" {{ ($cek_email?->jabatan == 'JR') ? 'selected' : ''; }}>Jurnalis / Reporter</option>
                                        <option value="PGVG" {{ ($cek_email?->jabatan == 'PGVG') ? 'selected' : ''; }}>Photographer / Videographer</option>
                                        <option value="JRPG" {{ ($cek_email?->jabatan == 'JRPG') ? 'selected' : ''; }}>Jurnalis & Photographer / Videographer</option>
                                        </select>
                                    </div>

                                    @if ($data_undangan->jenis == "Konser")
                                    <div class="col-sm-12">
                                        <div id="wrapper-input-c">
                                            @if(old('input_berita'))
                                                @foreach(old('input_berita') as $index => $oldC)
                                                    <div class="input-group mb-2 item-berita">
                                                        <input type="text" class="form-control" name="input_berita[]" value="{{ $oldC }}" placeholder="Masukkan link berita" required>
                                                        <button type="button" class="btn btn-danger remove-berita" {{ $index == 0 && count(old('input_berita')) == 1 ? 'disabled' : '' }}>Hapus</button>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="input-group mb-2 item-berita">
                                                    <input type="text" class="form-control" name="input_berita[]" placeholder="Masukkan link berita" required>
                                                    <button type="button" class="btn btn-danger remove-berita" disabled>Hapus</button>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" id="tambahBerita" class="btn btn-secondary btn-sm mb-3">+ Tambah Link</button>
                                    </div>
                                    @else
                                    <div class="col-sm-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Alamat Website / Akun Social Media" aria-label="email" aria-describedby="button-addon2" name="alamatweb" value="{{ $cek_email?->link2 ?? $cek_email ?? '' }}">
                                        </div>
                                    </div>
                                    @endif

                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Submit
                                </button>
                                <hr>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // 1. Tambah baris Input C secara dinamis
            $('#tambahBerita').click(function() {
                let html = `
                    <div class="input-group mb-2 item-berita">
                        <input type="text" class="form-control" name="input_berita[]" placeholder="Masukkan link berita" required>
                        <button type="button" class="btn btn-danger remove-berita">Hapus</button>
                    </div>
                `;
                $('#wrapper-input-c').append(html);
                updateRemoveButtons();
            });

            // 2. Hapus baris Input C
            $(document).on('click', '.remove-berita', function() {
                $(this).closest('.item-berita').remove();
                updateRemoveButtons();
            });

            // Pastikan tombol hapus mati jika baris C hanya tinggal 1
            function updateRemoveButtons() {
                let totalItem = $('.item-berita').length;
                if (totalItem === 1) {
                    $('.item-berita .remove-berita').prop('disabled', true);
                } else {
                    $('.item-berita .remove-berita').prop('disabled', false);
                }
            }
        });
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sbadmin') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('sbadmin') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sbadmin') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sbadmin') }}/js/sb-admin-2.min.js"></script>

    <script>
    // PERBAIKAN: Ubah getElementaryById menjadi getElementById
    document.getElementById('phone_masked').addEventListener('input', function(){
        let maskedInput = this.value;
        let realInput = document.getElementById('phone_real');

        realInput.value = maskedInput;
    });
</script>

</body>

</html>