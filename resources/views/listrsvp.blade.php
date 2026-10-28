<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>List RSVP {{ Str::upper(Str::replace('-',' ', $data_undangan->judul)) }}</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('sbadmin') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sbadmin') }}/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="{{ asset('sbadmin') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6">
                        <img src={{ asset('gambar_banner/'.$data_undangan->gambar1) }} width="100%" alt="...">
                    </div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h3 text-gray-900">List RSVP Media Liputan Acara</h1>
                                <p class="text-gray-900 mb-4">
                                    @if ($data_undangan->jenis == "PC") <span class="badge badge-info text-light">Press Conference</span>
                                    @else <span class="badge badge-success text-light">Konser</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <button class="btn btn-sm btn-primary text-light"><h6 class="m-0 font-weight-bold">Total RSVP : {{ $total_rsvp }}</h6></button>
                            <button class="btn btn-sm btn-warning text-dark"><h6 class="m-0 font-weight-bold">Total Hadir : {{ $total_hadir }}</h6></button>
                            <button class="btn btn-sm btn-info text-light"><h6 class="m-0 font-weight-bold">Total Photographer : {{ $total_photographer }}</h6></button>
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th width="5%">#</th>
                                            <th width="10%">Media</th>
                                            <th width="10%">Nama</th>
                                            <th width="20%">Email</th>
                                            <th width="10%">Jabatan</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ( $data_liputan as $listdata)
                                        @php
                                            $bg_color = 'transparent'; // Default tidak berwarna
                                            // Syarta 1 : Hanya warnai jika peserta sudah hadir (jumlah id terisi atai lebih dari 0)
                                            if(!empty($listdata->jumlah_id) && $listdata->jumlah_id > 0){
                                                $bg_color = match($listdata->jenis_media) {
                                                    'MP' => '#78A083; color: white', // Biru muda (setara bg-blue-200)
                                                    'NP' => '#50727B; color: white', // Hijau muda (setara bg-green-200)
                                                    'SP' => '#344955; color: white', // Orange muda (setara bg-orange-200)
                                                    'CL' => '#35374B; color: white', // Amber/Kuning muda (setara bg-amber-200)
                                                    default => 'transparent',
                                                };
                                            }
                                        @endphp
                                        <tr style="background-color: {{ $bg_color }} !important;">
                                            <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                            <td class="align-middle text-center">{{ $listdata->media }}</td>
                                            <td class="align-middle text-center"><span class="btn btn-sm bg-gradient-success text-white font-weight-bold" data-toggle="modal" data-target="#edit{{ $listdata->id_liputan }}" title="Edit" style="width: 100px; display: inline-block; text-align: center;">{{ Str::of($listdata->nama)->explode(' ')->first() }}</span></td>
                                            <td class="align-middle text-center">{{ $listdata->email }}</td>
                                            <td class="align-middle text-center">
                                                @if ($listdata->jabatan == 'JR') Jurnalis/Reporter
                                                @elseif($listdata->jabatan == 'PGVG') Photo/Videographer
                                                @elseif($listdata->jabatan == 'JRPG') Jurnalis & Photographer
                                                @endif
                                            </td>
                                            <td class="align-middle text-center text-nowrap">
                                                <button type="button" class="btn btn-sm bg-gradient-danger text-white" data-toggle="modal" data-target="#hapus{{ $listdata->id_liputan }}" title="Delete">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm bg-gradient-info text-white" 
    onclick="printStiker('{{ $listdata->id_liputan }}', '{{ $listdata->nama }}', '{{ $listdata->media }}', '{{ $listdata->phone }}', '{{ $listdata->jabatan }}', '{{ $data_undangan->judul }}')" 
    title="Print">
    <i class="fa fa-print" aria-hidden="true"></i>
