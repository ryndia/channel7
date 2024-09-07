<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Article;
use App\Models\Category_type;
use App\Models\subcategory;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function verify()
    {
        if (Auth::id()) {
            $authenticatedUserId = Auth::id();
            $admin = Admin::where('uID', $authenticatedUserId)->first();
            $category = Category_type::all();
            $subcat = subcategory::all();
            if ($admin) {
                if ($admin->level == 'admin' || $admin->level == 'reviewer') {
                    $article = Article::all();

                    return view('dashboard_admin', ['article' => $article, 'admin' => $admin, 'category' => $category, 'sub' => $subcat]);
                }

                if ($admin->level == 'writer') {
                    $article = Article::where('writeby', Auth::id())->get();

                    return view('dashboard_admin', ['article' => $article,  'admin' => $admin, 'category' => $category]);
                }
            }

            return view('dashboard');
        }
    }
}
