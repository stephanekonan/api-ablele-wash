<?php

namespace App\Http\Controllers\Manager;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CommandeController extends Controller
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
        return view('pages.manager.commandes.index', compact('commandes'));
    }

    public function edit($commandeId) {

        $commande_id = Crypt::decryptString($commandeId);
        $commande = Commande::find($commande_id);
        $employes = $commande->employes;

        if (!$commande) {
            return redirect()->back()->with('message', 'Commande non trouvée.');
        }

        return view('pages.manager.commandes.edit', compact('commande', 'employes'));
    }

    public function update(Request $request, $commande_id) {

        $commande = Commande::findOrFail($commande_id);

        if (!$commande) {
            return back()->with('error', 'Véhicule non trouvé.');
        }

        $data = [
            'status' => $request->input('status'),
            'employe_id' => $request->input('employe_id'),
        ];

        $commande->update($data);

        return redirect()->route('commandes.index');

    }
}
