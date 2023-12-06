<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'immatriculation',
        'type',
        'phone_driver',
        'driver_name',
        'driver_email',
        'commune',
        'user_id',
    ];

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

}
