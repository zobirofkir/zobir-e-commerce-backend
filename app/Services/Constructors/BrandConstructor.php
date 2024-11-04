<?php
namespace App\Services\Constructors;

use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface BrandConstructor
{
    public function index() : AnonymousResourceCollection;

    public function show(Brand $brand) : BrandResource;

    public function store(BrandRequest $request) : BrandResource;

    public function update(Brand $brand, BrandRequest $request) : BrandResource;

    public function destroy(Brand $brand) : bool;
}