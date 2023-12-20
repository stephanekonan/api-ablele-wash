<?php

namespace App\Http\Controllers\Api\Employe;

use App\Models\Employe;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class AppMobileController extends Controller
{
    public function commandes()
    {
        $employeId = optional(Auth::guard('employe')->user())->id;

        if (!$employeId) {
            return response()->json(['message' => 'Connectez-vous en tant qu\'employé'], 403);
        }

        $commandes = Commande::whereHas('employe', function ($query) use ($employeId) {
            $query->where('id', $employeId);
        })->with(['product', 'vehicule', 'lavage', 'typeLavage', 'user', 'employe'])->get();

        return response()->json([
            'message' => 'Liste des commandes',
            'data' => $commandes
        ]);
    }

    public function edit($commandeId)
    {

        $commande_id = Crypt::decryptString($commandeId);
        $commande = Commande::find($commande_id);
        $employes = $commande->employe;

        if (!$commande) {
            return response()->json(['message', 'Commande non trouvée.']);
        }

        return response()->json([
            'message' => 'Edition de commande',
            'data' => [
                'commande' => $commande_id,
                'employes' => $employes
            ]
        ]);
    }

    public function update(Request $request, $commande_id)
    {

        $commande = Commande::find($commande_id);

        if (!$commande) {
            return response()->json(['error', 'Véhicule non trouvé.']);
        }

        $data = [
            'status' => $request->input('status'),
        ];

        $commande->update($data);

        return response()->json([
            'message' => 'Mise à effectuée avec succès',
            'data' => $commande
        ]);
    }
}
