<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Reference;
use Svg\Tag\Rect;
use Yajra\DataTables\Facades\DataTables;

class JqueryController extends Controller
{
    //
    public function prodCodeToSize(Request $request){

      $prodCode = $request -> prodcode;
      $html = '';

      $prodSize = DB::table('product_size')
                    ->where('PROD_CODE', $prodCode)
                    ->get();

        foreach ($prodSize as $prodSize) {
            if($prodSize->SIZES == ''){

            }else {
                $html .= '<option value="' . $prodSize->SIZES . '">' . $prodSize->SIZES . '</option>';
            }
        }
      return response()->json([$html]);
    }

    public function getProductSize2(Request $request){
            $prodCode = $request -> prodcode;
            $html = '';

             $prodSize = DB::table('client')
                 ->join('product_list', 'client.CLIENTID', '=', 'product_list.CLIENTID')
                 ->where('PROD_CODE', $prodCode)
                 ->select('SIZE')
                 ->get();

            foreach ($prodSize as $prodSize) {
                if($prodSize->SIZE == ''){

                }else {
                    $data = $prodSize -> SIZE;
                }
            }

            return $data;
    }

    public function updateProductPrice(Request $request){

        $id = $request -> id;
        $price = $request -> price;

        $price = floatval(str_replace(",", "", $price));

        $updatePrice = DB::table('product_list')
                        ->where('id', $id)
                        ->update(['PRODUCT_PRICE' => $price]);

        if($updatePrice == "1"){
		  return Response()->json(['updateStatus' => 'true']);
        }elseif($updatePrice == "0"){
		  return Response()->json(['updateStatus' => 'false']);
        }


    }

    public function getProductPO(Request $request){
        $clientCode = $request -> prodcode;
        $html = '';
        $html2 = '';

        $prodSize = DB::table('product_list')
            ->groupBy('PROD_CODE')
            ->where('CLIENTID', $clientCode)
            ->get();

        foreach ($prodSize as $prodSize) {
            if($prodSize->PROD_CODE == ''){

            }else {
                $html .= '<option value="' . $prodSize->PROD_CODE . '">' . $prodSize->PRODUCT . '</option>';

            }
        }
        return response()->json(array('html' => $html));
    }

