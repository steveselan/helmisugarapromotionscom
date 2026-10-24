@extends('layout.master')
@section('title','New Event')
@section('konten')
    <a href="/newevent/create" type="button" class="btn btn-primary mb-3">Tambah Event</a>
    @if (session('pesan'))
        {{-- <div class="alert alert-primary">{{ session('pesan') }}</div> --}}
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('pesan') }}</strong> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between align-item-center">
            Daftar Event Baru
        </div>
        <div class="card-body">
           <div class="table-responsive">
                 <table class="table table-sm table-striped table-bordered" id="dataTable">
                    <thead>
                        <tr class="text-center">
                        <th scope="col" class="align-middle" width="5%">No.</th>
                        <th scope="col" width="30%">Judul Event</th>
                        <th scope="col" width="20%">Artis</th>
                        <th scope="col" width="20%">Lokasi</th>
                        <th scope="col" width="10%" class="align-middle">Tanggal</th>
                        <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data_event as $dataEvent)
                            @php
                                $bg_color = 'transparent'; // Default tidak berwarna
                                    $badgeColor = match($dataEvent->nama_kategori) {
                                        'Music Concert' => '#C147E9; color: white', // Biru muda (setara bg-blue-200)
                                        'Music Festival' => '#50727B; color: white', // Hijau muda (setara bg-green-200)
                                        'Music & Exhibition' => '#344955; color: white', // Orange muda (setara bg-orange-200)
                                        'Lifestyle Exhibition' => '#610C9F; color: white', // Amber/Kuning muda (setara bg-amber-200)
                                        'Sport Event' => '#E3651D; color: white', // Amber/Kuning muda (setara bg-amber-200)
                                        'Traditional & Culture Event' => '#720455; color: white', // Amber/Kuning muda (setara bg-amber-200)
                                        'Family Entertainment' => '#7077A1; color: white', // Amber/Kuning muda (setara bg-amber-200)
                                        default => 'transparent',
                                    };
                             @endphp
                            <tr class="text-center">
                                <th scope="row" class="align-middle text-center">{{ $loop->iteration }}</th>
                                <td class="align-middle">
                                    <span class="badge text-white px-2 py-1 mb-1" style="background-color: {{ $badgeColor }}; font-size: 11px;">{{ $dataEvent->nama_kategori }}</span><br>{{ Str::title($dataEvent->judul_event) }}</td>
                                <td class="align-middle">{{ Str::title($dataEvent->artis) }}</td>
                                <td class="align-middle">{{ Str::title($dataEvent->lokasi) }}</td>
                                <td class="align-middle">{{ \Carbon\Carbon::parse($dataEvent->tanggal)->format('j M Y') }}</td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapus{{ $dataEvent->id_event }}"><i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                    
                                    <!-- Tombol Edit di dalam Looping DataTables -->
                                    <button type="button" class="btn btn-warning btn-sm btn-edit" data-toggle="modal" data-target="#editdata{{ $dataEvent->id_event }}" data-id="{{ $dataEvent->id_event  }}">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                    </button>
                                    <a href="/newevent/{{ $dataEvent->id_event }}" class="btn btn-sm btn-info"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">data produk tidak di temukan</td></tr>
                        @endforelse 
                    </tbody>
                </table>
           </div>
        </div>
    </div>

<!-- Modal -->
    @foreach ($data_event as $data)
    <div class="modal fade" id="hapus{{ $data->id_event }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/newevent/{{ $data->id_event }}" method="POST" class="modal-content">
            @csrf
            @method('DELETE')
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            Apakah anda yakin mau dihapus {{ $data->judul_event }}?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Ya Hapus!</button>
        </div>
        </form>
    </div>
    </div>
    @endforeach

<!-- ================= MODAL EDIT EVENT ================= -->
 @foreach ($data_event as $editevent)
