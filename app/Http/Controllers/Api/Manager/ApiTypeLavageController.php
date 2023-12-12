<?php

namespace App\Http\Controllers\Api\Manager;

use App\Models\TypeLavage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiTypeLavageController extends Controller
{
    public function __construct() {
        $this->middleware('gerant');
    }

    public function index()
    {
        $user_id = auth()->user()->id;
        $typesLavage = TypeLavage::where('user_id', $user_id)->get();

        return response()->json([
            'message' => 'Mes types de lavages enregistrés',
            'data' => $typesLavage
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'libelle' => ['required', 'min:5'],
            'prix' => ['required', 'numeric'],
            'slug' => ['required'],
        ]);

        $userID = auth()->id();

        $request->merge(['user_id' => $userID]);

        $type = TypeLavage::create($request->all());

        return response()->json([
            'message' => 'Type de lavage ajouté avec succès',
            'data' => $type
        ], 201);

    }

    public function delete($type_id)
    {
        $type = TypeLavage::find($type_id);

        if(!$type)
        {
            return response()->json([ 'message' => 'Type introuvable' ], 404);
            
        } else {

            $type->delete();

            return response()->json([ 'message' => 'Type de lavage supprimé avec succès' ], 200);

        }
    }
}