    public function getProductSizePO(Request $request){
        $clientCode = $request -> prodcode;
        $id = $request -> id;



        $html = '';
        $html2 = '';

        $prodSize = DB::table('product_list')
            ->where('CLIENTID', $id)
            ->where('PROD_CODE', $clientCode)
            ->get();

        foreach ($prodSize as $prodSize) {
            if($prodSize->SIZE == ''){

            }else {
                $html .= '<option value="' . $prodSize->SIZE . '">' . $prodSize->SIZE . '</option>';
            }
        }
        return response()->json(array('html' => $html));
    }
    // Sales Invoice
    public function noValidate(Request $request)
    {
        $buttonVal = $request->buttonVal;
        $invoiceNo = $request->invoiceNo;

        if ($buttonVal == "invoice") { // Invoice

            $si_assigned = db::table('si_assigned')
                ->join('sales_rep', 'sales_rep.ID', '=', 'si_assigned.SALESREP_ID')
                ->where('FROM_OR_NO', '<=', $invoiceNo)
                ->where('TO_OR_NO', '>=', $invoiceNo)
                ->get();

            $issuedBy = '';

            foreach ($si_assigned as $issuerName) {
                $issuedBy = $issuerName->ASSIGNED_BY;
                $issuerID = $issuerName->SALESREP_ID;
            }

            if ($si_assigned->isEmpty() == false) {

                $si_report = db::table('si_assigned_report')
                    ->where('INVOICE_NO', $invoiceNo)
                    ->where(function ($query) {
                        $query->where('REMARKS', '=', 'DONE')
                            ->orWhere('REMARKS', '=', 'CANCELLED')
                            ->orWhere('REMARKS', '=', 'NO RECORD FOUND');
                    })
                    ->get();
                $si_report2 = db::table('sales_invoice')
                    ->where('INVOICE_NO', $invoiceNo)
                    ->get();

                if ($si_report->isEmpty() == true && $si_report2->isEmpty() == true) {
                    return response()->json(array('issuedBy' => $issuedBy, 'issuerID' => $issuerID , 'status' => "active"));
                }else if($si_report2->isEmpty() == false){
                    return response()->json(array(['status' => "DONE"]));
                }
                else {
                    foreach ($si_report as $remarks) {
                        return response()->json(array(['status' => $remarks]));
                    }

                }

            } else {
                return Response()->json(['status' => 'empty']);
            }

        } elseif ($buttonVal == "icr") { // For Button Recognitions
            $assigned = db::table('icr_assigned')
                ->join('sales_rep', 'sales_rep.ID', '=', 'icr_assigned.SALESREP_ID')
                ->where('FROM_NO', '<=', $invoiceNo)
                ->where('TO_NO', '>=', $invoiceNo)
                ->get();

            $issuedBy = '';

            foreach ($assigned as $issuerName) {
                $issuedBy = $issuerName->ASSIGNED_BY;
                $issuerID = $issuerName->SALESREP_ID;
            }

            if ($assigned->isEmpty() == false) {

                $report = db::table('icr_assigned_report')
                    ->where('ICR_NO', $invoiceNo)
                    ->where(function ($query) {
                        $query->where('REMARKS', '=', 'DONE')
                            ->orWhere('REMARKS', '=', 'CANCELLED')
                            ->orWhere('REMARKS', '=', 'NO RECORD FOUND');
                    })
                    ->get();

                $report2 = db::table('cylinder_receipt')
                    ->where('ICR_NO', $invoiceNo)
                    ->get();

                if ($report->isEmpty() == true && $report2->isEmpty() == true) {
                    return response()->json(array('issuedBy' => $issuedBy, 'issuerID' => $issuerID , 'status' => "active"));
                } else if($report2->isEmpty() == false){
                    return response()->json(array(['status' => "DONE"]));
                }else {
                    foreach ($report as $remarks) {
                        return response()->json(array(['status' => $remarks->REMARKS]));
                    }

                }
            }else{
                return Response()->json(['status' => 'empty']);
             }

        }elseif ($buttonVal == "clc") { // For Button Recognitions
            $assigned = db::table('clc_assigned')
                ->join('sales_rep', 'sales_rep.ID', '=', 'clc_assigned.SALESREP_ID')
                ->where('FROM_NO', '<=', $invoiceNo)
                ->where('TO_NO', '>=', $invoiceNo)
                ->get();

            $issuedBy = '';

            foreach ($assigned as $issuerName) {
                $issuedBy = $issuerName->ASSIGNED_BY;
                $issuerID = $issuerName->SALESREP_ID;
            }


            if ($assigned->isEmpty() == false) {

                $report = db::table('clc_assigned_report')
                    ->where('CLC_NO', $invoiceNo)
                    ->where(function ($query) {
                        $query->where('REMARKS', '=', 'DONE')
                            ->orWhere('REMARKS', '=', 'CANCELLED')
                            ->orWhere('REMARKS', '=', 'NO RECORD FOUND');
                    })
                    ->get();

                $report2 = db::table('cylinder_loan_contract')
                    ->where('CLC_NO', $invoiceNo)
                    ->get();

                if ($report->isEmpty() == true  && $report2->isEmpty() == true) {
                    return response()->json(array('issuedBy' => $issuedBy, 'issuerID' => $issuerID , 'status' => "active"));
                } else if($report2->isEmpty() == false){
                    return response()->json(array(['status' => "DONE"]));
                } else {
                    foreach ($report as $remarks) {
                        return response()->json(array(['status' => $remarks->REMARKS]));
                    }

                }
            }else{
                return Response()->json(['status' => 'empty']);
            }

        }elseif ($buttonVal == "DR"){
            $assigned = db::table('dr_assigned')
                ->join('sales_rep', 'sales_rep.ID', '=', 'dr_assigned.SALESREP_ID')
                ->where('FROM_NO', '<=', $invoiceNo)
                ->where('TO_NO', '>=', $invoiceNo)
                ->get();

            $issuedBy = '';

            foreach ($assigned as $issuerName) {
                $issuedBy = $issuerName->ASSIGNED_BY;
                $issuerID = $issuerName->SALESREP_ID;
            }


            if ($assigned->isEmpty() == false) {

                $report = db::table('dr_assigned_report')
                    ->where('DR_NO', $invoiceNo)
                    ->where(function ($query) {
                        $query->where('REMARKS', '=', 'DONE')
                            ->orWhere('REMARKS', '=', 'CANCELLED')
                            ->orWhere('REMARKS', '=', 'NO RECORD FOUND');
                    })
                    ->get();

                $report2 = db::table('delivery_receipt')
                    ->where('DR_NO', $invoiceNo)
                    ->get();

                if ($report->isEmpty() == true && $report2->isEmpty() == true) {
                    return response()->json(array('issuedBy' => $issuedBy, 'issuerID' => $issuerID , 'status' => "active"));
                } else if($report2->isEmpty() == false){
                    return response()->json(array(['status' => "DONE"]));
                } else {
                    foreach ($report as $remarks) {
                        return response()->json(array(['status' => $remarks->REMARKS]));
                    }

                }
            }else{
                return Response()->json(['status' => 'empty']);
            }
        }elseif($buttonVal == "OR"){
            $assigned = db::table('or_assigned')
                ->join('sales_rep', 'sales_rep.ID', '=', 'or_assigned.SALESREP_ID')
                ->where('FROM_OR_NO', '<=', $invoiceNo)
                ->where('TO_OR_NO', '>=', $invoiceNo)
                ->get();


            $issuedBy = '';

            foreach ($assigned as $issuerName) {
                $issuedBy = $issuerName->ASSIGNED_BY;
                $issuerID = $issuerName->SALESREP_ID;
            }


            if ($assigned->isEmpty() == false) {

                $report = db::table('or_assigned_report')
                    ->where('OR_NO', $invoiceNo)
                    ->where(function ($query) {
                        $query->where('REMARKS', '=', 'DONE')
                            ->orWhere('REMARKS', '=', 'CANCELLED')
                            ->orWhere('REMARKS', '=', 'NO RECORD FOUND');
                    })
                    ->get();

                $report2 = db::table('official_receipt')
                    ->where('OR_NO', $invoiceNo)
                    ->get();

                if ($report->isEmpty() == true && $report2->isEmpty() == true) {
                    return response()->json(array('issuedBy' => $issuedBy, 'issuerID' => $issuerID , 'status' => "active"));
                } else if($report2->isEmpty() == false){
                    return response()->json(array(['status' => "DONE"]));
                } else {
                    foreach ($report as $remarks) {
                        return response()->json(array(['status' => $remarks->REMARKS]));
                    }

                }
            }else{
                return Response()->json(['status' => 'empty']);
            }
        }elseif($buttonVal == "PR"){


            $report2 = db::table('provisional_receipt')
                ->where('PR_NO', $invoiceNo)
                ->get();

            if ($report2->isEmpty() == true ) {
                    return response()->json(array('status' => "active"));
                } else if($report2->isEmpty() == false){
                    return response()->json(array(['status' => "DONE"]));
                }
            }else{
                return Response()->json(['status' => 'empty']);
            }
    }