<div class="modal fade" id="editdata{{ $editevent->id_event }}" tabindex="-1" aria-labelledby="editdataLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark-100 border border-slate-800">
            <div class="modal-header border-slate-800">
                <h5 class="modal-title font-bold" id="editdataLabel">Edit Data Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Form Edit (Action akan diisi dinamis via JavaScript) -->
            <form id="formUpdate{{ $editevent->id_event }}" action="{{ route('newevent.update', $editevent->id_event) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row p-4">
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="judul_event" class="form-label">Judul Event</label>
                            <input type="text" class="form-control" id="judul_event" name="judul_event" aria-describedby="judul_event" value="{{ $editevent->judul_event }}">
                            @error('judul_event')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="artis" class="form-label">Artis</label>
                            <input type="text" class="form-control" id="artis" name="artis" aria-describedby="artis" value="{{ $editevent->artis }}">
                             @error('artis')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" aria-describedby="lokasi" value="{{ $editevent->lokasi }}">
                             @error('lokasi')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" aria-describedby="tanggal" value="{{ $editevent->tanggal }}">
                             @error('tanggal')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="link_tiket" class="form-label">Link Tiket</label>
                            <input type="text" class="form-control" id="link_tiket" name="link_tiket" aria-describedby="link_tiket" value="{{ $editevent->link_tiket }}">
                             @error('link_tiket')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="promotor" class="form-label">Promotor</label>
                            <input type="text" class="form-control" id="promotor" name="promotor" aria-describedby="promotor" value="{{ $editevent->promotor }}">
                             @error('promotor')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="custom-select" id="status" name="status">
                                <option selected>Choose...</option>
                                <option value="New" {{ ($editevent->status == 'New') ? 'selected' : ''; }}>New</option>
                                <option value="Past" {{ ($editevent->status == 'Past') ? 'selected' : ''; }}>Past</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Kategori Event</label>
                            <select class="custom-select" id="kategori" name="kategori">
                                <option selected>Choose...</option>
                                @foreach ( $listkategori as $listkat )
                                    <option value="{{ $listkat->id_kategori }}" {{ ($listkat->id_kategori == $editevent->kategori_id) ? 'selected' : ''; }}>{{ $listkat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="gambar1" class="form-label">Gambar Wide</label>
                            <input type="file" class="form-control" id="gambar1" name="gambar1" aria-describedby="gambar1" value="{{ $editevent->gambar1 }}">
                             @error('gambar1')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @if($editevent->gambar1 == null)
                            <p>Belum ada gambar</p>
                        @else
                            <img src="{{ asset('gambar_banner/'.$editevent->gambar1) }}" class="img-fluid mx-auto d-block mb-3 " height="10%" alt="...">
                        @endif
                        
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="gambar2" class="form-label">Gambar Square</label>
                            <input type="file" class="form-control" id="gambar2" name="gambar2" aria-describedby="gambar2" value="{{ $editevent->gambar2 }}">
                             @error('gambar2')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @if($editevent->gambar2 == null)
                            <p>Belum ada gambar</p>
                        @else
                            <img src="{{ asset('gambar_banner/'.$editevent->gambar2) }}" class="img-fluid mx-auto d-block mb-3 " height="10%" alt="...">
                        @endif
                        
                    </div>
                    <div class="class-sm-12 mt-1">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Back</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Inisialisasi DataTables
    var table = $('#dataTable').DataTable();

    // 1. Jika ada memori halaman tersimpan setelah reload, kembalikan tabel ke halaman tersebut
    if (localStorage.getItem('saved_datatables_page') !== null) {
        var pageNum = parseInt(localStorage.getItem('saved_datatables_page'));
        
        // Beri sedikit jeda agar tabel selesai digambar ulang oleh browser
        setTimeout(function() {
            table.page(pageNum).draw(false);
            localStorage.removeItem('saved_datatables_page'); // Bersihkan memori
        }, 100);
    }

    // 2. Saat tombol Update (tipe submit di dalam modal) diklik
    $(document).on('click', 'button[type="submit"]', function() {
        var form = $(this).closest('form');
        // Cek apakah ini form edit (memiliki metode PUT)
        if (form.find('input[name="_method"][value="PUT"]').length > 0) {
            // Ambil nomor halaman aktif DataTables saat ini (indeks mulai dari 0)
            var info = table.page.info();
            localStorage.setItem('saved_datatables_page', info.page);
        }
    });
});
</script>
@endsection