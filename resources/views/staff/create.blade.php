@extends('layouts.template')

@section('content')
    <div class="container">

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('staff.home') }}">Data Staff Tata Usaha</a></li>
              <li class="breadcrumb-item active" aria-current="page">Tambah Data Staff</li>
            </ol>
          </nav>

        <div class="h2 mb-4">Tambah data Staff Tata Usaha</div>

        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="card">
            <div class="card-body">
                <form action="{{ route('staff.store') }}" method="POST">
                    @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <button type="submit" class="btn btn-info text-white">Tambah</button>
            </div>
        </form>
        </div>
    </div>
@endsection