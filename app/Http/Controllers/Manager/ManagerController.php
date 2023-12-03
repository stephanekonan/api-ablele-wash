<?php

namespace App\Http\Controllers\Manager;

use App\Models\Lavage;
use App\Models\Commune;
use App\Models\Category;
use App\Models\TypeLavage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{

    public function __construct()
    {
        $this->middleware('gerant');
    }

    public function firstLavage() {

        $user_id = Auth::user()->id;

        $lavages = Lavage::where('user', $user_id);
        $types_lavage = TypeLavage::all();
        $communes  = Commune::all();

        return view('pages.manager.create', compact('lavages', 'types_lavage', 'communes'));
    }

    public function index()
    {
        return view('pages.manager.index');
    }


}
