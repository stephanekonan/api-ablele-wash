<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
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

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create(array_merge($request->all(), [
            'password' => Hash::make($request->password),
        ]));

        return response()->json([
            'message' => 'Inscription effectuée avec succès',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                Rule::exists('users')->whereNull('deleted_at'),
            ],
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Une erreur s\'est produite',
                'errors' => $validator->errors()
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Vous êtes connecté(es)',
                'user' => $user,
                'token' => $token
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid login credentials'
        ], 401);
    }

    public function logout(Request $request)
    {
        $tokens = $request->user()->tokens;

        foreach ($tokens as $token) {
            $token->delete();
        }

        return response()->json([
            'message' => 'Vous êtes déconnecté(e)'
        ], 200);
    }

}
