<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\User;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommandeController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $commandes = Commande::where('user_id', $user_id)->get();

        return response()->json([
            'message' => 'Mes commandes',
            'data' => $commandes
        ]);
    }

    public function edit($id)
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json([
                'message' => 'Commande non trouvée'
            ], 404);
        }

        return response()->json([
            'message' => 'Édition de la commande',
            'data' => $commande
        ], 200);
    }

    public function show($id)
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json([
                'message' => 'Commande non trouvée'
            ], 404);
        }

        return response()->json([
            'message' => 'Détails de la commande',
            'data' => $commande
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicule_id' => 'required',
            'lavage_id' => 'required',
            'type_lavage_id' => 'required',
        ]);

        $user_id = auth()->id();

        $request->merge(['user_id' => $user_id]);

        $commande = Commande::create($request->all());

        if($commande)
        {
            $user = User::find($user_id);
            $data =  [
                'point_fidelity' => $user->point_fidelity + 1
            ];
            $user->update($data);
        }

        return response()->json([
            'message' => 'Commande créée avec succès',
            'data' => $commande
        ], 201);

    }

    public function update(Request $request, $id)
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json([
                'message' => 'Commande non trouvée'
            ], 404);
        }

        $request->validate([
            'product_id' => 'required',
            'vehicule_id' => 'required',
            'lavage_id' => 'required',
            'type_lavage_id' => 'required',
            'status' => 'required',
            'employe_id' => 'required',
        ]);

        $commande->update($request->all());

        return response()->json([
            'message' => 'Commande mise à jour avec succès',
            'data' => $commande
        ], 200);
    }

    public function destroy($id)
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json([
                'message' => 'Commande non trouvée'
            ], 404);
        }

        $commande->delete();

        return response()->json([
            'message' => 'Commande supprimée avec succès'
        ], 200);
    }

}
