<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException; // Tambahkan ini untuk menangani QueryException

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('pages.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email', // Tambahkan validasi unik untuk email
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        try {
            event(new Registered($user = User::create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => Hash::make($request->password),
            ])));

            Auth::login($user);

            return redirect()->route('dashboard')->with(['message' => 'Registration success', 'alert' => 'alert-success']);
        } catch (QueryException $e) {
            // Tangkap pesan error duplikasi dan kembalikan ke halaman registrasi
            if ($e->getCode() == 23000) { // 23000 adalah kode untuk pelanggaran constraint integritas
                return redirect()->back()->withInput()->withErrors(['email' => 'Email sudah digunakan.']);
            }
            // Tangani exception lainnya
            return redirect()->back()->withInput()->withErrors(['message' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.']);
        }
    }
}

