<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role_id',
        'author_id',
        'title',
        'slug',
        'image',
        'content',
        'tags',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'status',
        'featured'
    ];

    protected $table = 'blogs';

    public function author(){
        return $this->belongsTo('App\Models\Author','author_id','id');
    }
}
