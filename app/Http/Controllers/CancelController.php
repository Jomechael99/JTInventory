<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CancelController extends Controller
{
    //
    public function cancel_sales(Request $request){
        extract($request->all());
        db::table('sales_invoice')
            ->where('ID', $id)
            ->update([
                'STATUS' => 2
            ]);

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function cancel_dr(Request $request){
        extract($request->all());
        db::table('delivery_receipt')
            ->where('ID', $id)
            ->update([
                'STATUS' => 2
            ]);

        return response()->json([
            'status' => 'success'
        ]);
    }
    public function cancel_icr(Request $request){
        extract($request->all());
        db::table('cylinder_receipt')
            ->where('ID', $id)
            ->update([
                'STATUS' => 2
            ]);

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function cancel_loan(Request $request){
        extract($request->all());
        db::table('cylinder_loan_contractt')
            ->where('ID', $id)
            ->update([
                'STATUS' => 2
            ]);

        return response()->json([
            'status' => 'success'
        ]);
    }
}
