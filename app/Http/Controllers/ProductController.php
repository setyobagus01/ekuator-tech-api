<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ApiResource('success', 200, null, Product::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $product = Product::create($request->all());
            DB::commit();
            return new ApiResource('success', 200, 'Product is created', $product);
        } catch (\Throwable $e) {
            return new ApiResource('error', 500, $e->getMessage(), null);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ApiResource('success', 200, null, Product::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $product = Product::find($id);
            $product->update($request->all());
            DB::commit();
            return new ApiResource('success', 200, 'Product is updated', $product);
        } catch (\Throwable $e) {
            return new ApiResource('error', 500, $e->getMessage(), $product);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::find($id);
            $product->delete();
            return new ApiResource('success', 204, "Product deleted", null);
        } catch (\Throwable $e) {
            return new ApiResource('error', 500, $e->getMessage(), null);
        }
    }
}
