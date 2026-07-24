<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Menampilkan Halaman Register
    public function showRegister()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.packages.index');
            }
            return redirect('/');
        }
        return view('auth.register');
    }

    // 2. Memproses Data Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
            ],
            
            'no_hp' => [
                'required',
                'string',
                'max:15',
                'regex:/^[0-9]+$/'
            ], 
            
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*[^A-Za-z0-9]).+$/'
            ],
        ], [
            'email.unique' => 'Alamat email ini sudah terdaftar!',
            'email.regex' => 'Alamat email wajib menggunakan domain resmi @gmail.com.',
            'no_hp.regex' => 'Nomor handphone hanya boleh berisi angka.',
            'password.min' => 'Password minimal berisi 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.regex' => 'Password harus mengandung minimal 1 huruf besar dan 1 karakter unik/simbol.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,      
            'role' => 'wisatawan',            
        ]);

        return redirect()->route('login')->with('success', 'Akun wisatawan Anda berhasil terdaftar! Silakan masuk menggunakan email dan password Anda.');
    }

    //3. Menampilkan Halaman Login
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.packages.index');
            }
            return redirect('/');
        }
        return view('auth.login');
    }

    // 4. Memproses Autentikasi Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate(); 
            
            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('admin.packages.index'))->with('success', 'Selamat datang kembali, Admin!');
            }
            
            return redirect()->intended('/')->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // 5. Memproses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Anda telah berhasil keluar akun.');
    }
}