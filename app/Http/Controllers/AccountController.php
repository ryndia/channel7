<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\Category_type;
use App\Models\subcategory;

class AccountController extends Controller
{
    public function verify()
    {
        if(Auth::id()){
            $authenticatedUserId = Auth::id();
            $admin = DB::table('user_admin')->where('uID', $authenticatedUserId)->first();
            $category = Category_type::all();
            $subcat = subcategory::all();
            if($admin){
                if($admin->level == "admin" || $admin->level == "reviewer"){
                    $article = Article::all();
                    return view('dashboard_admin', ['article' => $article, 'admin' => $admin, 'category' => $category, 'sub' => $subcat]);
                }
                else{
                    $article = Article::where('writeby', Auth::id())->get();
                    return view('dashboard_admin', ['article' => $article,  'admin' => $admin , 'category' => $category]);
                }
            }
            else{
                return view('dashboard');
            }
        }
    }
}