    // Add Sales Invoice Customer Details
    public function poCustomerDetails(Request $request){
       $cust_id = $request-> cust_id;
       $price_date = $request-> price_date;
       $html  = '';
       $html2 = '';
       $date = '';
       $product = '';
       $amount = '';

       $cust_details = db::table('client')
           ->where('CLIENTID', $cust_id)
           ->get();

       $poProducts = db::table('product_list')
           ->select('*', 'product_list.ID as PROD_ID')
           ->join('products', 'products.PROD_CODE' , '=' , 'product_list.PRODUCT')
           ->where('PRICE_DATE', $price_date)
           ->where('CLIENTID', $cust_id)
           ->get();

       if($poProducts -> isEmpty()){
           $poProducts = db::table('product_list')
               ->select('*', 'product_list.ID as PROD_ID')
               ->join('products', 'products.PRODUCT' , '=' , 'product_list.PRODUCT')
               ->where('PRICE_DATE', $price_date)
               ->where('CLIENTID', $cust_id)
               ->get();
       }

       // Dito ko sana ilalagay kaso parang humahaba na

       foreach($cust_details as $cust_detail){
           $html .= '<option value="' . $cust_detail -> CLIENTID . '" id="custOptions" readonly>' . $cust_detail->NAME . '</option>';
           $html2 = $cust_detail->NAME;
       }

       foreach($poProducts as $products){
           $product .= '<option value="' . $products -> PROD_CODE . '" id="product" data-id=" '. $products -> PRODUCT . ' ">' . $products->PRODUCT . ' - '. $products -> SIZE.'</option>';

       }

        return response()->json(array('html' => $html , 'html2' => $html2 , 'date' => $date , 'product' => $product , 'amount' => $amount));
    }

