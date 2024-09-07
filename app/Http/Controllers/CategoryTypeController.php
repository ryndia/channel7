<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategory_typeRequest;
use App\Http\Requests\UpdateCategory_typeRequest;
use App\Models\Category;
use App\Models\Category_type;

class CategoryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategory_typeRequest $request)
    {
        $request->validate([
            'category' => ['required', 'string', 'max:25'],
        ]);

        $category_type = Category_type::create([
            'name' => $request->category,
        ]);

        return redirect('account');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category_type $category_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category_type $category_type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategory_typeRequest $request, Category_type $category_type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category_type $category_type)
    {
        if ($category_type->name != 'sidebar' && $category_type->name != 'opinion') {
            Category::where('cID', $category_type->id)->delete();
            Category_type::where('id', $category_type->id)->delete();
        }

        return redirect('account');
    }

    public function display_catergory(UpdateCategory_typeRequest $request)
    {
        foreach ($request->all() as $key => $value) {
            if ($key != '_token') {
                if (str_contains($key, 'cat_unapproved_')) {
                    $key = str_replace('cat_unapproved_', '', $key);
                    $category = Category_type::where('id', $key)->first();
                    if ($category) {
                        if ($value == 'on') {
                            $category->update([
                                'display' => 0,
                            ]);
                            echo $category;
                            $category->save();
                        }
                    }
                } else {
                    $key = str_replace('cat_approved_', '', $key);
                    $category = Category_type::where('id', $key)->first();
                    if ($category) {
                        if ($value == 'on') {
                            $category->update([
                                'display' => 1,
                            ]);
                            $category->save();
                        }
                    }
                }
            }
        }

        return redirect('account');
    }
}
