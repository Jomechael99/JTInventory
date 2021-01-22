<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;
use Session;

class PagesDatatablesController extends Controller
{
    //
    public function sales_invoice_data(){
        $invoice_data = db::table('sales_invoice as a')
            ->select(['a.ID','a.INVOICE_NO', 'a.INVOICE_DATE', 'b.NAME','b.DESIGNATION','b.CELL_NO'])
            ->join('client as b', 'b.CLIENTID' , '=' , 'a.CLIENT_ID');

        foreach(Session::get('user') as $user){
            $role = $user -> user_authorization;
        }

        if($role == "ADMINISTRATOR" || $role == 1){
            return DataTables::query($invoice_data)
                ->addColumn('action', function($row){
                        $btn = '<td></d></tr><div class="btn-group-vertical">
                                <a type="button" class="btn btn-info" href='. route('Sales.edit', $row->ID) .'><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                            </div></td>';
                        return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }else{
            return DataTables::query($invoice_data)->toJson();
        }
    }

    public function delivery_sales(){

        $deliver_invoice = db::table('delivery_receipt as a')
            ->select(['a.ID','a.DR_NO', 'a.DR_DATE', 'b.NAME','b.DESIGNATION','b.CELL_NO'])
            ->join('client as b', 'a.CLIENT_ID', '=', 'b.CLIENTID')
            ->where('a.AS_INVOICE', 1);

        foreach(Session::get('user') as $user){
            $role = $user -> user_authorization;
        }

        if($role == "ADMINISTRATOR" || $role == 1){
            return DataTables::query($deliver_invoice)
                ->addColumn('action', function($row){
                    $btn = '<td></d></tr><div class="btn-group-vertical">
                                <a type="button" class="btn btn-info" href='. route('DeliverSales.edit', $row->ID) .'><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                            </div></td>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }else{
            return DataTables::query($deliver_invoice)->toJson();
        }
    }

    public function delivery_sales_2(){

        $deliver_invoice = db::table('delivery_receipt as a')
            ->select(['a.ID','a.DR_NO', 'a.DR_DATE', 'b.NAME','b.DESIGNATION','b.CELL_NO'])
            ->join('client as b', 'a.CLIENT_ID', '=', 'b.CLIENTID')
            ->where('a.AS_INVOICE', 0);

        foreach(Session::get('user') as $user){
            $role = $user -> user_authorization;
        }

        if($role == "ADMINISTRATOR" || $role == 1){
            return DataTables::query($deliver_invoice)
                ->addColumn('action', function($row){
                    $btn = '<td></d></tr><div class="btn-group-vertical">
                                <a type="button" class="btn btn-info" href='. route('Deliver.edit', $row->ID) .'><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                            </div></td>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }else{
            return DataTables::query($deliver_invoice)->toJson();
        }
    }

    public function official_receipt_data(){

        $OR = db::table('official_receipt as a')
            ->select(['a.ID','a.OR_NO', 'a.OR_DATE', 'b.NAME'])
            ->join('client as b', 'a.CLIENT_ID', '=', 'b.CLIENTID');

        foreach(Session::get('user') as $user){
            $role = $user -> user_authorization;
        }

        if($role == "ADMINISTRATOR" || $role == 1){
            return DataTables::query($OR)
                ->addColumn('action', function($row){
                    $btn = '<td></d></tr><div class="btn-group-vertical">
                                <a type="button" class="btn btn-info" href='. route('OfficialReceipt.edit', $row->ID) .'><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                            </div></td>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }else{
            return DataTables::query($OR)->toJson();
        }
    }
}
