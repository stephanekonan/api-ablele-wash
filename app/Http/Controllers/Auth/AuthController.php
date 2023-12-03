<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Lavage;
                                                                                                                                                                                                                                                                                      use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout',
        ]);
    }
    public function login()
    {
        return view('pages.auth.login');
    }

    public function loginStore(Request $request)
    {

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if(!$user) {
            Session::flash('alert-type', 'error');
            Session::flash('alert-message', 'Email ou mot de passe incorrect !');
            return redirect()->back();
        }

        if (Auth::attempt([ 'email'=> $email,'password' => $password])) {

            if(auth()->user()->role === 'admin') {
                return redirect()->route('admin.index');
            }

            if(auth()->user()->role === 'gerant') {

                $user_id = auth()->user()->id;

                $nbreLavages = Lavage::where('user_id', $user_id)->count();

                if($nbreLavages === 0) {
                    return redirect()->route('lavage.first');
                }
                return redirect()->route('dashboard.manager.index');
            }

        } else{
            Session::flash('alert-type', 'error');
            Session::flash('alert-message', 'Email ou mot de passe incorrect !');
            return redirect()->back();
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login.index');
    }

    public function register() {
        return view('pages.auth.register');
    }

    public function registerStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
            'password' => 'required|min:6',
            'cni' => 'required|string',
            'phone' => 'required|string',
        ]);

        try {
            $userRole = 'gerant';

            $user = new User();
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->role = $userRole;
            $user->cni = $request->cni;
            $user->phone = $request->phone;
            $user->point_fidelity = 0;

            $saved = $user->save();

            if($saved) {

                return redirect()->route('login.index')->with('success', 'Inscription effectuée avec succès');

            } else {

                return redirect()->back()->with('error', 'Une erreur s\'est produite');
            }

        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Quelque chose s\'est mal passé']);
        }

    }

}
