<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
Use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;

class PagesController extends Controller
{

    public function getDashboard(){

        if(session()->has('user')){

/*            $sales_data = db::table('sales_invoice')
                ->select(db::raw('DATEDIFF(CURDATE(),INVOICE_DATE) as AGING'),'INVOICE_DATE as REPORTDATE','INVOICE_NO as REPORTNO', 'BALANCE' ,'NAME')
                ->join('client', 'client.CLIENTID', '=', 'sales_invoice.client_id')
                ->where('sales_invoice.STATUS', 1)
                ->where(db::raw('DATEDIFF(CURDATE(),INVOICE_DATE)'),'>','120')
                ->where('FULLY_PAID', 0);

            $dr_data = db::table('delivery_receipt')
                ->select(db::raw('DATEDIFF(CURDATE(),DR_DATE) as AGING'),'DR_DATE as REPORTDATE','DR_NO as REPORTNO','BALANCE','NAME')
                ->join('client', 'client.CLIENTID', '=', 'delivery_receipt.client_id')
                ->where('delivery_receipt.STATUS', 1)
                ->where('FULLY_PAID', 0)
                ->where(db::raw('DATEDIFF(CURDATE(),DR_DATE)'),'>','120')
                ->unionAll($sales_data)
                ->orderBy('REPORTNO', 'DESC')
                ->get();

            $sales_data2 = db::table('sales_invoice')
                ->select(db::raw('DATEDIFF(CURDATE(),INVOICE_DATE) as AGING'),'INVOICE_DATE as REPORTDATE','INVOICE_NO as REPORTNO', 'BALANCE' ,'NAME')
                ->join('client', 'client.CLIENTID', '=', 'sales_invoice.client_id')
                ->where('sales_invoice.STATUS', 1)
                ->where(db::raw('DATEDIFF(CURDATE(),INVOICE_DATE)'), 120)
                ->where('FULLY_PAID', 0);

            $dr_data2 = db::table('delivery_receipt')
                ->select(db::raw('DATEDIFF(CURDATE(),DR_DATE) as AGING'),'DR_DATE as REPORTDATE','DR_NO as REPORTNO','BALANCE','NAME')
                ->join('client', 'client.CLIENTID', '=', 'delivery_receipt.client_id')
                ->where('delivery_receipt.STATUS', 1)
                ->where('FULLY_PAID', 0)
                ->where(db::raw('DATEDIFF(CURDATE(),DR_DATE)'), 120)
                ->unionAll($sales_data2)
                ->orderBy('REPORTNO', 'DESC')
                ->get();*/

            $sales_data = db::table('sales_invoice')
                ->select(db::raw('DATEDIFF(CURDATE(),INVOICE_DATE) as AGING'),'INVOICE_DATE as REPORTDATE','INVOICE_NO as REPORTNO', 'BALANCE' ,'NAME')
                ->selectRaw(' "CR" AS TYPE ')
                ->join('client', 'client.CLIENTID', '=', 'sales_invoice.client_id')
                ->where('BALANCE','!=', 0)
                ->where(db::raw('DATEDIFF(CURDATE(),INVOICE_DATE)'),'=','120')
                ->where('FULLY_PAID', 1);

            $dr_data = db::table('delivery_receipt')
                ->select(db::raw('DATEDIFF(CURDATE(),DR_DATE) as AGING'),'DR_DATE as REPORTDATE','DR_NO as REPORTNO','BALANCE','NAME')
                ->selectRaw(' "PR" AS TYPE ')
                ->join('client', 'client.CLIENTID', '=', 'delivery_receipt.client_id')
                ->where('BALANCE','!=', 0)
                ->where('FULLY_PAID', 0)
                ->where(db::raw('DATEDIFF(CURDATE(),DR_DATE)'),'=','120')
                ->unionAll($sales_data)
                ->orderBy('REPORTNO', 'DESC')
                ->get();

            $sales_data2 = db::table('sales_invoice')
                ->select(db::raw('DATEDIFF(CURDATE(),INVOICE_DATE) as AGING'),'INVOICE_DATE as REPORTDATE','INVOICE_NO as REPORTNO', 'BALANCE' ,'NAME')
                ->join('client', 'client.CLIENTID', '=', 'sales_invoice.client_id')
                ->where('BALANCE','!=', 0)
                ->where(db::raw('DATEDIFF(CURDATE(),INVOICE_DATE)'), 120)
                ->where('FULLY_PAID', 0);

            $dr_data2 = db::table('delivery_receipt')
                ->select(db::raw('DATEDIFF(CURDATE(),DR_DATE) as AGING'),'DR_DATE as REPORTDATE','DR_NO as REPORTNO','BALANCE','NAME')
                ->join('client', 'client.CLIENTID', '=', 'delivery_receipt.client_id')
                ->where('BALANCE','!=', 0)
                ->where('FULLY_PAID', 1)
                ->where(db::raw('DATEDIFF(CURDATE(),DR_DATE)'), 120)
                ->unionAll($sales_data2)
                ->orderBy('REPORTNO', 'DESC')
                ->get();

            $cnt = 0;
            

            if($dr_data2->count() == 0){
                $cnt =  0;
            }else{
                $cnt = $dr_data2->count();
            }

            return view('dashboard')
                ->with('Aging', $dr_data)
                ->with('cnt', $cnt);

        }else{
           Return redirect() -> Route('loginPage');
        }
    }

