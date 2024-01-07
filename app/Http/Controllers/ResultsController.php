<?php

namespace App\Http\Controllers;

use App\Models\Results;
use App\Models\User;
use App\Models\Letters;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $user = User::Where('role', 'guru')->get();

        $letters = Letters::Where('id', $id)->first();

        return view('guru.result', compact('user', 'letters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $arrayDistinct = array_count_values($request->presence_recipients);
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

    $request['presence_recipients'] = $arrayAssoc;

    // dd($request->all(), $arrayAssoc);

    Results::create($request->all());

    return redirect()->route('data')->with('success', 'Berhasil Menambah Data');
    }

    /**
     * Display the specified resource.
     */
    public function show(Results $results, $id)
    {
        
        $result = Results::where('letter_id', $id)->first();

        $user = User::Where('role', 'guru')->get();

        $surat = Letters::find($id);

        return view('result.result', compact('result', 'user', 'surat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Results $results)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Results $results)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Results $results)
    {
        //
    }
}
