<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'lavage_id', 'nbre_rating'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lavage()
    {
        return $this->belongsTo(Lavage::class);
    }
}
