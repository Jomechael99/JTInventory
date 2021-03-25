<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $clientType = DB::table('client_type')->get();

        $product = DB::table('products')
            ->get();

        $prodSize = DB::table('products')
            ->join('product_size', 'products.PROD_CODE' , '=' , 'product_size.PROD_CODE')
            ->select('SIZES')
            ->distinct('SIZES')
            ->get();


        return view('customer.addcustomer' , [
            'clientType' => $clientType,
            'product' => $product,
            'prodSize' => $prodSize]);



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try{
            

            $existing_name = db::table('client')
                ->where('NAME', 'like', '%'.$request->input("custName").'%')
                ->get();

            if(count($existing_name) > 0){

                $message = "Existing name of Customer , Please input another";
                return response()->json(array('status' => $message));

            }else{
                $clientCode = DB::table('client')->max('CLIENT_CODE');
                            $clientCode = $clientCode + 1;

                            if(strlen($clientCode) == 1){
                                $cCode = "000" . strval($clientCode);
                            }elseif(strlen($clientCode) == 2){
                                $cCode = "00" . strval($clientCode);
                            }elseif(strlen($clientCode) == 3){
                                $cCode = "0" . strval($clientCode);
                            }else{
                                $cCode = $clientCode;
                            }

                            $custName = $request->input("custName");
                            $address = $request->input("Address");
                            $city = $request->input("City");
                            $custType = $request->input("custType");
                            $custSince = $request->input("custSince");
                            $tinNo = $request->input("tinNo");
                            $contPerson = $request->input("contPerson");
                            $Designation = $request->input("Designation");
                            $telNo = $request->input("telNo");
                            $contNo = $request->input("contNo");
                            $emailAdd = $request->input("emailAddress");
                            $cashPay = $request->input("cashPay");
                            $orCopy = $request->input("orCopy");


                            $client = DB::table("client")->insertGetId(
                                [
                                    'NAME' => $custName,
                                    'TYPE' => $custType,
                                    'DTI_NO' => $tinNo,
                                    'ADDRESS' => $address,
                                    'CITY_MUN' => $city,
                                    'CON_PERSON' => $contPerson,
                                    'DESIGNATION' => $Designation,
                                    'TEL_NO' => $telNo,
                                    'CELL_NO' => $contNo,
                                    'EMAIL_ADDR' => $emailAdd,
                                    'CLIENT_DATE' => $custSince,
                                    'CLIENT_CODE' => $cCode,
                                    'PAYMENT_TYPE' => $cashPay,
                                    'ORCOPY' => $orCopy
                                ]
                            );



                            if($request->productCode == null){

                            }else{


                                for($i = 0 ; $i < count($request -> productCode) ; $i++){


                                    $clientProduct = DB::table('product_list')->insert([
                                        [
                                            'CLIENTID' => $client,
                                            'PROD_CODE' => $request -> productCode[$i],
                                            'PRODUCT' => $request -> prodName[$i],
                                            'SIZE' => $request -> productSize[$i],
                                            'PRODUCT_PRICE' => floatval(str_replace(",", "", $request -> prodPrice[$i])),
                                            'PRICE_DATE' => $request -> PriceDate[$i]
                                        ]
                                    ]);
                                }

                            }

                return response()->json(array('status' => "success"));
            }


        }catch(\Exception $e){
            return response()->json(array('status' => $e));
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
	    $client = DB::table('client')
		        ->where("CLIENTID", "=" , $id)
		        ->get();
	    $clientType = DB::table('client_type')->get();



	    return view('customer.editcustomer')
		        ->with('client', $client)
	            ->with('clientType', $clientType);

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

        $custName = $request->input("custName");
        $address = $request->input("Address");
        $city = $request->input("City");
        $custType = $request->input("custType");
        $custSince = $request->input("custSince");
        $tinNo = $request->input("tinNo");
        $contPerson = $request->input("contPerson");
        $Designation = $request->input("Designation");
        $telNo = $request->input("telNo");
        $contNo = $request->input("contNo");
        $emailAdd = $request->input("emailAddress");
        $cashPay = $request->input("cashPay");
        $orCopy = $request->input("orCopy");

        $clientUpdate = DB::table('client')
                        ->where('CLIENTID' , $id)
                        ->update([
                            'NAME' => $custName,
                            'TYPE' => $custType,
                            'DTI_NO' => $tinNo,
                            'ADDRESS' => $address,
                            'CITY_MUN' => $city,
                            'CON_PERSON' => $contPerson,
                            'DESIGNATION' => $Designation,
                            'TEL_NO' => $telNo,
                            'CELL_NO' => $contNo,
                            'EMAIL_ADDR' => $emailAdd,
                            'CLIENT_DATE' => $custSince,
                            'PAYMENT_TYPE' => $cashPay,
                            'ORCOPY' => $orCopy
                        ]);

        if($clientUpdate == true){
//            $request->session()->flash('statusUpdate', 'True');
            return redirect('Customer');
        }else{
//            $request->session()->flash('status', 'False');
            return redirect('CustomerController/show', $id);
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
        //
    }
}
