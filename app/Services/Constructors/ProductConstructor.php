<?php
namespace App\Services\Constructors;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface ProductConstructor
{
    public function index() : AnonymousResourceCollection;

    public function show(Product $product) : ProductResource;

    public function store(ProductRequest $request) : ProductResource;

    public function update(ProductRequest $request, Product $product) : ProductResource;
    
    public function destroy(Product $product) : bool;
}