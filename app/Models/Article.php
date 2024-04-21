<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use Searchable;
    use HasFactory;
    public $table = "article";
    protected $fillable = [ 'title', 'content', 'image', 'video', 'audio', 'display', 'writeby', 'approved', 'approved_time', 'approvedby', 'carousel_display'];

    public function searchableAs(): string
    {
        return 'articles_index';
    }
}
