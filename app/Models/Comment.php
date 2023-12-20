<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'content',
        'user_id',
        'lavage_id'
    ];

    public function lavage()
    {
        return $this->belongsTo(Lavage::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'comment_id');
    }
}
