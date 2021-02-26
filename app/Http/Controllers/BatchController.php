<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatchController extends Controller
{

    public function viewBatchSales(){
        $salesrep = db::table('sales_rep')
            ->orderBy('SALESREP_NAME', 'ASC')
            ->get();

        return view('SystemUtilities.SalesInvoiceDecleration.batchsalesdeclaration')
            ->with(['salesrep' => $salesrep]);
    }

    public function viewBatchICR(){
        $salesrep = db::table('sales_rep')
            ->orderBy('SALESREP_NAME', 'ASC')
            ->get();

        return view('SystemUtilities.ICRDeclaration.batchicrdeclaration')
            ->with(['salesrep' => $salesrep]);
    }

    public function viewBatchCLC(){
        $salesrep = db::table('sales_rep')
            ->orderBy('SALESREP_NAME', 'ASC')
            ->get();

        return view('SystemUtilities.CLCDeclaration.batchclcdeclaration')
            ->with(['salesrep' => $salesrep]);
    }

    public function viewBatchDR(){
        $salesrep = db::table('sales_rep')
            ->orderBy('SALESREP_NAME', 'ASC')
            ->get();

        return view('SystemUtilities.DRDeclaration.batchdrdeclaration')
            ->with(['salesrep' => $salesrep]);
    }

    public function viewBatchCR(){
        $salesrep = db::table('sales_rep')
            ->orderBy('SALESREP_NAME', 'ASC')
            ->get();

        return view('SystemUtilities.ORDeclaration.batchcrdeclaration')
            ->with(['salesrep' => $salesrep]);
    }

    public function addBatchSales(Request $request){


        try{

            if(!$request->sales_rep){
                return response()->json(array('status' => "No Data to be inserted"));
            }else{
                for($i = 0 ; $i < count($request->sales_rep); $i++){
                    $salesInvoice = db::table('si_assigned')
                        ->insert([
                            'SALESREP_ID' => $request -> sales_rep[$i],
                            'FROM_OR_NO' => $request ->  from_no[$i],
                            'TO_OR_NO' => $request -> to_no[$i],
                            'ENCODED_DATE' => $request -> date[$i],
                            'ASSIGNED_BY' => $request -> assigned_by[$i]
                        ]);

                    return response()->json(array('status' => 'success'));
                }
            }

        }catch(Exception $e){
            return response()->json(array('status' => $e));
        }

    }

    public function addICRBatch(Request $request){


        try{

            if(!$request->sales_rep){
                return response()->json(array('status' => "No Data to be inserted"));
            }else{
                for($i = 0 ; $i < count($request->sales_rep); $i++){
                    $salesInvoice = db::table('icr_assigned')
                        ->insert([
                            'SALESREP_ID' => $request -> sales_rep[$i],
                            'FROM_NO' => $request ->  from_no[$i],
                            'TO_NO' => $request -> to_no[$i],
                            'ENCODED_DATE' => $request -> date[$i],
                            'ASSIGNED_BY' => $request -> assigned_by[$i]
                        ]);

                    return response()->json(array('status' => 'success'));
                }
            }

        }catch(Exception $e){
            return response()->json(array('status' => $e));
        }

    }

    public function addCLCBatch(Request $request){


        try{

            if(!$request->sales_rep){
                return response()->json(array('status' => "No Data to be inserted"));
            }else{
                for($i = 0 ; $i < count($request->sales_rep); $i++){
                    $salesInvoice = db::table('clc_assigned')
                        ->insert([
                            'SALESREP_ID' => $request -> sales_rep[$i],
                            'FROM_NO' => $request ->  from_no[$i],
                            'TO_NO' => $request -> to_no[$i],
                            'ENCODED_DATE' => $request -> date[$i],
                            'ASSIGNED_BY' => $request -> assigned_by[$i]
                        ]);

                    return response()->json(array('status' => 'success'));
                }
            }

        }catch(Exception $e){
            return response()->json(array('status' => $e));
        }

    }

    public function addDRBatch(Request $request){


        try{

            if(!$request->sales_rep){
                return response()->json(array('status' => "No Data to be inserted"));
            }else{
                for($i = 0 ; $i < count($request->sales_rep); $i++){
                    $salesInvoice = db::table('dr_assigned')
                        ->insert([
                            'SALESREP_ID' => $request -> sales_rep[$i],
                            'FROM_NO' => $request ->  from_no[$i],
                            'TO_NO' => $request -> to_no[$i],
                            'ENCODED_DATE' => $request -> date[$i],
                            'ASSIGNED_BY' => $request -> assigned_by[$i]
                        ]);

                    return response()->json(array('status' => 'success'));
                }
            }

        }catch(Exception $e){
            return response()->json(array('status' => $e));
        }

    }

    public function addCRBatch(Request $request){


        try{

            if(!$request->sales_rep){
                return response()->json(array('status' => "No Data to be inserted"));
            }else{
                for($i = 0 ; $i < count($request->sales_rep); $i++){
                    $salesInvoice = db::table('or_assigned')
                        ->insert([
                            'SALESREP_ID' => $request -> sales_rep[$i],
                            'FROM_OR_NO' => $request ->  from_no[$i],
                            'TO_OR_NO' => $request -> to_no[$i],
                            'ENCODED_DATE' => $request -> date[$i],
                            'ASSIGNED_BY' => $request -> assigned_by[$i]
                        ]);

                    return response()->json(array('status' => 'success'));
                }
            }

        }catch(Exception $e){
            return response()->json(array('status' => $e));
        }

    }



}
