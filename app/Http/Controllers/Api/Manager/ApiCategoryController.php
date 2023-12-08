<?php

namespace App\Http\Controllers\Api\Manager;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiCategoryController extends Controller
{
    public function index()
    {

        $user_id = auth()->user()->id;

        $categories = Category::where('user_id', $user_id);

        return response()->json([
            'message' => 'Toutes mes catégories',
            'data' => $categories
        ]);

    }

    public function store(Request $request)
    {
        $user_id = auth()->user()->id;

        $categorySaved = Category::create([
            'libelle' => $request->libelle,
            'slug'=> $request->slug,
            'user_id' => $user_id
        ]);

        if(!$categorySaved)
        {
            return response()->json([ 'message' => 'Une erreur s\'est produite' ]);
        }

        return response()->json([
            'message' => 'Catégorie enregstrée avec succès',
            'data' => $categorySaved
        ]);

    }

    public function update(Request $request, $category_id)
    {
        $category = Category::find($category_id);

        if(!$category)
        {
            return response()->json(['message' => 'Catégorie non trouvé'], 404);
        }

        $data = [
            'libelle' => $request->libelle,
            'slug'=> $request->slug
        ];

        $category->update($data);

        return response()->json([
            'message' => 'Catégorie mis à jour avec succès',
            'data' => $category
        ], 200);
    }

    public function delete($category_id)
    {

        $category = Category::find($category_id);

        if(!$category)
        {
            return response()->json([ 'message' => 'Category introuvable' ]);
        }

        $category->delete();

        return response()->json([
            'message' => 'Catégorie supprimée avec succès'
        ]);

    }
}
