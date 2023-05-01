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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $store = Store::paginate(2);
        return new StorePagination($store);
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
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $store = Store::find($id);
        return new StoreDetailCollection($store);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
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
