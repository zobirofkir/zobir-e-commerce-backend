<?php

namespace App\Services\Constructors;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface CategoryConstructor
{
    public function index() : AnonymousResourceCollection;

    public function show(Category $category) : CategoryResource;

    public  function store (CategoryRequest $request) : CategoryResource;

    public function update(CategoryRequest $request, Category $category) : CategoryResource;

    public function destroy(Category $category) : bool;
}