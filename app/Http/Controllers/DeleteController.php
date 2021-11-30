<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{
    public function DeleteInvoice(Request $request){
        
        extract($request->all());

        // dd($request->all());
        
        if($value == "sales"){

            db::table('sales_invoice')
                ->where('INVOICE_NO', $id)->delete();

            db::table('sales_invoice_order')
                ->where('INVOICE_NO', $id)->delete();

            db::table('sales_invoice_po')
                ->where('INVOICE_NO', $id)->delete();
            
            return response()->json(['status' => 'success']);
        }
        else if($value == "delivery"){

            db::table('delivery_receipt')
                ->where('DR_NO', $id)->delete();

            db::table('delivery_receipt_order')
                ->where('DR_NO', $id)->delete();

            db::table('delivery_receipt_po')
                ->where('DR_NO', $id)->delete();
            
            return response()->json(['status' => 'success']);
        }
        else if($value == "collection"){

            db::table('official_receipt')
                ->where('OR_NO', $id)->delete();
            db::table('official_receipt_double_paid')
                ->where('OR_NO', $id)->delete();
            db::table('official_receipt_over_payment')
                ->where('OR_NO', $id)->delete();
            db::table('official_receipt_paid')
                ->where('OR_NO', $id)->delete();
            db::table('official_receipt_partial_payment')
                ->where('OR_NO', $id)->delete();
            db::table('official_receipt_report')
                ->where('OR_NO', $id)->delete();
            db::table('official_receipt_reports')
                ->where('OR_NO', $id)->delete();
            return response()->json(['status' => 'success']);

        }
        else if($value == "provisional"){
            db::table('provisional_receipt')
                ->where('PR_NO', $id)->delete();
            db::table('provisional_receipt_over_payment')
                ->where('PR_NO', $id)->delete();
            db::table('provisional_receipt_paid')
                ->where('PR_NO', $id)->delete();
            db::table('provisional_receipt_partial_payment')
                ->where('PR_NO', $id)->delete();
            db::table('provisional_receipt_report')
                ->where('PR_NO', $id)->delete();
            db::table('provisional_receipt_reports')
                ->where('PR_NO', $id)->delete();
            return response()->json(['status' => 'success']);
        }

    }

}