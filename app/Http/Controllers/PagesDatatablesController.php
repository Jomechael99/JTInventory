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
            ->select(['a.ID','a.INVOICE_NO', 'a.INVOICE_DATE', 'b.NAME','b.DESIGNATION','b.CELL_NO','a.STATUS'])
            ->where('a.STATUS', 1)
            ->join('client as b', 'b.CLIENTID' , '=' , 'a.CLIENT_ID');

        foreach(Session::get('user') as $user){
            $role = $user -> user_authorization;
        }

        if(in_array($role, array("ADMINISTRATOR","1"))){
            return DataTables::query($invoice_data)
                ->addColumn('action', function($row){
                        $btn = "";
                        $btn .= '<td></d></tr><div class="btn-group-vertical">
                                <a type="button" class="btn btn-info" href='. route('Sales.edit', $row->ID) .'><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>';
                        if($row->STATUS == 1){
                            $btn .= '<a type="button" class="btn btn-warning btn-cancel" data-id='.$row->ID.'><span class="fa fa-times">&nbsp;&nbsp;</span>Cancel Sales Invoice</a>';
                        }
                        $btn .= '<a type="button" value="sales" class="btn btn-danger btn-delete" data-id='.$row->INVOICE_NO.'><span class="fa fa-minus">&nbsp;&nbsp;</span>Delete Sales Invoice</a>';
                        $btn .= '</div></td>';
                        return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }else if(in_array($role, array("ADMINISTRATOR", "USER LEVEL I","1", "2"))) {
            return DataTables::query($invoice_data)
                ->addColumn('action', function($row){
                    $btn = '<td></d></tr><div class="btn-group-vertical">
                                <a type="button" class="btn btn-info" href='. route('Sales.edit', $row->ID) .'><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                            </div></td>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();

        }else if(in_array($role, array("USER LEVEL II","3"))) {
            return DataTables::query($invoice_data)
                ->addColumn('action', function($row){
                    $btn = '';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        else{
            return DataTables::query($invoice_data)->toJson();
        }
    }

    public function delivery_sales(){

        $deliver_invoice = db::table('delivery_receipt as a')
            ->select(['a.ID','a.DR_NO', 'a.DR_DATE', 'b.NAME','b.DESIGNATION','b.CELL_NO', 'a.STATUS'])
            ->join('client as b', 'a.CLIENT_ID', '=', 'b.CLIENTID')
            ->where('a.AS_INVOICE', 1)
            ->where('a.STATUS', 1);

        foreach(Session::get('user') as $user){
            $role = $user -> user_authorization;
        }

        if(in_array($role, array("ADMINISTRATOR","1"))){
            return DataTables::query($deliver_invoice)
                ->addColumn('action', function($row){
                    $btn = "";
                    $btn .= '<td></d></tr><div class="btn-group-vertical">
                                <a type="button" class="btn btn-info" href='. route('DeliverSales.edit', $row->ID) .'><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>';
                    if($row->STATUS == 1){
                        $btn .= '<a type="button" class="btn btn-warning btn-cancel" data-id='.$row->ID.'><span class="fa fa-times">&nbsp;&nbsp;</span>Cancel DR INVOICE</a>';
                    }
                    $btn .= '<a type="button" value="delivery" class="btn btn-danger btn-delete" data-id='.$row->DR_NO.'><span class="fa fa-minus">&nbsp;&nbsp;</span>Delete DR Invoice</a>';
                    $btn .= '</div></td>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }else if(in_array($role, array("ADMINISTRATOR", "USER LEVEL I","1", "2"))) {
            return DataTables::query($deliver_invoice)
                ->addColumn('action', function($row){
                    $btn = '<td></d></tr><div class="btn-group-vertical">
                                <a type="button" class="btn btn-info" href='. route('DeliverSales.edit', $row->ID) .'><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                            </div></td>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();

        }else if(in_array($role, array("USER LEVEL II","3"))) {
            return DataTables::query($deliver_invoice)
                ->addColumn('action', function($row){
                    $btn = '<td></d></tr><div class="btn-group-vertical">
                                <a type="button" class="btn btn-info" href='. route('DeliverSales.edit', $row->ID) .'><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                            </div></td>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        else{
            return DataTables::query($deliver_invoice)->toJson();
        }
    }

    public function delivery_sales_2(){

        $deliver_invoice = db::table('delivery_receipt as a')
            ->select(['a.ID','a.DR_NO', 'a.DR_DATE', 'b.NAME','b.DESIGNATION','b.CELL_NO', 'a.STATUS'])
            ->join('client as b', 'a.CLIENT_ID', '=', 'b.CLIENTID')
            ->where('a.AS_INVOICE', 0)
            ->where('a.STATUS', 1);

        foreach(Session::get('user') as $user){
            $role = $user -> user_authorization;
        }

        if(in_array($role, array("ADMINISTRATOR","1"))){
            return DataTables::query($deliver_invoice)
                ->addColumn('action', function($row){
                    $btn = "";
                    $btn .= '<td></d></tr><div class="btn-group-vertical">
                                <a type="button" class="btn btn-info" href='. route('Deliver.edit', $row->ID) .'><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>';
                    if($row->STATUS == 1){
                        $btn .= '<a type="button" class="btn btn-warning btn-cancel" data-id='.$row->ID.'><span class="fa fa-times">&nbsp;&nbsp;</span>Cancel DR INVOICE</a>';
                    }
                    $btn .= '<a type="button" value="delivery" class="btn btn-danger btn-delete" data-id='.$row->DR_NO.'><span class="fa fa-minus">&nbsp;&nbsp;</span>Delete DR Invoice</a>';
                    $btn .= '</div></td>';
                    return $btn;

                })
                ->rawColumns(['action'])
                ->toJson();
        }else if(in_array($role, array("ADMINISTRATOR", "USER LEVEL I","1", "2"))) {
            return DataTables::query($deliver_invoice)
                ->addColumn('action', function($row){
                    $btn = '<td></d></tr><div class="btn-group-vertical">
                                <a type="button" class="btn btn-info" href='. route('Deliver.edit', $row->ID) .'><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                            </div></td>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }else if(in_array($role, array("USER LEVEL II","3"))) {
            return DataTables::query($deliver_invoice)
                ->addColumn('action', function($row){
                    $btn = '<td></d></tr><div class="btn-group-vertical">
                                <a type="button" class="btn btn-info" href='. route('Deliver.edit', $row->ID) .'><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                            </div></td>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        else{
            return DataTables::query($deliver_invoice)->toJson();
        }
    }

    public function official_receipt_data(){

        $OR = db::table('official_receipt as a')
            ->select(['a.ID','a.OR_NO', 'a.OR_DATE', 'b.NAME', 'a.STATUS'])
            ->join('client as b', 'a.CLIENT_ID', '=', 'b.CLIENTID');

        foreach(Session::get('user') as $user){
            $role = $user -> user_authorization;
        }

        if(in_array($role, array("ADMINISTRATOR","1"))){
            return DataTables::query($OR)
                ->addColumn('action', function($row){
                    $btn = "";
                    $btn .= '<td></d></tr><div class="btn-group-vertical">
                        <a type="button" class="btn btn-info" href='. route('OfficialReceipt.edit', $row->ID) .'><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                    ';
                    if($row->STATUS == 1){
                        $btn .= '<a type="button" value="OR" class="btn btn-warning btn-cancel" data-id='.$row->ID.'><span class="fa fa-times">&nbsp;&nbsp;</span>Cancel OR INVOICE</a>';
                    }
                    $btn .= '<a type="button" value="collection" class="btn btn-danger btn-delete" data-id='.$row->OR_NO.'><span class="fa fa-minus">&nbsp;&nbsp;</span>Delete OR Invoice</a>';
                    $btn .= '</div></td>';
                    return $btn;

                })
                ->rawColumns(['action'])
                ->toJson();
        }else if(in_array($role, array("ADMINISTRATOR", "USER LEVEL I","1", "2"))) {
            return DataTables::query($OR)
                ->addColumn('action', function($row){
                    $btn .= '<td></d></tr><div class="btn-group-vertical">
                        <a type="button" class="btn btn-info" href='. route('OfficialReceipt.edit', $row->ID) .'><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                    ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }else if(in_array($role, array("USER LEVEL II","3"))) {
            return DataTables::query($OR)
                ->addColumn('action', function($row){
                    $btn .= '<td></d></tr><div class="btn-group-vertical">
                        <a type="button" class="btn btn-info" href='. route('OfficialReceipt.edit', $row->ID) .'><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                    ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        else{
            return DataTables::query($OR)->toJson();
        }

        
    }

    public function provisional_data(){

        $PR = db::table('provisional_receipt as a')
            ->select(['a.ID','a.PR_NO', 'a.PR_DATE', 'b.NAME' , 'a.STATUS'])
            ->join('client as b', 'a.CLIENT_ID', '=', 'b.CLIENTID');

        foreach(Session::get('user') as $user){
            $role = $user -> user_authorization;
        }

        if(in_array($role, array("ADMINISTRATOR","1"))){
            return DataTables::query($PR)
                ->addColumn('action', function($row){
                    $btn = "";
                    $btn .= '<td></d></tr><div class="btn-group-vertical">
                        <a type="button" class="btn btn-info" href='. route('ProvisionalReceipt.edit', $row->ID) .'><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                    ';
                    if($row->STATUS == 1){
                        $btn .= '<a type="button" value="PR" class="btn btn-warning btn-cancel" data-id='.$row->ID.'><span class="fa fa-times">&nbsp;&nbsp;</span>Cancel PR INVOICE</a>';
                    }
                    $btn .= '<a type="button" value="provisional" class="btn btn-danger btn-delete" data-id='.$row->PR_NO.'><span class="fa fa-minus">&nbsp;&nbsp;</span>Delete PR Invoice</a>';
                    $btn .= '</div></td>';
                    return $btn;

                })
                ->rawColumns(['action'])
                ->toJson();
        }else if(in_array($role, array("ADMINISTRATOR", "USER LEVEL I","1", "2"))) {
            return DataTables::query($PR)
                ->addColumn('action', function($row){
                    $btn .= '<td></d></tr><div class="btn-group-vertical">
                        <a type="button" class="btn btn-info" href='. route('ProvisionalReceipt.edit', $row->ID) .'><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                    ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }else if(in_array($role, array("USER LEVEL II","3"))) {
            return DataTables::query($PR)
                ->addColumn('action', function($row){
                    $btn .= '<td></d></tr><div class="btn-group-vertical">
                        <a type="button" class="btn btn-info" href='. route('ProvisionalReceipt.edit', $row->ID) .'><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                    ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        else{
            return DataTables::query($PR)->toJson();
        }
    }

    public function soa_history(){

        $history = db::table('statement_account_history');
        $btn = '';

        return DataTables::query($history)
            ->toJson();
    }
}
