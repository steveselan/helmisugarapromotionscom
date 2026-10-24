<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Form RSVP {{ Str::upper(Str::replace('-',' ', $form_rsvp->judul)) }}</title>

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
                    <div class="col-lg-6 d-flex justify-content-center align-items-center">
                        <img src={{ asset('gambar_banner/'.$form_rsvp->gambar2) }} width="100%" alt="...">
                    </div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Form RSVP Media Liputan Acara</h1>
                                <p class="text-gray-900 mb-4">
                                    @if ($form_rsvp->jenis == "PC") <span class="badge badge-success text-light">Press Conference</span>
                                    @else <span class="badge badge-success text-light">Konser</span>
                                    @endif
                                </p>
                            </div>
                            @php
                                // hitung langsung di blade atau kirim dari contoller
                                $totalPendaftar = \App\Models\Liputan::where('undangan_id', $form_rsvp->id_undangan)->count();
                                $kapasitasMaks = $form_rsvp->kapasitas;
                                $isFull = $totalPendaftar >= $kapasitasMaks;
                            @endphp
                            @if($isFull)
                                <div class="alert alert-danger text-center">
                                    <strong>Mohon maaf!</strong> Kuota pendaftaran event ini sudah penuh.
                                </div>
                            @endif
                            <form class="user" action="/liputan/checkemail" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group mb-3" style="{{ $isFull ? 'display:none' : '' }}">
                                         <input type="hidden" name="kode_undangan" value="{{ $form_rsvp->id_undangan }}">
                                         <input type="hidden" name="jenis_undangan" value="{{ $form_rsvp->jenis_undangan }}">
                                         <input type="email" class="form-control" placeholder="Email Address" aria-label="email" aria-describedby="button-addon2" name="email">
                                         <div class="input-group-append">
                                            <button class="btn btn-secondary" type="submit" id="button-addon2">Check Mail</button>
                                        </div>
                                       
                                    </div>
                                </div>
                              
                                {{-- <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Submit
                                </button>
                                <hr> --}}
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sbadmin') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('sbadmin') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sbadmin') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sbadmin') }}/js/sb-admin-2.min.js"></script>

</body>

</html>