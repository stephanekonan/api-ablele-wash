<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Vehicule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehiculeController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;

        $vehicules = Vehicule::where('user_id', $user_id);

        return response()->json([
            'message' => 'Liste de mes vehicules',
            'data' => $vehicules
        ], 200);

    }

    public function store(Request $request)
    {
        $request->validate([
            'immatriculation' => 'required|string',
            'type' => 'required|string',
            'phone_driver' => 'required|string',
            'driver_name' => 'required|string',
            'driver_email' => 'required|email',
            'commune' => 'required|string',
        ]);

        $request->merge(['user_id' => auth()->id()]);

        $vehicule = Vehicule::create($request->all());

        return response()->json([
            'message' => 'Véhicule enregistré avec succès',
            'data' => $vehicule
        ], 201);
    }

    public function show($id)
    {
        $vehicule = Vehicule::find($id);

        if (!$vehicule) {
            response()->json([ 'message' => 'Vehicule non trouvé' ]);
        }

        return response()->json([
            'message' => 'Les données de ' . $vehicule->immatriculation,
            'data' => $vehicule
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $vehicule = Vehicule::find($id);

        if (!$vehicule) {
            return response()->json(['message' => 'Véhicule non trouvé'], 404);
        }

        $request->validate([
            'immatriculation' => 'required|string',
            'type' => 'required|string',
            'phone_driver' => 'required|string',
            'driver_name' => 'required|string',
            'driver_email' => 'required|email',
            'commune' => 'required|string',
        ]);

        $vehicule->update($request->all());

        return response()->json(['message' => 'Véhicule mis à jour avec succès', 'data' => $vehicule], 200);
    }

    public function destroy($id)
    {
        $vehicule = Vehicule::find($id);

        if (!$vehicule) {
            return response()->json(['message' => 'Véhicule non trouvé'], 404);
        }

        $vehicule->delete();

        return response()->json(['message' => 'Véhicule supprimé avec succès'], 200);
    }

}
