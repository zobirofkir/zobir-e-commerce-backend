<?php

namespace App\Services\Services;

use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Services\Constructors\BrandConstructor;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BrandService implements BrandConstructor
{
    public function index() : AnonymousResourceCollection
    {
        return BrandResource::collection(
            Brand::paginate(10)
        );
    }

    public function show(Brand $brand) : BrandResource
    {
        return BrandResource::make($brand);
    }

    public function store(BrandRequest $request) : BrandResource
    {
        return BrandResource::make(
            Brand::create($request->validated())
        );
    }

    public function update(Brand $brand, BrandRequest $request) : BrandResource
    {
        $brand->update($request->validated());
        return BrandResource::make(
            $brand->refresh()
        );
    }

    public function destroy(Brand $brand) : bool
    {
        return $brand->delete();
    }
}