<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'photos',
        'product_id',
        'lavage_id'
    ];

    public function lavage()
    {
        return $this->belongsTo(Lavage::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