    public function getCustomerView(){

        if(session()->has('user')){
            $client = DB::table('client')
                ->join('client_type', 'client.TYPE', '=', 'client_type.ID')
                ->select('client.*', 'client_type.CLIENT_TYPE')
                ->orderByDesc('CLIENTID')
                ->get();


            return view('customer.viewcustomer' , ['client' => $client]);
       }else{
           return view('login');
       }

    }

    public function getPriceCustomerView(){
        if(session()->has('user')){
            $client = DB::table('client')
                ->join('client_type', 'client.TYPE', '=', 'client_type.ID')
                ->select('client.*', 'client_type.CLIENT_TYPE')
                ->orderByDesc('CLIENTID')
                ->get();

            return view('pricelist.viewpricelist' , ['client' => $client]);
       }else{
           return view('login');
       }

    }

    public function getCylinderBalance(){

        if(session()->has('user')){
            $client = DB::table('client')
                ->join('client_type', 'client.TYPE', '=', 'client_type.ID')
                ->select('client.*', 'client_type.CLIENT_TYPE')
                ->get();

            return view('cylinder.viewcylinder', ['client' => $client]);
       }else{
           return view('login');
       }

    }

    public function getPurchaseOrder(){

        if(session()->has('user')){
            $purchaseList = db::table('client')
                ->join('client_po' , 'client.CLIENTID' , '=' , 'client_po.CLIENTID')
                ->where('client_po.STATUS', '!=' , null)
                ->where('client_po.CLIENTID', '!=' , null)
                ->get();

            return view('purchase_order.viewpurchase', ['purchaselist' => $purchaseList]);
       }else{
           return view('login');
       }


    }

    public function getSystemUsers(){

        if(session()->has('user')){
            $systemUsers = db::Table('users')->get();

            return view('SystemUtilities.Users.viewusers')
                ->with('systemUsers', $systemUsers);
       }else{
           return view('login');
       }


    }

    public function getLogin(){
        if(session()->has('user')){
           return redirect()->route('Dashboard');
        }else{
            return view('login');
        }
    }

    public function postLogin(Request $request){

        $credentials = $request->only('username', 'password');

        if(Auth::attempt(['userid' => $request -> userid, 'password' => $request->password])){

            session()->push('user', auth::user());
            return redirect() -> route('Dashboard');

        }else{

            $request->session()->flash('status', 'Username and Password is wrong');
            return redirect()->route('loginPage');

        }


    }

    public function AccountLogout(){

        session()->flush();
        return redirect()->route('loginPage');

    }

    

}
