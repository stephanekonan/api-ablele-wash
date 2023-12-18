<?php

namespace App\Http\Controllers\Api\Manager;

use App\Models\Lavage;
use App\Models\Commune;
use App\Models\LavageType;
use App\Models\TypeLavage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ApiLavageController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('gerant');
    // }
    public function index()
    {
        $user_id = auth()->user()->id;
        $username = auth()->user()->username;

        if(!auth()->check()) {
            return response()->json([ 'message' => 'Veuillez vous connecter' ]);
        }

        $types_lavage = TypeLavage::where('user_id', $user_id);
        $lavages = Lavage::where('user_id', $user_id)->get();

        return response()->json([
            'message' => 'Liste des lavages de' . $username,
            'data' => [
                'type_lavage' => $types_lavage,
                'lavages' => $lavages,
            ]
        ]);
    }
    public function create()
    {
        $user_id = auth()->user()->id;
        $communes = Commune::all();
        $typesLavages = TypeLavage::where('user_id', $user_id)->get();
        return response()->json([
            'message' => 'Création de lavage',
            'data' => [
                'communes' => $communes,
                '$typesLavages' => $typesLavages
            ]
        ]);
    }

    public function edit($id) {
        $lavage = Lavage::find($id);

        if (!$lavage) {
            return response()->json([
                'message' => 'Lavage introuvable !'
            ], 404);
        }

        $user_id = auth()->user()->id;
        if ($lavage->user_id !== $user_id) {
            return response()->json([
                'message' => 'Vous n\'êtes pas autorisé à éditer ce lavage !'
            ], 403);
        }

        $typesLavages = TypeLavage::where('user_id', $user_id)->get();

        $associatedTypes = LavageType::where('lavage_id', $lavage->id)->pluck('type_lavage_id')->toArray();

        return response()->json([
            'message' => 'Édition du lavage: ' . $lavage->lavage_name,
            'data' => [
                'lavage' => $lavage,
                'typesLavages' => $typesLavages,
                'associatedTypes' => $associatedTypes
            ]
        ], 200);
    }
    public function store(Request $request) {

        $imageName = $request->photo->store('products');

        $statut = 'actif';

        $lavage = new Lavage();
        $lavage->lavage_name = $request->lavage_name;
        $lavage->status = $statut;
        $lavage->commune()->associate($request->commune_id);
        $lavage->photo = $imageName;
        $lavage->user_id = auth()->id();
        $lavage->save();

        $associatedTypes = LavageType::where('lavage_id', $lavage->id)->pluck('type_lavage_id')->toArray();

        if($lavage) {
            foreach ($request->type_lavage as $types_id) {
                LavageType::create([
                    'lavage_id' => $lavage->id,
                    'type_lavage_id' => $types_id,
                    'user_id' => auth()->id(),
                ]);
                $typesLavage[] = $types_id;
            }
        }
        return response()->json([
            'message' => 'Lavage enregistré avec succès',
            'data' => [
                'lavage' => $lavage,
                'typesLavage' => $typesLavage,
                '$associatedTypes' => $associatedTypes
            ]
        ], 201);

    }
    public function show($id)
    {

        $lavage = Lavage::find($id);
        $user_id = auth()->user()->id;

        if(!$lavage)
        {
            return response()->json([
                'message' => 'Lavage inexistant !'
            ], 404);
        }

        if($lavage->user_id !== $user_id)
        {
            return response()->json([
                'message' => 'Ce lavage reste introuvable !'
            ], 404);
        }

        $typesLavages = TypeLavage::where('user_id', $user_id)->get();

        $associatedTypes = LavageType::where('lavage_id', $lavage->id)->pluck('type_lavage_id')->toArray();

        return response()->json([
            'message' => 'Données du lavage: ' . $lavage->lavage_name,
            'data' => [
                'lavage' => $lavage,
                'typesLavages' => $typesLavages,
                'associatedTypes' => $associatedTypes
            ]
        ], 200);

    }
    public function update(Request $request, $lavage_id)
    {

        $lavage = Lavage::find($lavage_id);

        if (!$lavage) {
            return response()->json([
                'message' => 'Véhicule introuvable'
            ]);
        }

        if($lavage) {
            return response()->json([ 'message' => 'OK' ]);
        }

        if(auth()->user()->id !== $lavage->user_id)
        {
            return response()->json([
                'message' => "Action non autorisée !"
            ]);
        }

        $data = [
            'lavage_name' => $request->input('lavage_name'),
            'commune_id' => $request->input('commune_id'),
            'status' => $request->input('status'),
        ];

        if ($request->hasFile('photo')) {

            Storage::delete($lavage->photo);

            $imageName = $request->file('photo')->store('products');

            $data['photo'] = $imageName;
        }

        $lavage->update($data);

        if ($request->has('type_lavage')) {
            $typesLavage = $request->input('type_lavage', []);

            $syncData = [];
            foreach ($typesLavage as $type_id) {
                $syncData[$type_id] = ['user_id' => auth()->id()];
            }
            $lavage->typesLavage()->sync($syncData);

            $typesToDetach = $lavage->typesLavage()->whereNotIn('type_lavage_id', $typesLavage)->pluck('type_lavage_id')->toArray();

            if (!empty($typesToDetach)) {
                $lavage->typesLavage()->detach($typesToDetach);
            }

            $lavage->typesLavage()->updateExistingPivot($typesLavage, ['created_at' => now(), 'updated_at' => now()]);
        }

        return response()->json([
            'message' => 'Mise à jour effectuée avec succès',
            'data' => [
                'lavage' => $lavage,
                'type_lavage' => $lavage->typesLavage
            ]
        ]);
    }
    public function delete($lavage_id) {

        $lavage = Lavage::find($lavage_id);
        $lavagesTypes = LavageType::where('lavage_id', $lavage_id);

        $lavage->delete();

        $lavagesTypes->delete();

        return response()->json([
            'message' => 'Lavage auto supprimé avec succès'
        ]);

    }
}
