@extends('layouts.template')

@section('content')
    <div class="container">

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('klasifikasi.home') }}">Klasifikasi Surat</a></li>
              <li class="breadcrumb-item active" aria-current="page">Tambah Data Klasifikasi</li>
            </ol>
          </nav>

        <div class="h2 mb-4">Tambah Data Klasifikasi Surat</div>
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="card">
            <div class="card-body">
                <form action="{{ route('klasifikasi.store') }}" method="POST">
                    @csrf
                <div class="mb-3">
                    <label for="letter_code" class="form-label">Kode Surat</label>
                    <input type="text" class="form-control" name="letter_code">
                </div>
                <div class="mb-3">
                    <label for="name_type" class="form-label">Klasifikasi Surat</label>
                    <input type="text" class="form-control" name="name_type">
                </div>
                <button type="submit" class="btn btn-info text-white">Tambah</button>
            </div>
        </form>
        </div>
    </div>
@endsection