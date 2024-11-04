<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Services\Facades\BrandFacade;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BrandController extends Controller
{
    public function index() : AnonymousResourceCollection
    {
        return BrandFacade::index();
    }


    public function show (Brand $brand) : BrandResource
    {
        return BrandFacade::show($brand);
    }

    public function store( BrandRequest $request ) : BrandResource
    {
        return BrandFacade::store($request);
    }


    public function update(Brand $brand, BrandRequest $request) : BrandResource
    {
        return BrandFacade::update($brand, $request);
    }


    public function destroy(Brand $brand) : BrandResource
    {
        return BrandFacade::destroy($brand);
    }
}
