<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvisionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(session()->has('user')){
            $OR = db::table('provisional_receipt')
                ->join('client', 'provisional_receipt.CLIENT_ID', '=', 'client.CLIENTID')
                ->get();

            return view('SalesRecord.ProvisionalReceipt.viewprovisional');
        }else{
            return view('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $client = db::table('client')
            ->get();

        return view('SalesRecord.ProvisionalReceipt.addprovisional')
            ->with('data', $client);
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

        $or_data = array([
            'PR_NO' => $request->orNo,
            'PR_DATE' => $request->cylinderDate,
            'RECEIVED_FROM' => $request-> issuedBy,
            'CLIENT_ID' => $request->customer,
            'SALESREPID' => $request -> issuedBy,
            'PAYMENT_TYPE' => $request->cashType,
            'TOTAL' => str_replace( ',', '', $request->grossSales),
            'CHECK_NO' => $request->Checkno,
            'CHECK_DATE' =>$request->checkDate,
            'BANK' =>$request->Bank,
            'STATUS' => 1,
            'OR_TYPE'=>$request->radioType,
            'CREDITABLE'=> $request->creditable,
            'REMARKS'=>$request->Remarks,
            'PAY_MODE' =>$request->PaymentType
        ]);

        db::table('provisional_receipt')
            ->insert($or_data);

        $payment_type = $request->PaymentType;

        if($payment_type == 1){ // Partial Payment

            for($i = 0; $i < count($request->reportNo); $i++){
                $partial_payment = array([
                    'PR_NO'=> $request->orNo,
                    'DR_NO'=> $request->reportNo[$i],
                    'DUE_AMOUNT'=>str_replace( ',', '',$request->grossSales),
                    'PAID_AMOUNT'=>str_replace( ',', '',$request->amountPaid),
                    'BALANCE'=>str_replace( ',', '',$request->remBalance),
                    'STATUS'=>0,
                ]);

                db::table('provisional_receipt_partial_payment')
                    ->insert($partial_payment);
            }



        }elseif($payment_type == 2){ // Over Payment

            for($i = 0; $i < count($request->reportNo); $i++) {

                $over_payment = array([
                    'PR_NO' => $request->orNo,
                    'DR_NO' => $request->reportNo[$i],
                    'DUE_AMOUNT' => str_replace( ',', '',$request->grossSales),
                    'PAID_AMOUNT' => str_replace( ',', '',$request->amountPaid),
                    'BALANCE' => str_replace( ',', '',$request->remBalance),
                    'STATUS' => 0
                ]);

                db::table('provisional_receipt_over_payment')
                    ->insert($over_payment);
            }

        }elseif($payment_type == 0){
            for($i = 0; $i < count($request->reportNo); $i++) {
                $paid_data = array([
                    'PR_NO' => $request->orNo,
                    'DR_DATE' => $request->reportDate[$i],
                    'DR_NO' => $request->reportNo[$i],
                    'AMOUNT' => str_replace( ',', '',$request->reportAmount[$i]),
                ]);

                db::table('provisional_receipt_paid')
                    ->insert($paid_data);



                if ($request->reportType[$i] == "DR") {
                    $update_sales_invoice = db::table('delivery_receipt')
                        ->where('DR_NO', $request->reportNo[$i])
                        ->update(['FULLY_PAID' => '1']);
                }
            }

        }

        $or_double_payment = array([
            'PR_NO' => $request->orNo,
            'DR_No' => $request->doublePaymentNo,
            'AMOUNT' => str_replace( ',', '',$request->doublePaymentAmt)
        ]);

        if($request->doublePaymentNo == "" || $request->doublePaymentAmt == ''){

        }else{
            db::table('provisional_receipt_double_paid')
                ->insert($or_double_payment);
        }


        return response()->json(array('status' => 'success'));
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
        $client = db::table('client')
            ->get();

        $data = db::table('provisional_receipt as a')
            ->select('*' ,'a.ID')
            ->where('a.ID', $id)
            ->get();

        if($data->isEmpty()){
            $data = db::table('provisional_receipt as a')
                ->select('*' ,'a.ID')
                ->where('a.ID', $id)
                ->get();
        }

        $or = 0;

        foreach($data as $row){
            $or = $row -> PR_NO;
        }

        $data_product = db::table('provisional_receipt_paid')
            ->where('PR_NO', $or)
            ->get();

        $edit_status = 1;

        return view('SalesRecord.ProvisionalReceipt.editprovisional')
            ->with('data', $client)
            ->with('or_list', $data_product)
            ->with('or', $data)
            ->with('status', $edit_status);
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
