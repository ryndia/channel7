<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    public $table = "article";
    protected $fillable = [ 'title', 'content', 'image', 'video', 'audio', 'display', 'writeby', 'approved', 'approved_time', 'approvedby', 'carousel_display'];
}
