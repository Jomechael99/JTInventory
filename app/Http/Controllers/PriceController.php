<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PriceController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $clientInfo = DB::table('client')
            ->where('CLIENTID', $id)
            ->get();

        $readonly = "readonly=true";

        $product = DB::table('products')
            ->get();

        $prodSize = DB::table('products')
            ->join('product_size', 'products.PROD_CODE' , '=' , 'product_size.PROD_CODE')
            ->select('SIZES')
            ->distinct('SIZES')
            ->get();

        $prodList = DB::table('product_list')
                    ->where('CLIENTID', $id)
                    ->get();

        return view('pricelist.addpricelist')
            ->with('clientInfo', $clientInfo)
            ->with('readonly', $readonly)
            ->with('product', $product)
            ->with('prodSize', $prodSize)
            ->with('clientID', $id)
            ->with('prodList', $prodList);

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

        try{
            $clientid = $request -> clientID;
            $prodCode = $request -> productCode;
            $prodName = $request -> prodName;
            $prodSize = $request -> prodSize;
            $prodPrice = $request -> prodPrice;
            $prodDate = $request -> PriceDate;
            $prodPrice = floatval(str_replace(",", "", $prodPrice));

            $existingData = DB::table('product_list')
                ->where('CLIENTID', $clientid)
                ->where('PROD_CODE', $prodCode)
                ->where('PRODUCT', $prodName)
                ->where('SIZE', $prodSize)
                ->where('PRODUCT_PRICE', $prodPrice)
                ->where('PRICE_DATE', $prodDate)
                ->get();

            if(count($existingData) > 0){
                return Response()->json(['status' => 'Exising Product Pricelist']);
            }else{
                $clientProduct = DB::table('product_list')->insert([
                    [
                        'CLIENTID' => $clientid,
                        'PROD_CODE' => $prodCode,
                        'PRODUCT' => $prodName,
                        'SIZE' => $prodSize,
                        'PRODUCT_PRICE' => $prodPrice,
                        'PRICE_DATE' => $prodDate
                    ]
                ]);

                if($clientProduct == "TRUE"){
                    return Response()->json(['status' => 'true']);
                }else{
                    return Response()->json(['status' => 'Error on inserting data']);
                }
            }
        }catch(\Exception $e){
            return Response()->json(['status' => $e]);
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
