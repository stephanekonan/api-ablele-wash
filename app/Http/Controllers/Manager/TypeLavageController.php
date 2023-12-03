<?php

namespace App\Http\Controllers\Manager;

use App\Models\TypeLavage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TypeLavageController extends Controller
{
    public function __construct() {
        $this->middleware('gerant');
    }

    public function store(Request $request) {

        $request->validate([
            'libelle' => ['required', 'min:5'],
            'prix' => ['required', 'numeric'],
            'slug' => ['required'],
        ]);

        $userID = auth()->id();

        TypeLavage::create([
            'libelle' => $request->libelle,
            'prix' => $request->prix,
            'user_id'=> $userID,
            'slug' => $request->slug,
        ]);

        return redirect()->back();

    }
}
