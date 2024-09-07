<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_type extends Model
{
    use HasFactory;

    public $table = 'category';

    protected $fillable = ['name', 'display'];

    public $timestamps = false;

    // Many-to-Many relationship with Article
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'category_article', 'cID', 'aID');
    }

    // One-to-Many relationship with Subcategory
    public function subcategories()
    {
        return $this->hasMany(subcategory::class, 'cID');
    }
}
