<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class RatingController extends Controller
{
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;

        $rating = Rating::firstOrNew([
            'user_id' => $user_id,
            'lavage_id' => $request->input("lavage_id"),
        ]);

        $rating->nbre_rating = $request->input("nbre_rating");

        if ($rating->exists) {
            $rating->save();

            return response()->json([
                "message" => "Mise à jour de la note"
            ], 409);
        } else {
            $rating->save();

            return response()->json([
                'message' => 'Note enregistrée avec succès',
                'data' => $rating
            ], 201);
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nbre_rating' => 'integer|min:1|max:5',
        ]);

        $rating = Rating::findOrFail($id);

        $rating->update($request->all());

        return response()->json(['message' => 'Note modifiée avec succès', 'data' => $rating]);
    }

    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);
        $rating->delete();

        return response()->json(['message' => 'Note supprimée avec succès']);
    }
}
