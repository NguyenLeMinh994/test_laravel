<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreDetailCollection;
use App\Http\Resources\StorePagination;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/stores",
     *      operationId="indexStore",
     *      tags={"Stores"},
     *      summary="Get list of stores",
     *      description="Returns list of stores",
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
        $store = [];
        if($request->has('q') && !empty($request->q)){
            $store = Store::where('name','LIKE',"%{$request->q}%")->paginate();
        }else{
            $store = Store::paginate();
        }

        return new StorePagination($store);
    }

     /**
     * @OA\POST(
     *      path="/api/stores",
     *      operationId="storeStore",
     *      tags={"Stores"},
     *      summary="Create Store",
     *      description="Create Store",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                   type="object",
     *                   @OA\Property(property="user_id",type="text",example="1"),
     *                   @OA\Property(property="name",type="text",example="Store A"),
     *                   @OA\Property(property="description",type="text",example="Store A"),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful store",
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
            $store = new Store();
            $store->name = $request->name;
            $store->user_id = $request->user_id;
            $store->description = $request->description;
            if($store->save()){
                return response()->json(['status'=>'success','message'=>'Store created successful']);
            }

            return response()->json(['status'=>'error','message'=>'Store created fail']);
        } catch (\Exception $ex) {
            return response()->json(['status'=>'error','message'=>$ex->getMessage()]);
        }
    }

   /**
     * @OA\Get(
     *      path="/stores/{id}",
     *      operationId="showStore",
     *      tags={"Stores"},
     *      summary="Get store information",
     *      description="Returns store data",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="store id",
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
        $store = Store::find($id);
        return new StoreDetailCollection($store);
    }

   /**
     * @OA\Put(
     *      path="/stores/{id}",
     *      operationId="updateStore",
     *      tags={"Stores"},
     *      summary="Update existing product",
     *      description="Returns updated product data",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Store id",
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
     *                   @OA\Property(property="user_id",type="text",example="1"),
     *                   @OA\Property(property="name",type="text",example="Store A"),
     *                   @OA\Property(property="description",type="text",example="Store A"),
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
    public function update(Request $request,$id)
    {
        try {
            $store = Store::findOrFail($id);
            $store->name = $request->name;
            $store->user_id = $request->user_id;
            $store->description = $request->description;
            if($store->save()){
                return response()->json(['status'=>'success','message'=>'Store update successful']);
            }
            return response()->json(['status'=>'error','message'=>'Store update failed']);

        } catch (\Exception $ex) {
            return response()->json(['status'=>'error','message'=>$ex->getMessage()]);
        }
    }

    /**
     * @OA\Delete(
     *      path="/stores/{id}",
     *      operationId="destroyStore",
     *      tags={"Stores"},
     *      summary="Delete existing store",
     *      description="Deletes a record",
     *      @OA\Parameter(
     *          name="id",
     *          description="Store id",
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
            $store = Store::findOrFail($id);
            if($store->delete()){
                return response()->json(['status'=>'success','message'=>'Store delete successful']);
            }
        return response()->json(['status'=>'error','message'=>'Store delete failed']);

        } catch (\Exception $ex) {

            return response()->json(['status'=>'error','message'=>$ex->getMessage()]);
        }
    }
}
