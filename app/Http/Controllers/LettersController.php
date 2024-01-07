<?php

namespace App\Http\Controllers;

use App\Models\Letters;
use App\Models\LetterTypes;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\SuratExport;
use App\Models\Results;
use Maatwebsite\Excel\Facades\Excel;

use PDF;

class LettersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $letters = Letters::all();

        return view('surat.index', compact('letters'));
    }

    public function guruIndex()
    {
        $letters = Letters::all();

        return view('guru.index', compact('letters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $letter = LetterTypes::all();

        $user = User::where('role', 'guru')->get();

        return view('surat.create', compact('letter', 'user'));

        
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    

    $arrayDistinct = array_count_values($request->recipients);
    $arrayAssoc = [];

    foreach ($arrayDistinct as $id => $count) {
        $user = User::find($id);

        // Periksa apakah pengguna ditemukan sebelum mengakses properti 'name'
        if ($user) {
            $arrayItem = [
                "id" => $id,
                "name" => $user->name,
            ];

            array_push($arrayAssoc, $arrayItem);
        }
    }

    $request['recipients'] = $arrayAssoc;

    // dd($request->all(), $arrayAssoc);

    Letters::create([
        'letter_perihal' => $request->letter_perihal,
        'letter_type_id' => $request->letter_type_id,
        'content' => $request->content,
        'recipients' => $request->recipients,
        'attachment' => $request->attachment,
        'notulis' => $request->notulis
    ]);

    return redirect()->route('surat.home')->with('success', 'Berhasil Menambah Data');
}

    
    /**
     * Display the specified resource.
     */
    // Letters::create([
    //     'letter_perihal' => $request->letter_perihal,
    //     'letter_type_id' => $request->letter_type_id,
    //     'content' => $request->content,
    //     'recipients' => $request->recipients,
    //     'attachment' => $request->attachment,
    //     'notulis' => $request->notulis
    // ]);
    // Di dalam controller atau di mana Anda mengatur data untuk tampilan

public function show($id)
{
    $surat = Letters::find($id);
    $users = User::all();

    return view('surat.print', compact('surat', 'users'));
}


    /**
     * Show the form for editing the specified resource.
     */
        public function edit(Letters $letters, $id)
        {

            $letter= LetterTypes::all();

            $surat = Letters::findOrFail($id);

            $user = User::where('role', 'guru')->get(['id', 'name']);

            
            return view('surat.edit', compact('letter', 'user', 'surat'));

        
        }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Letters $letters, $id)
{
    // Pastikan $request->recipients adalah array sebelum menggunakan array_count_values
    $recipients = $request->recipients ?? [];

    $arrayDistinct = array_count_values($recipients);
    $arrayAssoc = [];

    foreach ($arrayDistinct as $userId => $count) {
        $user = User::find($userId);

        // Periksa apakah pengguna ditemukan sebelum mengakses properti 'name'
        if ($user) {
            $arrayItem = [
                "id" => $userId,
                "name" => $user->name,
            ];

            array_push($arrayAssoc, $arrayItem);
        }
    }

    $request['recipients'] = $arrayAssoc;

    // Update data surat dengan data baru
    $letters->where('id', $id)->update([
        'letter_perihal' => $request->letter_perihal,
        'letter_type_id' => $request->letter_type_id,
        'content' => $request->content,
        'recipients' => $request->recipients,
        'attachment' => $request->attachment,
        'notulis' => $request->notulis
    ]);

    return redirect()->route('surat.home')->with('success', 'Berhasil Mengubah Data');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Letters $letters, $id)
    {
        Letters::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus Data');
    }

    public function exportExcel()
    {
        $file_name = 'data-surat'.'.xlsx';

        return Excel::download(new SuratExport, $file_name, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function downloadPDF($id) 
{ 
    // Ambil objek model Letters berdasarkan ID
    $surat = Letters::find($id); 

    // Periksa apakah surat ditemukan
    if (!$surat) {
        // Lakukan penanganan jika surat tidak ditemukan
        // Misalnya, redirect ke halaman tertentu atau tampilkan pesan kesalahan
        // Di sini, saya mengembalikan response dengan pesan kesalahan
        return response()->json(['error' => 'Surat tidak ditemukan'], 404);
    }

    // Kirim objek model surat ke view
    view()->share('surat', $surat); 

    // Panggil view blade yang akan dicetak PDF serta data yang akan digunakan
    $pdf = PDF::loadView('surat.download', compact('surat')); 

    // Download PDF file dengan nama tertentu
    return $pdf->download('Surat.pdf'); 
}

    

}
