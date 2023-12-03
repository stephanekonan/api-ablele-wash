<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'message' => 'Les données de ' . $user->username,
            'user' => $user
        ]);
    }

    public function products()
    {

        $products = Product::all();

        return response()->json([
            'data' => $products
        ]);
        
    }

    public function users()
    {
        $users = User::all();

        return response()->json([
            'message' => 'Liste de tous les utilisateurs',
            'users' => $users
        ]);
    }

    public function test()
    {
        return 'OK';
    }


}
