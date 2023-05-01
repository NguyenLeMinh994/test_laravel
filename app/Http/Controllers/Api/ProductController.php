<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductDetailCollection;
use App\Http\Resources\ProductPagination;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(2);
        return new ProductPagination($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $product = new Product();
            $product->name = $request->name;
            $product->store_id = $request->store_id;
            $product->price = $request->price;
            $product->description = $request->description;
            if($product->save()){
                return response()->json(['status'=>'success','message'=>'Product created successful']);
            }

            return response()->json(['status'=>'error','message'=>'Product created fail']);
        } catch (\Exception $ex) {
            return response()->json(['status'=>'error','message'=>$ex->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return new ProductDetailCollection($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->store_id = $request->store_id;
            $product->price = $request->price;
            $product->description = $request->description;
            if($product->save()){
                return response()->json(['status'=>'success','message'=>'Product update successful']);
            }
            return response()->json(['status'=>'error','message'=>'Product update failed']);

        } catch (\Exception $ex) {
            return response()->json(['status'=>'error','message'=>$ex->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            if($product->delete()){
                return response()->json(['status'=>'success','message'=>'Product delete successful']);
            }
        return response()->json(['status'=>'error','message'=>'Product delete failed']);

        } catch (\Exception $ex) {

            return response()->json(['status'=>'error','message'=>$ex->getMessage()]);
        }
    }
}
