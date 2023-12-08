<?php

namespace App\Http\Controllers\Api\Manager;

use App\Models\Album;
use App\Models\Lavage;
use App\Models\Commune;
use App\Models\Employe;
use App\Models\Product;
use App\Models\Category;
use App\Models\TypeLavage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class ApiProductController extends Controller
{

    public $product_id;
    public $image, $photos;

    public function __construct() {
        $this->middleware('gerant');
    }

    public function index()
    {

        $user_id = auth()->user()->id;
        $username = auth()->user()->username;

        $lavages = Lavage::where('user_id', $user_id)->get();

        return response()->json([
            'message' => 'Liste des lavages de' . $username,
            'data' => $lavages
        ], 200);
    }
    public function show($lavage_id)
    {

        $user_id = auth()->id();

        $communes = Commune::all();
        $lavage = Lavage::find($lavage_id);
        $employes = Employe::where('lavage_id', $lavage_id)->get();
        $categories = Category::where('user_id', $user_id)->get();
        $types_lavage = TypeLavage::where('user_id', $user_id)->get();
        $products = Product::where('lavage_id', $lavage_id)->latest()->get();

        if(!$lavage)
        {
            return response()->json([ 'message' => 'Lavage introuvage' ]);
        }

        return response()->json([
            'message' => 'Les infos sur '. $lavage->lavage_name,
            'data' => [
                'products' => $products,
                'employes' => $employes,
                'lavage' => $lavage,
                'types_lavage' => $types_lavage,
                'communes' => $communes,
                'categories' => $categories,
            ]
        ]);

    }
    public function store(Request $request)
    {

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
                    'product' => $product,
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

        $decrypted_id = Crypt::decryptString($id);


        $lavages = Lavage::all();
        $categories = Category::all();
        $product = Product::findOrFail($decrypted_id);

        if(!$product)
        {
            return response()->json([ 'message' => 'Produit introuvable' ]);
        }

        $categoriesAssocies = $product->categories;
        $lavagesAssocies = $product->lavages;

        return response()->json([
            'message' => 'Edition de ' . $product->title,
            'data' => [
                'product' => $product,
                'lavages' => $lavages,
                'categories' => $categories,
                'lavagesAssocies' => $lavagesAssocies,
                'categoriesAssocies' => $categoriesAssocies
            ]
        ]);
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

        return response()->json([
            'message' => 'Mise à jour effectué avec succès',
            'data' => $product
        ]);

    }
    public function deleteAlbumImage($photoId)
    {
        $albumPhoto = Album::find($photoId);

        if (!$albumPhoto) {
            return response()->json([ 'message' => 'Image introuvable' ]);
        }

        Storage::delete('albums/' . $albumPhoto->photos);

        $albumPhoto->delete();

        return response()->json([
            'message' => 'Image supprimée avec succès'
        ]);

    }
    public function deleteProduct($product_id)
    {
        $product = Product::find($product_id);

        if (!$product) {
            return response()->json([ 'message' => 'Produit introuvable' ]);
        }

        Storage::delete($product->image);

        foreach ($product->albums as $album) {
            foreach (explode('|', $album->photos) as $image) {
                Storage::delete('albums/' . $image);
            }
            $album->delete();
        }

        $product->delete();

        return response()->json([
            'message' => 'Produit supprimé avec succès'
        ]);
    }
}
