<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\Facades\CategoryFacade;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryFacade::index();
    }

    public function show(Category $category)
    {
        return CategoryFacade::show($category);
    }

    public function store(CategoryRequest $request)
    {
        return CategoryFacade::store($request);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        return CategoryFacade::update($request, $category);
    }

    public function destroy(Category $category)
    {
        return CategoryFacade::destroy($category);
    }
}
