@extends('layouts.template')

@section('content')
    <div class="container">

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('surat.home') }}">Data Surat</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Data Surat</li>
            </ol>
          </nav>

        <div class="h2 mb-4">Edit Data Surat</div>
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="card mb-5">
            <div class="card-body">
                <form action="{{ route('surat.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                <div class="mb-3">
                    <label for="letter_perihal" class="form-label">Perihal</label>
                    <input type="text" class="form-control" name="letter_perihal" value="{{ $surat->letter_perihal }}">
                </div>
                <div class="mb-3">
                <label for="klasifikasi" class="form-label">Klasifikasi</label>
                <select class="form-select" name="letter_type_id" id="klasifikasi">
                    <option value="{{ $surat->letter_type_id }}">{{ $surat->letterType->name_type }}</option>
                    @foreach ($letter as $type)
                        <option value="{{ $type->id }}">{{ $type->name_type }}</option>
                    @endforeach
                </select>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Isi Surat</label>
                    <textarea class="form-control" name="content">{{ $surat->content }}</textarea>
                </div>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Nama</th>
                        <th>Peserta(Ceklis jika ya)</th>
                    </tr>
                    @foreach ($user as $item) 
                        <tr>
                            <td for=" flexCheckChecked{{ $item->id }}">{{ $item->name }}</td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $item->id }}" id="flexCheckChecked{{ $item->id }}" name="recipients[]" @if(in_array($item->id, $surat->recipients)) checked @endif>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>                
                <div class="mb-3">
                    <label for="formFile" class="form-label">Lampiran</label>
                    <input class="form-control" type="file" id="formFile" name="attachment">
                  </div>
                  <div class="mb-3">
                    <label for="klasifikasi" class="form-label">Notulis</label>
                    <select class="form-select" name="notulis" id="klasifikasi">
                        <option value="{{ $surat->letter_type_id }}">{{ $surat->user->name}}</option>
                        @foreach ($user as $i)
                            <option value="{{ $i->id }}">{{ $i->name}}</option>
                        @endforeach
                    </select>
                    </div>
                <button type="submit" class="btn btn-info text-white">Ubah</button>
            </div>
        </form>
        </div>
    </div>
@endsection