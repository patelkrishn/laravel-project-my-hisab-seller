<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('apiToken');
        
    }
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
        $products=json_decode($response,true);
        if($products!= NULL)
        {
            if(request()->ajax())
                {
                        return datatables()->of($products)
                                ->addColumn('action', function($data){
                                    $button = '<button type="button" name="edit" id="'.$data['id'].'" class="show btn btn-primary btn-sm">Show</button>';
                                    $button .= '&nbsp;&nbsp;';
                                    $button .= '<button type="button" name="delete" id="'.$data['id'].'" class="delete btn btn-danger btn-sm">Delete</button>';
                                    return $button;
                                })
                                ->rawColumns(['action'])
                                ->make(true);
                }
            return view('products.all_products');
        }else{
            if(request()->ajax())
            {
                    return datatables()->of($products)
                            ->make(true);
            }
            return view('products.all_products');
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $response =Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.Cookie::get('access_token'),
        ])->get(env('API_URL')."/product/".$id, [
            
        ]);
        $products=json_decode($response,true); 
    }
}
