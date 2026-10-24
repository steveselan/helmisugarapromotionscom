@extends('layout.master')

@section('title','Detail Undangan')

@section('konten')
<div class="card mb-3" style="max-width: 600px;">
<div class="row no-gutters">
    <div class="col-md-6">
      <img src={{ asset('gambar_banner/'.$detail_undangan->gambar2) }} width="100%" alt="...">
    </div>
        <div class="col-md-6">
            <div class="card-body">
                <h class="card-text">
                @if ($detail_undangan->jenis == "PC") Press Conference
                @else Konser
                @endif</h>
                <h4 class="card-title font-weight-bold"><u>{{ $detail_undangan->judul_event }}</u></h4>
                <p class="card-text">Tanggal : {{ \Carbon\Carbon::parse($detail_undangan->tanggal)->format('j F Y') }}</p>
                <p class="card-text">Waktu acara : {{ $detail_undangan->jam }}</p>
                <p class="card-text">Lokasi : {{ $detail_undangan->lokasi }}</p>
                <p>
                   <a href="/liputan/formrsvp/{{ $detail_undangan->judul }}" target="_blank" class="btn btn-sm btn-secondary">Form RSVP</a>
                   <a href="/liputan/listrsvp/{{ $detail_undangan->judul }}" target="_blank" class="btn btn-sm btn-secondary">List Media RSVP</a>
                </p>
                {{-- <p class="card-text">Promoted by {{ $detail_event->promotor }}</p>
                <p class="card-text"><small class="text-muted">Status : {{ $detail_event->status }}</small></p> --}}
            </div>
        </div>
    </div>
    <a href="/undangan" class="btn btn-primary">Kembali</a>
</div>
@endsection