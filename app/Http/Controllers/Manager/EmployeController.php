<?php

namespace App\Http\Controllers\Manager;

use App\Models\Lavage;
use App\Models\Commune;
use App\Models\Employe;
use App\Models\TypeLavage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class EmployeController extends Controller
{
    public function __construct()
    {
        $this->middleware('gerant');
    }
    public function index() {

        $user_id = auth()->id();

        $employes = Employe::where('user_id', $user_id)->latest()->get();
        $lavages = Lavage::where('user_id', $user_id)->get();
        $types_lavage = TypeLavage::where('user_id', $user_id)->get();
        $communes = Commune::all();

        return view('pages.manager.employees.index', compact('employes', 'lavages', 'types_lavage', 'communes'));
    }
    public function store(Request $request) {

        Employe::create([
            'employe_name' => $request->employe_name,
            'employe_phone' => $request->employe_phone,
            'employe_cni' => $request->employe_cni,
            'lavage_id' => $request->lavage_id,
            'password' => $request->password,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back();
    }
    public function edit($id) {

        $lavages = Lavage::all();
        $employe_id = Crypt::decryptString($id);
        $employe = Employe::find($employe_id);

        return view('pages.manager.employees.edit', compact('employe', 'lavages'));
    }
    public function update(Request $request, $employe_id) {

        $employe = Employe::findOrFail($employe_id);

        $lavage_id = $request->input('lavage_id');

        $data = [
            'employe_name' => $request->input('employe_name'),
            'employe_phone' => $request->input('employe_phone'),
            'employe_cni' => $request->input('employe_cni'),
            'lavage_id' => $lavage_id,
        ];

        $employe->update($data);

        return redirect()->route('employees.index')->with('success', 'Modification effectuée');

    }
    public function delete($employe_id) {

        $employe = Employe::find($employe_id);

        if (!$employe) {

            return redirect()->back()->with('error', 'Rôle non trouvé');

        } else {

            $employe->delete();
            return redirect()->back()->with('success', 'Employé supprimé avec succès');

        }

    }
}
