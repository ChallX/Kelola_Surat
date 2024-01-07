@extends('layouts.template')

@section('content')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('klasifikasi.home') }}">Klasifikasi Surat</a></li>
              <li class="breadcrumb-item active" aria-current="page">Detail Klasifikasi</li>
            </ol>
          </nav>

          <div class="h4 mb-5">Berikut adalah Detail dari Klasifikasi Surat</div>
          @foreach ($letters as $i)
          
            <p class="fs-3">{{ $i->letterType->letter_code }} | {{ $i->letterType->name_type }} </p>
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                  <a style="float: right" href="{{ route('surat.print', $i->id) }}"><i class="fa fa-download"></i></a>
                  <h5 class="card-title">{{ $i->letter_perihal }}</h5>
                  <p class="card-text mx-2 fs-6"><b>{{ $i->created_at->format('d F Y') }}</b></p>
                  <ol>
                    <li><td>{{ implode(', ', array_column($i->recipients, 'name')) }}</td></li>
                  </ol>
                </div>
              </div>
          @endforeach
          
    </div>
@endsection