<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_type extends Model
{
    use HasFactory;
    public $table = "category";
    public $fillable = ['name','display'];
    public $timestamps = false;
}
