<?php

namespace App\Services\Services;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\Constructors\CategoryConstructor;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class CategoryService implements CategoryConstructor
{
    public function index() : AnonymousResourceCollection
    {
        return CategoryResource::collection(
            Category::paginate(10)
        );
    }

    public function show(Category $category) : CategoryResource
    {
        return CategoryResource::make($category);
    }

    public function store(CategoryRequest $request) : CategoryResource
    {
        $validatedData = $request->validated();

        if (isset($validatedData['image'])) {
            $validatedData['image'] = $request->file('image')->store('categories', 'public');
        }

        $validatedData['user_id'] = Auth::user()->id;

        return CategoryResource::make(
            Category::create($validatedData)
        );
    }


    public function update(CategoryRequest $request, Category $category) : CategoryResource
    {
        $category->update($request->validated());
        return CategoryResource::make(
            $category->refresh()
        );
    }

    public function destroy(Category $category) : bool
    {
        return $category->delete();
    }
}