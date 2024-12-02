<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::all();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
         return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //
        DB::transaction(function () use ($request) {
            $validated = $request->validated();
            
            if($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('icon', 'public');
                $validated['icon'] = $iconPath; //storage/icons/angga.png
            } else {
                $iconPath = 'image/icon-category-default.png';
            }
            $validated['slug'] = str::slug($validated['name']);

            $category = category::create($validated);

        });

        return redirect()->route('admin.categories.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(category $category)
    {
        //
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, category $category)
    {
        //
        DB::transaction(function () use ($request, $category) {
            $validated = $request->validated();
            
            if($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('icon', 'public');
                $validated['icon'] = $iconPath; //storage/icons/angga.png
    
            }
            $validated['slug'] = str::slug($validated['name']);

            $category->update($validated);

        });

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(category $category)
    {
        //
        DB::beginTransaction();

        try {
            $category->delete();
            DB::commit();
            return redirect()->route('admin.categories.index');
        }
        catch (\Exception $e){
            DB::rollBack();
            return redirect()->route('admin.categories.index');
        }
        
    }
}
