<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['subcategory', 'cID'];

    // Inverse of One-to-Many relationship with Category
    public function category()
    {
        return $this->belongsTo(Category_type::class, 'cID');
    }

    // Many-to-Many relationship with Article through the pivot table
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'category_article', 'sID', 'aID');
    }
}
