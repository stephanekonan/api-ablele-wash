<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description', 'original_price', 'instock', 'image', 'lavage_id', 'category_id', 'user_id', 'status'];


    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function lavage() {
        return $this->belongsTo(Lavage::class);
    }

    public function boutique() {
        return $this->belongsTo(Boutique::class);
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

}
