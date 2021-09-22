<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;
use SujalPatel\IntToEnglish\IntToEnglish;

class PdfController extends Controller
{
    //

    public function aging_pdf_view () {
        $delivery = db::table('dr_aging_report')
            ->select('REPORTNO','REPORTTYPE','REPORTDATE', 'AGING', 'BALANCE', 'NAME')
            ->get();
            

        return view('PDF.aging_pdf')
            ->with('delivery', $delivery);
    }

    public function aging_pdf_print(){
      
        $delivery = db::table('dr_aging_report')
            ->select('REPORTNO','REPORTTYPE','REPORTDATE', 'AGING', 'BALANCE', 'NAME')
            ->get();

        $total1 = 0;
        $total2 = 0;
        $total3 = 0;
        $total4 = 0;
        $total_amount = 0;

        foreach($delivery as $data){
            if($data->AGING <= 30){
                $total1 += $data->BALANCE;
            }
            if($data -> AGING > 30 && $data -> AGING <= 60){
                $total2 += $data->BALANCE;
            }
            if($data -> AGING > 60 && $data -> AGING <= 90){
                $total3 += $data->BALANCE;
            }
            if($data -> AGING > 90){
                $total4 += $data->BALANCE;
            }   
            $total_amount += $data->BALANCE;
        }
      // share data to view

        view()->share(['delivery' => $delivery, 'total1' => $total1 , 'total2' => $total2, 'total3' => $total3, 'total4'=> $total4,'amount_due' =>$total_amount]);
    
        $pdf = PDF::loadView('PDF.aging_pdf', $delivery);

        ob_end_clean();

        // download PDF file with download method
        return $pdf->stream('Aging.pdf',array('Attachment'=>0));
    }

    public function cylinder_pdf_print(Request $request){

        ob_start();

        extract($request->all());

        $cylinder = db::table('summary_cylinder_balance_report')
            ->get();

        $customer = db::table('client')
            ->where('CLIENTID', $id)
            ->get();

        foreach($customer as $customer){
            $name = $customer -> NAME;
        }

        $path = 'img/jt-new-logo.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);




        // share data to view


        view()->share(['cylinder' => $cylinder, 'name' => $name, 'logo' => $logo ]);

        $pdf = PDF::loadView('PDF.cylinder_pdf', $cylinder);

        ob_end_clean();

        // download PDF file with download method
        return $pdf->stream('CylinderBalance.pdf',array('Attachment'=>0));
    }

    public function soa_pdf_print(Request $request){

        ob_start();

        extract($request->all());

        $statement = db::table('statement_account')
            ->get();

        $customer = db::table('client')
            ->where('CLIENTID', $id)
            ->get();

        foreach($customer as $customer){
            $name = $customer -> NAME;
            $address = $customer -> ADDRESS;
        }

        $path = 'img/jt-new-logo.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);


        // share data to view

        $total1 = 0;
        $total2 = 0;
        $total3 = 0;
        $total4 = 0;
        $amount_total = 0;

        foreach($statement as $data){
           $total1 += $data->LPG;
           $total2 += $data->CO2;
           $total3 += $data->MO2S;
           $total4 += $data->C2H2;
           $amount_total += $data->TOTAL;
        }

        $words =  IntToEnglish::Int2Eng($amount_total);


        view()->share(['statement' => $statement, 'name' => $name, 'logo' => $logo , 'address' => $address , 'from_date' => $from_date , 'words' => $words, 'total1' => $total1 , 'total2' => $total2, 'total3' => $total3, 'total4'=> $total4,'amount_due' =>$amount_total]);

        $pdf = PDF::loadView('PDF.soa_pdf', $statement);

        ob_end_clean();

        // download PDF file with download method
        return $pdf->stream('soa.pdf',array('Attachment'=>0));
    }
}
