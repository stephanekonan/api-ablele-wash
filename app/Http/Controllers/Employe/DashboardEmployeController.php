<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Models\Commande; // Assurez-vous que le chemin est correct

class DashboardEmployeController extends Controller
{
    public function __construct() {
        $this->middleware('employe');
    }
    public function index() {
        return view('pages.employe.index');
    }

    public static function getAllCommandesByEmploye()
    {
        $employeId = Auth::guard('employe')->id();

        return Commande::whereHas('employe', function ($query) use ($employeId) {
            $query->where('id', $employeId);
        })->with(['product', 'vehicule', 'lavage', 'typeLavage', 'user', 'employe'])->get();
    }

    public function commandes()
    {
        $commandes = $this->getAllCommandesByEmploye();
        return view('pages.employe.commandes', compact('commandes'));
    }

    public function edit($commandeId) {

        $commande_id = Crypt::decryptString($commandeId);
        $commande = Commande::find($commande_id);
        $employes = $commande->employe;

        if (!$commande) {
            return redirect()->back()->with('message', 'Commande non trouvée.');
        }

        return view('pages.employe.edit', compact('commande', 'employes'));
    }

    public function update(Request $request, $commande_id) {

        $commande = Commande::findOrFail($commande_id);

        if (!$commande) {
            return back()->with('error', 'Véhicule non trouvé.');
        }

        $data = [
            'status' => $request->input('status'),
        ];

        $commande->update($data);

        return redirect()->route('employe.commandes');

    }
}
