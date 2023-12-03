<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeLavage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'libelle',
        'slug',
        'prix',
        'user_id'
    ];

    public function users() {
        return $this->belongsTo(User::class);
    }

    public function lavage()
    {
        return $this->belongsToMany(Lavage::class, 'lavage_types', 'type_lavage_id', 'lavage_id');
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

}
