<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailCollection;
use App\Http\Resources\ProductPagination;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/products",
     *      operationId="index",
     *      tags={"Products"},
     *      summary="Get list of products",
     *      description="Returns list of products",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          required=false,
     *          name="q",
     *          in="query",
     *          description="search",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful product",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index(Request $request)
    {
        $products = [];
        if($request->has('q') && !empty($request->q)){
            $products = Product::where('name','LIKE',"%{$request->q}%")->paginate();
        }else{
            $products = Product::paginate();
        }

        return new ProductPagination($products);
    }

     /**
     * @OA\POST(
     *      path="/api/products",
     *      operationId="Store",
     *      tags={"Products"},
     *      summary="Create product",
     *      description="Create product",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                   type="object",
     *                   @OA\Property(property="store_id",type="text",example="1"),
     *                   @OA\Property(property="name",type="text",example="Product A"),
     *                   @OA\Property(property="description",type="text",example="Product A"),
     *                   @OA\Property(property="price",type="text",example="15.00"),
     *                   @OA\Property(property="quantity",type="text",example="20"),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful product",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
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
     * @OA\Get(
     *      path="/products/{id}",
     *      operationId="show",
     *      tags={"Products"},
     *      summary="Get product information",
     *      description="Returns product data",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show($id)
    {
        $product = Product::find($id);
        return new ProductDetailCollection($product);
    }

    /**
     * @OA\Put(
     *      path="/products/{id}",
     *      operationId="update",
     *      tags={"Products"},
     *      summary="Update existing product",
     *      description="Returns updated product data",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                   type="object",
     *                   @OA\Property(property="store_id",type="text",example="1"),
     *                   @OA\Property(property="name",type="text",example="Product A"),
     *                   @OA\Property(property="description",type="text",example="Product A"),
     *                   @OA\Property(property="price",type="text",example="15.00"),
     *                   @OA\Property(property="quantity",type="text",example="20"),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
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
     * @OA\Delete(
     *      path="/products/{id}",
     *      operationId="destroy",
     *      tags={"Products"},
     *      summary="Delete existing product",
     *      description="Deletes a record",
     *      @OA\Parameter(
     *          name="id",
     *          description="Product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
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
