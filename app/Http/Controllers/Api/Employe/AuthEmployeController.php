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
        $token = $employe->createToken('employe-access-token')->plainTextToken;

        if ($employe && $request->input('password') == $employe->password) {
            return response()->json([
                'message' => 'Authentification réussie',
                'data' => [
                    'employe_id' => $employe->id,
                    'employe_name' => $employe->employe_name,
                    'token' => $token,
                ],
            ], 200);
        } else {
            return response()->json([
                'message' => 'Échec de l\'authentification',
                'errors' => [
                    'employe_phone' => ['Invalid credentials'],
                ],
            ], 401);
        }
    }

    public function profil()
    {
        $employe = Auth::guard('employe')->user();

        return response()->json([
            'message' => 'Employé infos:',
            'data' => $employe
        ]);
    }

    public function logout()
    {
        $user = Auth::guard('employe')->user();

        if ($user) {

            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        } else {

            return response()->json(['message' => 'Token de cet employé est introuvable'], 404);

        }

        return response()->json(['message' => 'Déconnexion réussie']);
    }
}
