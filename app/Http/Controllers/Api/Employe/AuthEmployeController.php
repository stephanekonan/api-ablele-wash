<?php

namespace App\Http\Controllers\Api\Employe;

use App\Models\Employe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthEmployeController extends Controller
{
    public function login(Request $request)
    {
        $employe = Employe::where('employe_phone', $request->input('employe_phone'))->first();

        if ($employe && $request->input('password') == $employe->password) {
            Auth::guard('employe')->login($employe);
            $token = $employe->createToken('auth_token')->plainTextToken;
            return response()->json([
                'success' => 200,
                'token' => $token
            ]);
        } else {
            return response()->json([
                'success' => true,
                'error' => false,
                'message' => "Erreur de connexion"
            ]);
        }
    }
}
