<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\LetterTypes;
use App\Models\Letters;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function hitung()
    {
        $staff = User::where('role', 'staff')->count();

        $guru = User::where('role', 'guru')->count();

        $surat = LetterTypes::get('name_type')->count();

        $datasur = Letters::get('id')->count();

        $auth = Auth::user()->name;
        $letter = Letters::where('recipients', 'like', '%"name":"'. $auth .'"%')->count();

        return view('home', compact('staff', 'guru', 'surat', 'datasur', 'letter'));  
    }

    // Staff
    public function index()
    {
        $staffs = User::where('role', 'staff')->get();

        return view('staff.index', compact('staffs'));
    }

    public function authLogin(Request $request)
    {
        $request -> validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = $request->only('email', 'password');
        if(Auth::attempt($user))
        {
            return redirect()->route('home')->with('success', 'Kamu berhasil Login!');
        } else {
            return redirect()->route('login')->with('failed', 'Tidak ada akun yang terdaftar');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('logout', 'Anda Berhasil Logout');
    }

    public function tambahStaff()
    {
        return view('staff.create');
    }

    public function staffStore(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required',
        ]);     

        $password = substr($request->email, 0, 3).substr($request->name, 0, 3);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => 'staff',
        ]);
        
        return redirect()->back()->with('success', 'Berhasil Menambah Data!');
    }

    public function staffEdit($id)
    {
        $staff = User::find($id);

        return view('staff.edit', compact('staff'));
    }

    public function staffUpdate(Request $request, $id)
    {
        $user = User::find($id);



        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'staff',
            ]);
        

        return redirect()->route('staff.home')->with('success', 'Akun berhasil diperbarui.');
    }

    public function staffDelete($id)
    {
        $user = User::Where('id', $id)->delete();

        return redirect()->route('staff.home')->with('success', 'Akun berhasil dihapus.');
    }


    // Guru
    public function indexGuru()
    {
        $users = User::where('role', 'guru')->get();

        return view('guru.index', compact('users'));
    }

    public function guruCreate()
    {
        return view('guru.create');
    }

    public function guruStore(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required',
        ]);

        $password = substr($request->email, 0, 3).substr($request->name, 0, 3);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => 'guru',
        ]);
        
        return redirect()->back()->with('success', 'Berhasil Menambah Data!');
    }

    public function guruEdit($id)
    {
        $gurus = User::Where('role', 'guru')->find($id);

        return view('guru.edit', compact('gurus'));
    }

    public function guruUpdate(Request $request, $id)
    {
        $user = User::find($id);
        
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);


            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'guru',
            ]);
        

        return redirect()->route('guru.home')->with('success', 'Akun berhasil diperbarui.');
    }

    public function guruDelete($id)
    {
        User::Where('id', $id)->delete();

        return redirect()->route('guru.home')->with('success', 'Akun berhasil dihapus.');
    }

    public function result()
    {
        $user = User::Where('role', 'guru')->get();

        return view('guru.result', compact('user'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'src' => 'required|string',
        ]);

        $users = User::where('name', 'like', '%' . $request->src . '%')->get();

        return view('guru.home', compact('users'));
    }
}
