<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $table = "category_article";
    protected $fillable = ['aID', 'cID', 'sID'];
    public $timestamps = false;
}
