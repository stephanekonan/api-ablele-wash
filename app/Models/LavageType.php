<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LavageType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lavage_id',
        'type_lavage_id',
        'user_id'
    ];

    public function lavage()
    {
        return $this->belongsTo(Lavage::class, 'lavage_id');
    }

    public function typelavage()
    {
        return $this->belongsTo(TypeLavage::class);
    }


}
