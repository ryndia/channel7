<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoresubcategoryRequest;
use App\Http\Requests\UpdatesubcategoryRequest;

use App\Models\subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
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
    public function store(StoresubcategoryRequest $request)
    {
        $subcat = subcategory::create([
            'subcategory' => $request->subcategory,
            'cID'         => $request->cat
        ]);
        return redirect('account');
    }

    /**
     * Display the specified resource.
     */
    public function show(subcategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(subcategory $subcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatesubcategoryRequest $request, subcategory $subcategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(subcategory $subcategory)
    {
        subcategory::where('id', $subcategory->id)->delete();
        return redirect('account');
    }
}