    function poProductDetails(Request $request){
        $cust_id = $request-> cust_id;
        $po_id = $request-> po_id;
        $prodCode = $request -> prodCode;
        $prod_id = $request -> prodId;
        $price_date = $request-> price_date;


        $size = '';
        $quantity = 0;
        $amount = '';
        $usedQty = 0;

        //dd($request->all());

        $productDetails = db::table('client_po_list as a')
            ->join('client_po as b' , 'b.ID', '=' , 'a.CLIENTPO_ID')
            ->where('a.PO_NO', $po_id)
            ->where('PRODUCT', $prod_id)
            ->get();

        $amount = db::table('product_list')
            ->select('*', 'product_list.ID as PROD_ID')
            ->join('products', 'products.PROD_CODE' , '=' , 'product_list.PRODUCT')
            ->where('PRICE_DATE', $price_date)
            ->where('CLIENTID', $cust_id)
            ->where('product_list.PROD_CODE', $prodCode)
            ->get();

        if($amount -> isEmpty()){
            $amount = db::table('product_list')
                ->select('*', 'product_list.ID as PROD_ID')
                ->join('products', 'products.PRODUCT' , '=' , 'product_list.PRODUCT')
                ->where('PRICE_DATE', $price_date)
                ->where('CLIENTID', $cust_id)
                ->where('product_list.PROD_CODE', $prodCode)
                ->get();
        }


        foreach($productDetails as $product){

            $quantity = $product -> QUANTITY;
        }

        $past_sales_product_qty = db::table('sales_invoice as a')
            ->select(DB::raw("SUM(b.QTY) as sum"))
            ->join('sales_invoice_order as b', 'a.INVOICE_NO', '=' , 'b.INVOICE_NO')
            ->WHERE('b.SIZE', $size)
            ->get();

        foreach($past_sales_product_qty as $usedData){
            $usedQty = $usedData -> sum;
        }

        foreach($amount as $productAmount){
            $amount = $productAmount -> PRODUCT_PRICE;
            $size = $productAmount -> SIZE;
        }

        return response()->json(array('size' => $size , 'quantity' => floatval($quantity) , 'amount' => $amount));
    }

    function invoiceNoModal(Request $request){
        $id = $request -> id;
        $tableData = '';
        $tableData2 = '';

        $product_query = DB::table('sales_invoice_order as a')
            ->join('products as b', 'a.PRODUCT', '=' , 'b.PROD_CODE')
            ->where('INVOICE_NO', $id)
            ->get();

        $particular_query = db::table('other_charges')
            ->where('INVOICE_NO', $id)
            ->get();

        $invoice_information = db::table('sales_invoice')
            ->where('INVOICE_NO', $id)
            ->get();

        foreach($product_query as $data){

            $data1 = '<td> '.$data -> PRODUCT.'</td>';
            $data2 = '<td> '.$data -> SIZE.'</td>';
            $data3 = '<td> '.$data -> UNIT_PRICE.'</td>';
            $data4 = '<td> '.$data -> QTY .'</td>';

            $tableData .= '<tr class="text-center">'.$data1. ' '. $data2 .' '.$data3.' '.$data4.'</tr>';
        }

        foreach($particular_query as $data){
            $data1 = '<td>'.$data -> PARTICULAR.'</td>';
            $data2 = '<td>'.$data -> UNIT_PRICE.'</td>';
            $data3 = '<td>'.$data -> QUANTITY.'</td>';

            $tableData2 .= '<tr class="text-center">'.$data1. ' '. $data2 .' '.$data3.' </tr>';
        }

        $deposit = 0;
        $downpay = 0;
        $totalamt = 0;
        $type = '';

        $dataArray = array();


        foreach($invoice_information as $invoice_data){

            $data1 = '';
            $data2 = '';
            $data3 = '';
            $data4 = '';

            $dataArray = array([
                'Deposit' => $invoice_data -> DEPOSIT,
                'Downpayment' => $invoice_data -> DOWNPAYMENT,
                'Total' => $invoice_data -> TOTAL
            ]);

        }



        return response()->json(array('table_data' => $tableData , 'table_data2' => $tableData2 , 'dataArray' => $dataArray));

    }

