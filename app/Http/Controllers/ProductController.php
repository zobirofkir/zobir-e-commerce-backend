<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Facades\ProductFacade;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index() : AnonymousResourceCollection
    {
        return ProductFacade::index();
    }

    public function show(Product $product) : ProductResource
    {
        return ProductFacade::show($product);
    }

    public function store(ProductRequest $request) : ProductResource
    {
        return ProductFacade::store($request);
    }

    public function update(ProductRequest $request, Product $product) : ProductResource
    {
        return ProductFacade::update($request, $product);
    }
    
    public function destroy(Product $product) : bool
    {
        return ProductFacade::destroy($product);
    }
}
