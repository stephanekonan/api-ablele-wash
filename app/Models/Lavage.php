<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lavage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lavage_name',
        'photo',
        'commune_id',
        'user_id',
        'status'
    ];

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function employees() {
        return $this->hasMany(Employe::class);
    }

    public function typesLavage() {
        return $this->belongsToMany(TypeLavage::class, 'lavage_types', 'lavage_id', 'type_lavage_id');
    }

    public function lavagesTypes() {
        return $this->hasMany(LavageType::class);
    }

    public function commune() {
        return $this->belongsTo(Commune::class);
    }


}