    public function icrProduct(Request $request){
        
        $cust_id = $request -> cust_id;
        $option = '';


        $product_query = db::table('product_list')
            ->where('CLIENTID', $cust_id)
            ->get();

        foreach($product_query as $data){
            $option .= '<option value="'.$data -> PROD_CODE.'" data-id="'.$data->ID.'"> '.$data -> PRODUCT.' - '.$data->SIZE.' </option>';
        }

        return response()->json(array('option' => $option));

    }

    public function icrProductDetails(Request $request){

        $data_id = $request -> data_id;

        $product_size_query = db::table('product_list')
            ->where('ID', $data_id)
            ->get();

        foreach($product_size_query as $data){
            $sizeData = $data -> SIZE;
        }

        return response()->json(array('size' => $sizeData));        

    }

    /*public function client_sales_invoice(Request $request){
        $data_id = $request -> client_id;
        $tableData2 = '';

        $sales_invoice = db::table('sales_invoice')
            ->select('INVOICE_NO as No', 'INVOICE_DATE as date' , 'BALANCE as balance')
            ->selectRaw("'INVOICE' as TYPE")
            ->where('CLIENT_ID', $data_id)
            ->where('FULLY_PAID', 0)
            ->orderBy('INVOICE_NO', 'asc')
            ->get();



        foreach($sales_invoice as $data){
            $data0 = '<td> <input type="checkbox" id="radioButton"></td>';
            $data1 = '<td>'.$data -> No .'</td>';
            $data2 = '<td>'.$data -> date .'</td>';
            $data3 = '<td>'.$data -> balance .'</td>';
            $data4 = '<td class="hidden">'.$data -> TYPE .'</td>';

            $tableData2 .= '<tr class="text-center">'.$data0.' '.$data1.' '. $data2 .' '.$data3.' '.$data4.' </tr>';
        }

        return response()->json(['table_data2' => $tableData2]);

    }*/

    public function client_sales_invoice(){
         $id = $_GET['id'];

         if($id == ""){
             $id = "-1";
                $sales_invoice = db::table('sales_invoice')
                    ->select(['INVOICE_NO','INVOICE_DATE','BALANCE'])
                    ->where('CLIENT_ID', $id)
                    ->where('FULLY_PAID', 0)
                    ->orderBy('INVOICE_NO', 'asc');


             return DataTables::query($sales_invoice)
                 ->addColumn('action', function($row){
                     $btn = '<td> <input type="checkbox" id="radioButton"></td>';
                     return $btn;
                 })
                 ->rawColumns(['action'])
                 ->toJson();
         }else{
             $sales_invoice = db::table('sales_invoice')
                 ->select(['INVOICE_NO','INVOICE_DATE','BALANCE'])
                 ->where('CLIENT_ID', $id)
                 ->where('FULLY_PAID', 0)
                 ->orderBy('INVOICE_NO', 'asc');


             return DataTables::query($sales_invoice)
                 ->addColumn('action', function($row){
                     $btn = '<td> <input type="checkbox" id="radioButton"></td>';
                     return $btn;
                 })
                 ->rawColumns(['action'])
                 ->toJson();
         }

    }

