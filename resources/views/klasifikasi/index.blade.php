@extends('layouts.template')

@section('content')
    <div class="container">

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Klasifikasi Surat</li>
            </ol>
          </nav>

        <div class="h2">Hello,  {{ Auth::user()->name }}</div>
        <div class="h4 mb-5">Berikut adalah Data Klasifikasi Surat</div>

        <div class=" d-flex">
            <a href="{{ route('klasifikasi.create') }}"><button class="btn btn-info mb-3 text-white me-2">Tambah Data</button></a>
            <a href="{{ route('export-excel-klasifikasi') }}"><button class="btn btn-secondary mb-3 text-white">Eksport Excel</button></a>
        </div>
        

        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Surat</th>
                            <th>Klasifikasi Surat</th>
                            <th>Surat Tertaut</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1
                        @endphp
                        @foreach ($letterTypes as $i)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $i->letter_code }}</td>
                            <td>{{ $i->name_type }}</td>
                            <td>{{ App\Models\Letters::where('letter_type_id', $i->id)->count() }}</td>
                            <td>
                                <div class="d-flex">
                                    


                                    <a href="{{ route('klasifikasi.show', $i->id) }}"><button class="btn btn-primary text-white me-2">Detail</button></a>
                                <a href="{{ route('klasifikasi.edit', $i->id) }}"><button class="btn btn-success text-white me-2">Edit</button></a>
                                <form action="{{ route('klasifikasi.delete', $i->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger text-white">Hapus</button>
                                </form>     
                                </div>                           
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

    </div>

    <!-- Modal -->

@endsection