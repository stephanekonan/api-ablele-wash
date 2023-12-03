<?php

namespace App\Http\Controllers\Manager;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware('gerant');
    }
    public function store(Request $request) {

        $categorySaved = Category::create([
            'libelle' => $request->libelle,
            'slug'=> $request->slug,
            'user_id' => auth()->user()->id
        ]);

        if($categorySaved) {
            return redirect()->back();
        } else {
            return redirect()->back();
        }

    }
}
