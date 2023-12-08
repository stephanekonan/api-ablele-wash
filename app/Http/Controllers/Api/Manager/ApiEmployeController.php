<?php

namespace App\Http\Controllers\Api\Manager;

use App\Models\Lavage;
use App\Models\Commune;
use App\Models\Employe;
use App\Models\TypeLavage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class ApiEmployeController extends Controller
{

    public function __construct()
    {
        $this->middleware('gerant');
    }
    
    public function index() {

        $user_id = auth()->id();

        $communes = Commune::all();
        $lavages = Lavage::where('user_id', $user_id)->get();
        $types_lavage = TypeLavage::where('user_id', $user_id)->get();
        $employes = Employe::where('user_id', $user_id)->latest()->get();
        $lavagesEmployes = $employes->lavage;

        return response()->json([
            'message' => 'Liste de mes employés',
            'data' => [
                'lavages' => $lavages,
                'communes' => $communes,
                'employes' => $employes,
                'types_lavage' => $types_lavage,
                'lavagesEmployes' => $lavagesEmployes
            ]
        ]);
    }

    public function store(Request $request) {

        $employe = Employe::create([
            'employe_name' => $request->employe_name,
            'employe_phone' => $request->employe_phone,
            'employe_cni' => $request->employe_cni,
            'lavage_id' => $request->lavage_id,
            'password' => $request->password,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => $employe->employe_name . ' ajouté avec succès',
            'data' => $employe
        ]);
    }

    public function edit($id) {

        $lavages = Lavage::all();
        $employe_id = Crypt::decryptString($id);
        $employe = Employe::find($employe_id);

        return response()->json([
            'message' => 'Modification des données de ' . $employe->employe_name,
            'data' => [
                'employe' => $employe,
                'lavages' => $lavages
            ]
        ]);
    }

    public function update(Request $request, $employe_id)
    {

        $employe = Employe::findOrFail($employe_id);

        if(!$employe)
        {
            return response()->json([ 'message' => 'Employé introuvable' ]);
        }

        $lavages = Lavage::all();

        $lavage_id = $request->input('lavage_id');

        $data = [
            'employe_name' => $request->input('employe_name'),
            'employe_phone' => $request->input('employe_phone'),
            'employe_cni' => $request->input('employe_cni'),
            'lavage_id' => $lavage_id,
        ];

        $employe->update($data);

        return response()->json([
            'message' => 'Mise à jour effectué avec succès',
            'data' => [
                'lavages' => $lavages,
                'employe' => $employe
            ]
        ]);

    }

    public function delete($employe_id) {

        $employe = Employe::find($employe_id);

        if (!$employe) {

            return response()->json([ 'message' => 'Employé introuvable' ]);

        } else {

            $employe->delete();
            return response()->json([
                'message' => 'Employé supprimé avec succès'
            ]);

        }

    }
}
