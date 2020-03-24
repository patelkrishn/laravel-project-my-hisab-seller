<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function products()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $response =Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.Cookie::get('access_token'),
        ])->get(env('API_URL')."/product", [
            
        ]);
        $products=json_decode($response,true);

        $invoices_response =Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.Cookie::get('access_token'),
        ])->get(env('API_URL')."/invoices", [
            
        ]);
        $invoices=json_decode($invoices_response,true);
        // dd($invoices);
        if($invoices!= NULL)
        {
            // dd($invoices);
            if(request()->ajax())
                {
                        return datatables()->of($invoices)
                                ->addColumn('update_invoice', function($data){
                                    // dd($data);
                                    return '<button type="button" name="edit" id="'.$data['id'].'" class="update btn btn-primary btn-sm">Update Item</button>';
                                })
                                ->addColumn('delete', function($data){
                                    return '<button type="button" name="delete" id="'.$data['id'].'" class="delete btn btn-danger btn-sm">Delete</button>';
                                })
                                ->rawColumns(['update_invoice','delete'])
                                ->make(true);
                }
                // dd($product);
            return view('invoices.create_invoices')->with(['products'=>$products]);
        }else{
            if(request()->ajax())
            {
                    return datatables()->of($invoices)
                            ->make(true);
            }
            return view('invoices.create_invoices')->with(['products'=>$products]);
        }
        return view('invoices.create_invoices')->with(['products'=>$products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product_response =Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.Cookie::get('access_token'),
        ])->get(env('API_URL')."/product", [
            
        ]);
        $products=json_decode($product_response,true);

        $response =Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.Cookie::get('access_token'),
        ])->post(env('API_URL')."/invoices", [
                        "product_id"=> $request->product_id,
                        "invoice_quantity"=> $request->product_quantity,
                        "product_price"=> $request->product_price,
                        "total_amount"=>$request->total_amount,
        ]);
        $invoice=json_decode($response,true);
        return redirect('invoices/create')->with(['success'=>$invoice['message']]);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
