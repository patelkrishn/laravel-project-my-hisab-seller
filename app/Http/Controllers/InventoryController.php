<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class InventoryController extends Controller
{
    private $products;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response =Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.Cookie::get('access_token'),
        ])->get(env('API_URL')."/product", [
            
        ]);
        $this->products=json_decode($response,true);
        // dd($products);
        return view('inventories.all_invetories')->with('products',$this->products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response =Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.Cookie::get('access_token'),
        ])->get(env('API_URL')."/inventory/list/".$id, [
            
        ]);
        $inventories=json_decode($response,true);

        $responseProduct =Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.Cookie::get('access_token'),
        ])->get(env('API_URL')."/product/".$id, [
            
        ]);
        $product=json_decode($responseProduct,true);
        // dd($product);
        if($inventories!= NULL)
        {
            if(request()->ajax())
                {
                        return datatables()->of($inventories)
                                ->addColumn('create_date', function($data){
                                    return Carbon::parse($data['created_at'])->setTimezone('Asia/Kolkata')->format('d-m-Y H:i');
                                })
                                ->addColumn('update_inventory', function($data){
                                    return '<button type="button" name="edit" id="'.$data['id'].'" class="update btn btn-primary btn-sm">Update Inventory</button>';
                                })
                                ->addColumn('delete', function($data){
                                    return '<button type="button" name="delete" id="'.$data['id'].'" class="delete btn btn-danger btn-sm">Delete</button>';
                                })
                                ->rawColumns(['create_date','update_inventory','delete'])
                                ->make(true);
                }
                // dd($product);
            return view('inventories.all_invetories')->with(['product_id'=>$id,'product_name'=>$product['product']['product_name']]);
        }else{
            if(request()->ajax())
            {
                    return datatables()->of($inventories)
                            ->make(true);
            }
            return view('inventories.all_invetories')->with(['product_id'=>$id,'product_name'=>$product['product']['product_name']]);
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
