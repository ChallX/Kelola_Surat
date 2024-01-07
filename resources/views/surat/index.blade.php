@extends('layouts.template')

@section('content')
    <div class="container">

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Data Surat</li>
            </ol>
          </nav>

        <div class="h2">Hello,  {{ Auth::user()->name }}</div>
        <div class="h4 mb-5">Berikut adalah Data Surat</div>

        <div class=" d-flex">
            <a href="{{ route('surat.create') }}"><button class="btn btn-info mb-3 text-white me-2">Tambah Data</button></a>
            <a href="{{ route('export-excel-surat') }}"><button class="btn btn-secondary mb-3 text-white">Eksport Excel</button></a>
        </div>
        

        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif

        <div class="tombol d-flex">
            <form class="d-flex w-25 mb-2" role="search" action="{{ route('surat.search') }}" method="get">
                <input class="form-control me-2" type="text" placeholder="Search" aria-label="Search" name="src">
                <button class="btn btn-primary" type="submit">Search</button>
              </form>
            
            <form action="{{ route('surat.home') }}">
            <button class="btn btn-secondary ms-2" type="submit">Clear</button>
            </form>
        </div>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Surat</th>
                            <th>Perihal</th>
                            <th>Tanggal Keluar</th>
                            <th>Penerima Surat</th>
                            <th>Notulis</th>
                            <th>Hasil Rapat</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1
                        @endphp
                        @if (Auth::check())
                        @foreach ($letters as $i)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $i->letter_type_id }}</td>
                            <td>{{ $i->letter_perihal }}</td>
                            <td>{{ $i->created_at->format('d F Y') }}</td>
                            <td>{{ implode(', ', array_column($i->recipients, 'name')) }}</td>
                            <td>{{ $i->user->name }}</td>
                            <td>

                            @if (Auth::check())
                                

                                @if (App\Models\Results::where('letter_id', $i->id)->exists())
                                <a href="{{ route('result.show', $i->id) }}" style="color: limegreen">Sudah Dibuat</a>
                                @else
                                @if (Auth::user()->name == $i->user->name)
                                @if (Auth::user()->role == 'guru')
                                <a href="{{ route('result.results', $i->id) }}"><button class="btn btn-success text-white">Buat Hasil</button></a>
                                @endif
                                @else
                                <a href="#" style="color: red">Belum Dibuat</a>
                                @endif
                                @endif
                      
                                @else
                                    
                                @endif
                        </td>
                            <td>
                                    @if (Auth::user()->role == 'staff')
                                    <div class="d-flex">
                                        <a href="{{ route('surat.print', $i->id) }}"><button class="btn btn-primary text-white me-2">.pdf</button></a>
                                    <a href="{{ route('surat.edit', $i->id) }}"><button class="btn btn-success text-white me-2">Edit</button></a>
                                    <form action="{{ route('surat.delete', $i->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger text-white">Hapus</button>
                                    </form>     
                                    </div>                           
                                    @endif
                              
                                
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
    </div>



@endsection