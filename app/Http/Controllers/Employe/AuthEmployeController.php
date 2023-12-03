<?php

namespace App\Http\Controllers\Employe;

use App\Models\Employe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthEmployeController extends Controller
{
    public function index() {
        return view('pages.employe.index');
    }

    public function login()
    {
        if (Auth::guard('employe')->check()) {
            return redirect()->to(url()->previous());
        }
        return view('pages.employe.login');
    }

    public function store(Request $request)
    {
        $employe = Employe::where('employe_phone', $request->input('employe_phone'))->first();

        if ($employe && $request->input('password') == $employe->password) {
            Auth::guard('employe')->login($employe);
            return redirect('/employe/dashboard');
        } else {
            return redirect()->back()->withErrors(['employe_phone' => 'Invalid credentials']);
        }
    }

    public function logout(Request $request)
    {

        Auth::guard('employe')->logout();
        $request->session()->invalidate();

        return redirect('/employe/login');

    }
}
