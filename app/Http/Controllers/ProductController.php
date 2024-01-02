<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response($products);
    }

    public function show(Product $product)
    {
        return response($product);
    }
    
    public function store(Request $request)
    {
        $request->validate(['name' => ['required']]);
        return $product = Product::create($request->all());
        // return response($list, Response::HTTP_CREATED);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response('',RESPONSE::HTTP_NO_CONTENT);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate(['name' => ['required']]);
        $product->update($request->all());
        return response($product);
    }
}
