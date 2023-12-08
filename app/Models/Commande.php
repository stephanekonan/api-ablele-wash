<?php

namespace App\Models;

use App\Models\Lavage;
use App\Models\Product;
use App\Models\Vehicule;
use App\Models\TypeLavage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Employe; // Assurez-vous que le chemin est correct

class Commande extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'commandes';

    protected $fillable = [
        'product_id',
        'vehicule_id',
        'lavage_id',
        'type_lavage_id',
        'user_id',
        'status',
        'employe_id'
    ];

    public static function getCommandesByLavageUserId()
    {
        $userId = Auth::id();

        return self::join('lavages', 'commandes.lavage_id', '=', 'lavages.id')
            ->where('lavages.user_id', $userId)
            ->select('commandes.*')
            ->get();
    }

    public static function getAllCommandes()
    {
        return self::with(['product', 'vehicule', 'lavage', 'typeLavage', 'user', 'employe', 'employes'])->get();
    }

    public function employes()
    {
        return $this->hasMany(Employe::class, 'lavage_id', 'lavage_id');
    }

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'employe_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function lavage()
    {
        return $this->belongsTo(Lavage::class);
    }

    public function typeLavage()
    {
        return $this->belongsTo(TypeLavage::class, 'type_lavage_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
