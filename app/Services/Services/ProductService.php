<?php
namespace App\Services\Services;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Constructors\ProductConstructor;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductService implements ProductConstructor
{

    public function index() : AnonymousResourceCollection
    {
        return ProductResource::collection(
            Product::paginate(10)
        );
    }

    public function show(Product $product) : ProductResource
    {
        return ProductResource::make($product);
    }
    
    public function store(ProductRequest $request) : ProductResource
    {
        $validatedData = $request->validated();
    
        if (isset($validatedData['image'])) {
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        }
        
        return ProductResource::make(
            Product::create($validatedData)
        );
    }
    
    public function update(ProductRequest $request, Product $product) : ProductResource
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        } else {
            $validatedData['image'] = $product->image;
        }

        $product->update($validatedData);
        
        return ProductResource::make($product->refresh());
}

    
    public function destroy(Product $product) : bool
    {
        return $product->delete();
    }
}