<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Employe extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employe_name',
        'employe_phone',
        'employe_cni',
        'lavage_id',
        'user_id',
        'password',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function lavage() {
        return $this->belongsTo(Lavage::class);
    }

    public function commande() {
        return $this->hasMany(Commande::class);
    }
}
