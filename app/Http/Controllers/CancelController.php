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

        $id = db::table('sales_invoice')
            ->where('ID', $id)
            ->get();

        foreach ($id as $id){
            $INVOICE_NO = $id -> INVOICE_NO;
        }

        $exist = db::table('si_assigned_report')
            ->where('INVOICE_NO', $INVOICE_NO)
            ->count();

        if($exist == 1){
            db::table('si_assigned_report')
                ->where('INVOICE_NO', $INVOICE_NO)
                ->update([
                    'remarks' => 'CANCELLED'
                ]);
        }else{
            db::table('si_assigned_report')
                ->where('INVOICE_NO', $INVOICE_NO)
                ->insert([
                    'INVOICE_NO' => $INVOICE_NO,
                    'remarks' => 'CANCELLED'
                ]);
        }



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

        $id = db::table('delivery_receipt')
            ->where('ID', $id)
            ->get();

        foreach ($id as $id){
            $NO = $id -> DR_NO;
        }

        $exist = db::table('dr_assigned_report')
            ->where('DR_NO', $NO)
            ->count();

        if($exist == 1){
            db::table('dr_assigned_report')
                ->where('DR_NO', $NO)
                ->update([
                    'remarks' => 'CANCELLED'
                ]);
        }else{
            db::table('dr_assigned_report')
                ->where('DR_NO', $NO)
                ->insert([
                    'DR_NO' => $NO,
                    'remarks' => 'CANCELLED'
                ]);
        }

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

        $id = db::table('cylinder_receipt')
            ->where('ID', $id)
            ->get();

        foreach ($id as $id){
            $NO = $id -> ICR_NO;
        }

        $exist = db::table('icr_assigned_report')
            ->where('ICR_NO', $NO)
            ->count();

        if($exist == 1){
            db::table('icr_assigned_report')
                ->where('ICR_NO', $NO)
                ->update([
                    'remarks' => 'CANCELLED'
                ]);
        }else{
            db::table('icr_assigned_report')
                ->where('ICR_NO', $NO)
                ->insert([
                    'ICR_NO' => $NO,
                    'remarks' => 'CANCELLED'
                ]);
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function cancel_loan(Request $request){

        extract($request->all());
        db::table('cylinder_loan_contract')
            ->where('ID', $id)
            ->update([
                'STATUS' => 2
            ]);

        $id = db::table('cylinder_loan_contract')
            ->where('ID', $id)
            ->get();

        foreach ($id as $id){
            $NO = $id -> CLC_NO;
        }

        $exist = db::table('clc_assigned_report')
            ->where('CLC_NO', $NO)
            ->count();

        if($exist == 1){
            db::table('clc_assigned_report')
                ->where('CLC_NO', $NO)
                ->update([
                    'remarks' => 'CANCELLED'
                ]);
        }else{
            db::table('clc_assigned_report')
                ->where('CLC_NO', $NO)
                ->insert([
                    'CLC_NO' => $NO,
                    'remarks' => 'CANCELLED'
                ]);
        }


        return response()->json([
            'status' => 'success'
        ]);
    }

    public function cancelInvoice(Request $request){
        extract($request->all());

        if($value == 'OR'){
            db::table('official_receipt')
            ->where('ID', $id)
            ->update([
                'STATUS' => 2
            ]);

            $id = db::table('official_receipt')
                ->where('ID', $id)
                ->get();

            foreach ($id as $id){
                $NO = $id -> OR_NO;
            }

            $exist = db::table('or_assigned_report')
                ->where('OR_NO', $NO)
                ->count();

            if($exist == 1){
                db::table('or_assigned_report')
                    ->where('OR_NO', $NO)
                    ->update([
                        'remarks' => 'CANCELLED'
                    ]);
            }else{
                db::table('or_assigned_report')
                    ->where('OR_NO', $NO)
                    ->insert([
                        'OR_NO' => $NO,
                        'remarks' => 'CANCELLED'
                    ]);

                db::table('or_cancelled')
                    ->insert([
                        'OR_NO' => $NO,
                        'USED_ID' => $NO,
                        'CANCELLED_DATE' => date("Y-m-d"),
                    ]);
            }

            return response()->json([
                'status' => 'success'
            ]);
        }else if($value == 'PR'){
            db::table('provisional_receipt')
            ->where('ID', $id)
            ->update([
                'STATUS' => 2
            ]);

            return response()->json([
                'status' => 'success'
            ]);
        }
    }

    public function cancel(Request $request){
        extract($request->all());
        if($type == "sales"){
            $exist = db::table('si_assigned_report')
                ->where('INVOICE_NO', $id)
                ->count();

            if($exist == 1){
                db::table('si_assigned_report')
                    ->where('INVOICE_NO', $id)
                    ->update([
                        'remarks' => 'CANCELLED'
                    ]);
            }else{
                db::table('si_assigned_report')
                    ->where('INVOICE_NO', $id)
                    ->insert([
                        'INVOICE_NO' => $id,
                        'remarks' => 'CANCELLED'
                    ]);
            }

            return response()->json([
                'status' => 'success'
            ]);
        }elseif($type == "delivery"){
            $exist = db::table('dr_assigned_report')
                ->where('DR_NO', $id)
                ->count();

            if($exist == 1){
                db::table('dr_assigned_report')
                    ->where('DR_NO', $id)
                    ->update([
                        'remarks' => 'CANCELLED'
                    ]);
            }else{
                db::table('dr_assigned_report')
                    ->where('DR_NO', $id)
                    ->insert([
                        'DR_NO' => $id,
                        'remarks' => 'CANCELLED'
                    ]);
            }

            return response()->json([
                'status' => 'success'
            ]);
        }
    }
}
