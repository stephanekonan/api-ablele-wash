<?php

namespace App\Http\Controllers\Manager;

use App\Models\Lavage;
use App\Models\Commune;
use App\Models\Employe;
use App\Models\Product;
use App\Models\Commande;
use App\Models\LavageType;
use App\Models\TypeLavage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class LavageController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('gerant');
    // }
    public function index()
    {
        $user_id = auth()->user()->id;

        $types_lavage = TypeLavage::where('user_id', $user_id);
        $communes = DB::table('communes')->get();
        $lavages = Lavage::where('user_id', $user_id)->get();

        $nombreEmployes = [];
        foreach ($lavages as $lavage) {
            $nombre = $lavage->employees->count();
            $nombreEmployes[$lavage->id] = $nombre;
        }

        return view('pages.manager.lavages.index',
            compact('lavages', 'types_lavage', 'communes', 'nombreEmployes')
        );
    }

    public function create()
    {
        $user_id = auth()->user()->id;
        $communes = Commune::all();
        $typesLavages = TypeLavage::where('user_id', $user_id)->get();
        return view('pages.manager.lavages.create', compact('typesLavages', 'communes'));
    }

    public function store(Request $request) {

        try {

            $imageName = $request->photo->store('products');

            $statut = 'actif';

            $lavage = new Lavage();
            $lavage->lavage_name = $request->lavage_name;
            $lavage->status = $statut;
            $lavage->commune()->associate($request->commune_id);
            $lavage->photo = $imageName;
            $lavage->user_id = auth()->id();
            $lavage->save();

            if($lavage) {
                foreach ($request->type_lavage as $types_id) {
                    LavageType::create([
                        'lavage_id' => $lavage->id,
                        'type_lavage_id' => $types_id,
                        'user_id' => auth()->id(),
                    ]);
                }
            }
            return redirect()->route('lavage.index');

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('error', 'Une erreur s\'est produite')->withInput();
        }

    }

    public function show($id) {

        $lavage = Lavage::find($id);

        if(!$lavage)
        {
            return response()->json([
                'message' => 'Lavage inexistant !'
            ], 404);
        }

        return response()->json([
            'message' => 'Données du lavage: ' . $lavage->lavage_name,
            'data' => $lavage,
        ], 200);

    }
    public function delete($lavage_id) {

        $lavage = Lavage::find($lavage_id);
        $lavagesTypes = LavageType::where('lavage_id', $lavage_id);
        $lavage->delete();
        $lavagesTypes->delete();
        return redirect()->route('lavage.index');

    }

    public function edit($id) {

        $lavage_id = Crypt::decryptString($id);

        $lavage = Lavage::findOrFail($lavage_id);

        $user_id = auth()->user()->id;

        $typesLavages = TypeLavage::where('user_id', $user_id)->get();

        $associatedTypes = LavageType::where('lavage_id', $lavage_id)->pluck('type_lavage_id')->toArray();

        $communes = Commune::all();

        return view('pages.manager.lavages.edit',
           compact('lavage', 'communes', 'associatedTypes', 'typesLavages')
        );
    }
    public function update(Request $request, $lavage_id)
    {

        $lavage = Lavage::find($lavage_id);

        if (!$lavage) {
            return response()->json([
                'message' => 'Véhicule introuvable'
            ]);
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
}
