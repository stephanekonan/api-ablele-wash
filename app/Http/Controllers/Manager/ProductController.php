<?php

namespace App\Http\Controllers\Manager;

use Carbon\Carbon;
use App\Models\Album;
use App\Models\Lavage;
use App\Models\Commune;
use App\Models\Employe;
use App\Models\Product;
use App\Models\Category;
use App\Models\TypeLavage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    public $product_id;
    public $image, $photos;

    // public function __construct() {
    //     $this->middleware('gerant');
    // }

    public function index($lavage_id) {

        $lavage = Lavage::find($lavage_id);

        $products = Product::with('albums')->where('lavage_id', $lavage->id)->latest()->paginate(10);

        return view('pages.gerants.products.index', compact('lavage', 'products'));
    }

    public function allproducts() {

        if(!auth()->check())
        {
            return response()->json([
                'message' => 'Veuillez vous connecter s\'il vous plait',
            ], 401);
        }

        $user_id = auth()->id();

        $products = Product::where('user_id', $user_id)->latest()->get();
        $employes = Employe::where('user_id', $user_id)->get();
        $lavages = Lavage::where('user_id', $user_id)->get();
        $types_lavage = TypeLavage::where('user_id', $user_id)->get();
        $communes = Commune::all();
        $categories = Category::all();

        return response()->json([
            'products' => $products,
            'employes' => $employes,
            'lavages' => $lavages,
            'types_lavage' => $types_lavage,
            'communes' => $communes,
            'categories' => $categories,
        ]);

    }

    public function store(Request $request) {

        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $imageName = $request->file('image')->store('products');

        $status = 'actif';

        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->original_price = $request->original_price;
        $product->image = $imageName;
        $product->instock = $request->instock;
        $product->lavage()->associate($request->lavage_id);
        $product->category()->associate($request->category_id);
        $product->user_id = auth()->user()->id;
        $product->status = $status;

        if(!auth()->check()) {

            return response()->json([
                'message' => 'Veuillez vous connecter s\'il vous plait',
            ]);

        }
        $product->save();

        if ($product) {

            foreach ($request->photos as $key => $image) {

                $albumPhoto = new Album();
                $imageName = Carbon::now()->timestamp . $key . '.' .$request->photos[$key]->extension();
                $request->photos[$key]->storeAs('albums/', $imageName);

                $albumPhoto->photos = $imageName;
                $albumPhoto->product_id = $product->id;
                $albumPhoto->lavage_id = $request->lavage_id;
                $albumPhoto->save();
            }

            return response()->json([
                'message' => 'Produit créé avec succès',
                'data' => [
                    'product' => $$product,
                    'album' => $albumPhoto
                ]
            ]);

        } else {

            return response()->json([
                'message' => 'Produit non enregistré',
            ], 401);

        }
    }
    public function edit($id)
    {
        $user_id = auth()->id();

        $decrypted_id = Crypt::decryptString($id);
        $categories = Category::all();
        $lavages = Lavage::all();
        $product = Product::findOrFail($decrypted_id);
        return view('pages.manager.products.edit', compact('product','categories', 'lavages'));
    }
    public function update(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);

        $data = [
            'title' => $request->input('title'),
            'category_id' => $request->input('category_id'),
            'lavage_id' => $request->input('lavage_id'),
            'description' => $request->input('description'),
            'original_price' => $request->input('original_price'),
            'instock' => $request->input('instock'),
            'status' => $request->input('status'),
        ];

        $lavage_id = $request->input('lavage_id');

        if ($request->hasFile('image')) {

            Storage::delete('products/' . $product->image);

            $imageName = $request->file('image')->store('products');

            $data['image'] = $imageName;
        }

        if ($request->hasFile('photos')) {
            foreach ($request->photos as $key => $image) {

                $albumPhoto = new Album();
                $imageName = Carbon::now()->timestamp . $key . '.' .$request->photos[$key]->extension();
                $request->photos[$key]->storeAs('albums/', $imageName);

                $albumPhoto->photos = $imageName;
                $albumPhoto->product_id = $product->id;
                $albumPhoto->lavage_id = $request->lavage_id;
                $albumPhoto->save();

            }
        }

        $product->update($data);

        return redirect()->route('products.index', $lavage_id);

    }
    public function deleteAlbumImage($photoId)
    {
        $albumPhoto = Album::find($photoId);

        if (!$albumPhoto) {
            return redirect()->back()->with('error', 'Image introuvable.');
        }

        Storage::delete('albums/' . $albumPhoto->photos);

        $albumPhoto->delete();

        return redirect()->back()->with('success', 'Image supprimée avec succès.');

    }
    public function deleteProduct($product_id)
    {
        $product = Product::find($product_id);

        if (!$product) {
            return redirect()->back()->with('warning', "Produit introuvable.");
        }

        Storage::delete($product->image);

        foreach ($product->albums as $album) {
            foreach (explode('|', $album->photos) as $image) {
                Storage::delete('albums/' . $image);
            }
            $album->delete();
        }

        $product->delete();

        return redirect()->back();
    }
}
