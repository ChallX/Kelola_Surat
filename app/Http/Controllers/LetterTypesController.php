<?php

namespace App\Http\Controllers;

use App\Models\LetterTypes;
use App\Models\Letters;
use Illuminate\Http\Request;
use App\Exports\KlasifikasiExport;
use Maatwebsite\Excel\Facades\Excel;

class LetterTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $letterTypes = LetterTypes::all();

        return view('klasifikasi.index', compact('letterTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('klasifikasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'letter_code' => 'required',
            'name_type' => 'required',
        ]);

        $no = LetterTypes::count() + 1;

        LetterTypes::create([
            'letter_code' => $request->letter_code . '-' . $no,
            'name_type' => $request->name_type,
        ]);

        return redirect()->back()->with('success', 'Berhasil Menambah Data');
    }

    /**
     * Display the specified resource.
     */
    public function show(LetterTypes $letterTypes, $id)
    {
        $letters = Letters::where('letter_type_id', $id)->get();

        return view('klasifikasi.detail', compact('letters'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LetterTypes $letterTypes, $id)
    {
        $letterTypes = LetterTypes::find($id);

        return view('klasifikasi.edit', compact('letterTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LetterTypes $letterTypes, $id)
    {
        $letterTypes = LetterTypes::find($id);

        $request->validate([
            'letter_code' => 'required',
            'name_type' => 'required',
        ]);

        $letterTypes->update([
            'letter_code' => $request->letter_code,
            'name_type' => $request->name_type,
        ]);

        return redirect()->route('klasifikasi.home')->with('success', 'Berhasil Mengubah Data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LetterTypes $letterTypes, $id)
    {
        LetterTypes::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus Data');
    }

    public function exportExcel()
    {
        $file_name = 'klasifikasi-surat'.'.xlsx';

        return Excel::download(new KlasifikasiExport, $file_name, \Maatwebsite\Excel\Excel::XLSX);
    }
}
