<?php

namespace App\Http\Controllers\Api\Manager;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Employe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ApiCommandeController extends Controller
{

    public function __construct() {
        $this->middleware('gerant');
    }

    public function getCommandesUtilisateurConnecte()
    {
        $user_id = Auth::id();

        $commandes = DB::table('commandes')
            ->join('lavages', 'commandes.lavage_id', '=', 'lavages.id')
            ->join('employes', 'commandes.employe_id', '=', 'employes.id')
            ->where('lavages.user_id', $user_id)
            ->select('commandes.*', 'employes.employe_name', 'employes.employe_phone', 'employes.employe_cni')
            ->get();

        return $commandes;
    }

    public function index()
    {
        $commandes = Commande::getCommandesByLavageUserId();

        return response()->json([
            'message' => 'Toutes mes commandes',
            'data' => $commandes
        ]);
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
            'message' => 'Détails de la commande ' . $commande->id,
            'data' => $commande
        ], 200);
    }

    public function edit($commandeId) {

        $commande_id = Crypt::decryptString($commandeId);

        $commande = Commande::find($commande_id);
        $employe = $commande->employe;

        $employes = Employe::all();

        if (!$commande) {
            return response()->json([ 'message' => 'Commande introuvable' ]);
        }

        $user_id =auth()->user()->id;

        if ($commande->user_id != $user_id)
        {
            return response()->json([
                'message' => 'Vous n\'avez pas les droits pour éditer cette commande'
            ], 403);
        }

        return response()->json([
            'message' => 'Edition de la commande '. $commande->id,
            'data' => [
                'commande' => $commande,
                'employe' => $employe,
                'employes' => $employes
            ]
        ]);
    }

    public function update(Request $request, $commande_id) {

        $commande = Commande::findOrFail($commande_id);

        if (!$commande) {
            return response()->json([
                "message" => "La commande introuvable",
            ]);
        }

        $data = [
            'status' => $request->input('status'),
            'employe_id' => $request->input('employe_id'),
        ];

        $commande->update($data);

        return response()->json([
            "message" => "La commande a bien été modifiée",
            "data" => $commande
        ]);

    }

    public function delete($id)
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json([
                'message' => 'Commande non trouvée'
            ], 404);
        }

        $user_id =auth()->user()->id;

        if ($commande->user_id != $user_id)
        {
            return response()->json([
                'message' => 'Vous n\'avez pas les droits pour supprimer cette commande'
            ], 403);
        }

        $commande->delete();

        return response()->json([
            'message' => 'Commande supprimée avec succès'
        ], 200);
    }
}
