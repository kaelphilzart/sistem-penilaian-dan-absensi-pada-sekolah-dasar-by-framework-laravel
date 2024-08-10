<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Validation\Rule;


class SessionController extends Controller
{
    //

    //login

    public function login(){
        return view('login');
    }

    public function register(){
        return view('register');
    }
    
    public function login_akun()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($attributes)) {
            $user = Auth::user(); // Mendapatkan objek pengguna yang berhasil login
            session()->regenerate();
    
            // Periksa level pengguna
            if ($user->level == '1') {
                return redirect('dashboard_admin')->with(['success' => 'Berhasil login sebagai admin.']);
            } elseif ($user->level == '2') {
                // Periksa jenis guru di tabel guru
                $guru = Guru::where('id_user', $user->id)->first();
                if ($guru) {
                    if ($guru->jenis_guru == 'wali_kelas') {
                        return redirect('dashboard_guru_waliKelas')->with(['success' => 'Berhasil login sebagai wali kelas.']);
                    } elseif ($guru->jenis_guru == 'guru_mapel') {
                        return redirect('dashboard_guru_mapel')->with(['success' => 'Berhasil login sebagai guru mapel.']);
                    } else {
                        return redirect('dashboard_guru')->with(['success' => 'Berhasil login sebagai guru.']);
                    }
                } else {
                    return redirect('dashboard_guru')->with(['success' => 'Berhasil login sebagai guru.']);
                }
            } elseif ($user->level == '3') {
                return redirect('dashboard_waliMurid')->with(['success' => 'Berhasil login sebagai wali murid.']);
            }
        }
    
        return back()->with(['error' => 'Email, password salah atau akun anda sudah dinonaktifkan']);
    }
    


    //register

  

    public function createUser()
{
    $attributes = request()->validate([
        'name' => ['required', 'max:50'],
        'email' => ['required', 'max:50', Rule::unique('users', 'email')],
        'password' => ['required', 'min:5', 'max:20'],
        'level' => 'required|in:1,2,3', // validasi level
    ]);
    $attributes['password'] = bcrypt($attributes['password']);

    $user = User::create($attributes);
    Auth::login($user);

    // Mengarahkan pengguna baru sesuai dengan level
    switch ($user->level) {
        case 1:
            return redirect('dashboard_admin')->with(['success' => 'Welcome admin.']);
            break;
        case 2:
            return redirect('dashboard_guru')->with(['success' => 'Welcome guru.']);
            break;
        case 3:
            return redirect('dashboard_waliMurid')->with(['success' => 'Welcome waliMurid.']);
            break;
        default:
            return redirect('errors.404')->with(['success' => 'tidak punya akun']);
            break;
    }
}
    

// public function createUser()
// {
//     $attributes = request()->validate([
//         'name' => ['required', 'max:50'],
//         'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
//         'password' => ['required', 'min:5', 'max:20'],
//         'level' => ['required']
//     ]);
//     $attributes['password'] = bcrypt($attributes['password'] );
    
//     $user = User::create($attributes);
    
//     return redirect()->route('login')->with(['success' => 'Your account has been created. Please login to continue.']);
// }


    //logout

    public function destroyAdmin()
    {

        Auth::logout();

        return redirect('/login')->with(['success'=>'berhasil logout.']);
    }

    public function destroyGuru()
    {

        Auth::logout();

        return redirect('/login')->with(['success'=>'berhasil logout.']);
    }

    public function destroyWaliMurid()
    {

        Auth::logout();

        return redirect('/login')->with(['success'=>'berhasil logout.']);
    }
}