    public function client_sales_invoice2(){
        $id = $_GET['id'];

        if($id == ""){

            $id = "-1";
            $delivery_invoice = db::table('delivery_receipt')
                ->select(['DR_NO', 'DR_DATE' , 'BALANCE'])
                ->where('CLIENT_ID', $id)
                ->where('AS_INVOICE', '=', '1')
                ->where('FULLY_PAID', 0)
                ->orderBy('DR_NO', 'asc');


            return DataTables::query($delivery_invoice)
                ->addColumn('action', function($row){
                    $btn = '<td> <input type="checkbox" id="radioButton"></td>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }else{
            $delivery_invoice = db::table('delivery_receipt')
                ->select(['DR_NO', 'DR_DATE' , 'BALANCE'])
                ->where('CLIENT_ID', $id)
                ->where('AS_INVOICE', '=', '1')
                ->where('FULLY_PAID', 0)
                ->orderBy('DR_NO', 'asc');


            return DataTables::query($delivery_invoice)
                ->addColumn('action', function($row){
                    $btn = '<td> <input type="checkbox" id="radioButton"></td>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

    }

    public function cylinder_type_validation(Request $request){

        $cylinder_type = $request -> cylinder_type;
        $cylinder_id = $request -> id;


        /*
            0 => Empty
            1 => ICR
            2 => CLC
            3 => DR
        */

        if($cylinder_type == "1"){

            $assigned = db::table('icr_assigned')
                ->join('sales_rep', 'sales_rep.ID', '=', 'icr_assigned.SALESREP_ID')
                ->where('FROM_NO', '<=', $cylinder_id)
                ->where('TO_NO', '>=', $cylinder_id)
                ->get();





            $issuedBy = '';

            if ($assigned->isEmpty() == false) {

                $report = db::table('icr_assigned_report')
                    ->where('ICR_NO', $cylinder_id)
                    ->where(function ($query) {
                        $query->where('REMARKS', '=', 'DONE')
                            ->orWhere('REMARKS', '=', 'CANCELLED')
                            ->orWhere('REMARKS', '=', 'NO RECORD FOUND');
                    })
                    ->get();

                if ($report->isEmpty() == true) {
                    return response()->json(array('status' => 'ACTIVE'));
                } else {
                    foreach ($report as $remarks) {
                        return response()->json(array(['status' => $remarks->REMARKS]));
                    }

                }
            }else{
                return Response()->json(['status' => 'empty']);
            }
        }elseif($cylinder_type == 2){
            $assigned = db::table('clc_assigned')
                ->join('sales_rep', 'sales_rep.ID', '=', 'clc_assigned.SALESREP_ID')
                ->where('FROM_NO', '<=', $cylinder_id)
                ->where('TO_NO', '>=', $cylinder_id)
                ->get();

            $issuedBy = '';

            foreach ($assigned as $issuerName) {
                $issuedBy = $issuerName->ASSIGNED_BY;
                $issuerID = $issuerName->SALESREP_ID;
            }


            if ($assigned->isEmpty() == false) {

                $report = db::table('clc_assigned_report')
                    ->where('CLC_NO', $cylinder_id)
                    ->where(function ($query) {
                        $query->where('REMARKS', '=', 'DONE')
                            ->orWhere('REMARKS', '=', 'CANCELLED')
                            ->orWhere('REMARKS', '=', 'NO RECORD FOUND');
                    })
                    ->get();

                if ($report->isEmpty() == true) {
                    return response()->json(array('status' => 'ACTIVE'));
                } else {
                    foreach ($report as $remarks) {
                        return response()->json(array(['status' => $remarks->REMARKS]));
                    }

                }
            }else{
                return Response()->json(['status' => 'empty']);
            }
        }





    }

    public function customer_po(Request $request){

        $client_id = $request -> cust_id;
        $option = '';
        $option2 = '';

        $po_list = db::table('client_po')
            ->where('CLIENTID', $client_id)
            ->get();

        $price_date = db::table('product_list')
            ->where('CLIENTID', $client_id)
            ->groupBy('PRICE_DATE')
            ->orderBy('PRICE_DATE', 'ASC')
            ->get();


        foreach($po_list as $data){
            $option .= '<option value="'.$data -> PO_NO.'" custId="'.$data->CLIENTID.'"> '.$data -> PO_NO.' </option>';
        }

        foreach($price_date as $data2){
            $option2 .= '<option value="'.$data2 -> PRICE_DATE.'" custId="'.$data2->CLIENTID.'"> '.$data2 -> PRICE_DATE.' </option>';
        }

        return response()->json(array('option' => $option, 'option2' => $option2));

    }


    public function delete_pricelist(Request $request){
        $id = $request->id;
        db::table('product_list')->where('ID', $id)->delete();

        return Response()->json(['status' => 'true']);
    }

}
