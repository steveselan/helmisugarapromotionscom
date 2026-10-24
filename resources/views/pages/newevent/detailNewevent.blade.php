@extends('layout.master')

@section('title','Detail Event')

@section('konten')
<div class="row">
    <div class="col-md-12">
      <img src={{ asset('gambar_banner/'.$detail_event->gambar1) }} width="45%" alt="...">
    </div>
  </div>
<div class="card mb-3" style="max-width: 600px;">
  
  <div class="row no-gutters">
    <div class="col-md-6">
      <img src={{ asset('gambar_banner/'.$detail_event->gambar2) }} width="100%" alt="...">
    </div>
    <div class="col-md-6">
      <div class="card-body">
        <h6 class="card-title font-weight-bold"><u>{{ $detail_event->judul_event }}</u></h6>
        <p class="card-text">{{ $detail_event->lokasi }}</p>
        <p class="card-text">{{ \Carbon\Carbon::parse($detail_event->tanggal)->format('j F Y') }}</p>
        <p class="card-text">Ticket available at {{ $detail_event->link_tiket }}</p>
        <p class="card-text">Promoted by {{ $detail_event->promotor }}</p>
        <p class="card-text"><small class="text-muted">Status : {{ $detail_event->status }}</small></p>
      </div>
    </div>
  </div>
  <a href="/newevent" class="btn btn-primary">Kembali</a>
</div>
@endsection