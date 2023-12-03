<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller
{
    public function create()
    {
        return view('pages.auth.forget-password');
    }
    public function send(Request $request)
    {

        $email = $request->input('email');
        $user = DB::table('users')->where('email', $email)->first();

        if ($user) {

            $status = Password::sendResetLink(['email' => $user->email]);
            Session::flash('alert-type', 'success');
            Session::flash('alert-message', 'Email envoyé avec succès. Veuillez consulter votre boîte de reception !');
            return $status === Password::RESET_LINK_SENT
                        ? back()->with(['status' => __($status)])
                        : back()->withErrors(['email' => __($status)]);
        }
        Session::flash('alert-type', 'error');
        Session::flash('alert-message', 'Cet email est introuvable !');
        return redirect()->back();
    }
    public function resetPassword($token) {
        return view('pages.auth.reset-password', ['token' => $token]);
    }
    public function updatePassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login.index')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