</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>

    </div>

    @foreach ($data_liputan as $listmodal )
        <!-- Modal -->
    <div class="modal fade" id="edit{{ $listmodal->id_liputan }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-uppercase" id="exampleModalLabel">{{ $listmodal->media }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('liputan.update',$listmodal->id_liputan) }}" method="POST">
                    @method('PUT')
                    @csrf
                     <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ $listmodal->email }}">
                        <input type="hidden" name="undanganid" value="{{ $listmodal->undangan_id }}">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Alamat Web / Social Media</label>
                        <input type="text" name="alamatweb" class="form-control" id="alamatweb" value="{{ $listmodal->link2 }}">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputName">Nama</label>
                            <input type="text" name="nama" class="form-control" id="nama" value="{{ $listmodal->nama }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control" id="phone" value="{{ $listmodal->phone }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPhone">Jenis Liputan</label>
                            <select class="custom-select" id="status" name="jenis_undangan">
                                    <option selected>Choose...</option>
                                    <option value="PC" {{ $data_undangan->jenis == 'PC' ? 'selected' : '' }}>Press Conference</option>
                                    <option value="Konser" {{ $data_undangan->jenis == 'Konser' ? 'selected' : '' }}>Konser</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputName">Jabatan</label>
                            <select class="custom-select" id="status" name="jabatan">
                                    <option selected>Choose...</option>
                                    <option value="JR" {{ $listmodal->jabatan == 'JR' ? 'selected' : '' }}>Jurnalis/Reporter</option>
                                    <option value="PGVG" {{ $listmodal->jabatan == 'PGVG' ? 'selected' : '' }}>Photographer/Videographer</option>
                                    <option value="JRPG" {{ $listmodal->jabatan == 'JRPG' ? 'selected' : '' }}>Jurnalis & Photographer</option>
                            </select>
                        </div>
                    </div>
                     <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPhone">Jumlah ID</label>
                             <input type="number" name="jumlahid" class="form-control" id="jumlahid" value="{{ $listmodal->jumlah_id }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputName">Jenis Media</label>
                            <select class="custom-select" id="status" name="jenis_media">
                                    <option selected>Choose...</option>
                                     <option value="MP" {{ $listmodal->jenis_media == 'MP' ? 'selected' : '' }}>Media Partner</option>
                                     <option value="NP" {{ $listmodal->jenis_media == 'NP' ? 'selected' : '' }}>Non Partner</option>
                                     <option value="SP" {{ $listmodal->jenis_media == 'SP' ? 'selected' : '' }}>Sponsor</option>
                                     <option value="CL" {{ $listmodal->jenis_media == 'CL' ? 'selected' : '' }}>Client</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Link Berita</label>
                        
                           @php
                                // Cek apakah $listdata->link1 sudah berupa array atau belum
                                if (is_array($listmodal->link1)) {
                                    $links = $listmodal->link1;
                                } else {
                                    // Jika masih string, lakukan decode/explode seperti biasa
                                    $cleanJson = stripslashes($listmodal->link1 ?? '');
                                    $links = json_decode($cleanJson, true);

                                    if (!is_array($links)) {
                                        $links = !empty($listmodal->link1) ? explode(',', $listmodal->link1) : [];
                                    }
                                }
                            @endphp

                            <div class="mb-3">
                                <ul class="list-inline mb-0">
                                    @forelse($links as $link)
                                        @php
                                           $trimmedLink = trim($link);
                                            // Mengambil nama domain utama untuk ditampilkan (misal: detik.com dari https://news.detik.com/...)
                                            $parsedUrl = parse_url($trimmedLink, PHP_URL_HOST);
                                            $domainName = $parsedUrl ? $parsedUrl : 'Website Luar';
                                        @endphp
                                        <li class="list-inline-item mr-2 mb-1">
                                           <a href="{{ $trimmedLink }}" 
                                                target="_blank" 
                                                class="btn btn-sm btn-outline-primary py-0 px-2"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="[ {{ $domainName }} ] - Klik untuk membuka tautan: {{ $trimmedLink }}">
                                                <i class="fas fa-link"></i> Berita-{{ $loop->iteration }}
                                            </a>
                                        </li>
                                    @empty
                                        <li class="text-muted font-italic" style="font-size: 13px;">Belum ada link berita.</li>
                                    @endforelse
                                </ul>
                            </div>
                        
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-warning">Print</button>
            </div>
            </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal Hapus Liputan-->
    @foreach ($data_liputan as $liputan)
    <div class="modal fade" id="hapus{{ $liputan->id_liputan }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('liputan.destroy',$liputan->id_liputan) }}" method="POST" class="modal-content">
            @csrf
            @method('DELETE')
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            Apakah anda yakin mau hapus data [<b>{{ $liputan->nama }}-{{ $liputan->media }}</b>] dari List RSVP <u>{{ Str::upper(Str::replace('-',' ', $data_undangan->judul)) }}</u>?
            <input type="hidden" name="judul" value="{{ $data_undangan->judul }}">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Ya Hapus!</button>
        </div>
        </form>
    </div>
    </div>
    @endforeach
   
    <!-- Script JavaScript untuk mengambil data email dari tabel -->
    <script>
        document.getElementById('btnCopyEmail').addEventListener('click', function() {
            let emails = [];
            
            // Sesuaikan selector '#myTable tr' dan indeks kolom email (misal kolom ke-2 / index 1)
            $('#dataTable tr').each(function(index, row) {
                // Lewati baris header (jika ada)
                if (index === 0) return; 
                
                // Ambil teks dari kolom tempat email berada (misal kolom ke-2, berarti index 1)
                let emailText = $(row).find('td').eq(3).text().trim(); 
                if (emailText && emailText.includes('@')) {
                    emails.push(emailText);
                }
            });

            if (emails.length === 0) {
                alert('Tidak ada email yang ditemukan!');
                return;
            }

            // Gabungkan email dengan koma atau spasi
            let emailString = emails.join(', ');

            // Salin ke clipboard
            navigator.clipboard.writeText(emailString).then(function() {
                alert('Berhasil! ' + emails.length + ' email berhasil disalin. Silakan paste di Gmail.');
            }, function(err) {
                alert('Gagal menyalin email: ' + err);
            });
        });
    </script>
    <script>
    $(document).ready(function(){
        // Mengaktifkan tooltips bawaan Bootstrap
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sbadmin') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('sbadmin') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sbadmin') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sbadmin') }}/js/sb-admin-2.min.js"></script>

    <script src="{{ asset('sbadmin') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('sbadmin') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('sbadmin') }}/js/demo/datatables-demo.js"></script>

    <!-- Area Stiker Tersembunyi yang Akan Dicetak -->
<!-- Area Stiker Tersembunyi -->
<div id="print-area" style="display: none;">
    <div class="stiker-container">
        <div class="stiker-event"><span id="p-event"></span></div>
        <div class="stiker-id"><span id="p-id"></span></div>
        <div class="stiker-nama"><span id="p-nama"></span></div>
        <hr class="stiker-line">
        <div class="stiker-media"><span id="p-media"></span></div>
        <div class="stiker-info">[<span id="p-phone"></span>]</div>
        <div class="stiker-info"><span id="p-jabatan"></span></div>
    </div>
</div>

<!-- CSS Khusus Stiker 5x4 cm -->
<style>
@media print {
    body > *:not(#print-area) {
        display: none !important;
    }
    
    #print-area {
        display: block !important;
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        width: 4cm !important;
        height: 5cm !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .stiker-container {
        width: 4cm !important;
        height: 5cm !important;
        padding: 3mm 2mm !important;
        box-sizing: border-box !important;
        font-family: Arial, sans-serif !important;
        text-align: center !important;
        overflow: hidden !important;
    }

    .stiker-event { 
        font-size: 10px !important; 
        font-weight: bold !important; 
        margin-bottom: 3px !important; 
        text-transform: uppercase;
    }
    .stiker-line { 
        margin: 2px 0 3px 0 !important; 
        border-top: 1.5px solid #000 !important; 
    }
    .stiker-id { 
        font-size: 11px !important; 
        font-weight: bold !important; 
        margin-bottom: 3px !important; 
    }
    .stiker-nama { 
        font-size: 12px !important; 
        font-weight: bold !important; 
        margin-bottom: 3px !important; 
    }
    .stiker-media { 
        font-size: 11px !important; 
        font-weight: bold !important; 
        margin-bottom: 3px !important; 
    }
    .stiker-info { 
        font-size: 12px !important; 
        margin-bottom: 2px !important; 
    }
}

/* Membalik ukuran halaman menjadi 4cm x 5cm agar posisinya berdiri tegak (Portrait) */
@page {
    size: 4cm 5cm;
    margin: 0;
}
</style>

<!-- JavaScript untuk Menjalankan Print -->
<script>
function printStiker(id, nama, media, phone, jabatan, judul) {
    document.getElementById('p-nama').innerText = nama;
    document.getElementById('p-media').innerText = media;
    document.getElementById('p-phone').innerText = phone;
    
    let jabatanText = jabatan;
    if(jabatan === 'JR') jabatanText = 'Jurnalis/Reporter';
    else if(jabatan === 'PGVG') jabatanText = 'Photo/Videographer';
    else if(jabatan === 'JRPG') jabatanText = 'Jurnalis & Photographer';
    document.getElementById('p-jabatan').innerText = jabatanText;

    window.print();
}
</script>

</body>

</html>