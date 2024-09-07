<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use HasFactory, Searchable;

    public $table = 'article';

    protected $fillable = ['title', 'content', 'image', 'video', 'audio', 'display', 'writeby', 'approved', 'approved_time', 'approvedby', 'carousel_display'];

    public function searchableAs(): string
    {
        return 'articles_index';
    }

    // Many-to-Many relationship with Category
    public function categories()
    {
        return $this->belongsToMany(Category_type::class, 'category_article', 'aID', 'cID');
    }

    // Many-to-Many relationship with Subcategory through the pivot table
    public function subcategories()
    {
        return $this->belongsToMany(subcategory::class, 'category_article', 'aID', 'sID');
    }
}
