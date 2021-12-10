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

        $statement = db::table('statement_account_pdf')
            ->get();

        $count = db::table('statement_count')
            ->get();

        $customer = db::table('client')
            ->where('CLIENTID', $id)
            ->get();

        foreach($customer as $customer){
            $name = $customer -> NAME;
            $address = $customer -> ADDRESS;
        }

        db::table('statement_account_history')
            ->insert([
                'sa_number' => $sa_number,
                'cust_id' => $id,
                'from_date' => $from_date,
                'to_date' => $to_date,
            ]);

        $path = 'img/jt-new-logo.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);


        // share data to view

        $total_C2H2 = 0;
        $total_AR = 0;
        $total_CO2 = 0;
        $total_IO2 = 0;
        $total_LPG = 0;
        $total_MO2 = 0;
        $total_N2 = 0;
        $total_N2O = 0;
        $total_H = 0;
        $total_COMPMED = 0;
        $total_FIREEXT = 0;
        $amount_total = 0;

        foreach($statement as $data){
            $total_C2H2 += $data -> C2H2_PRESTOLITE + $data -> C2H2_MEDIUM + $data -> C2H2_STANDARD;
            $total_AR += $data -> AR_STANDARD;
            $total_CO2 += $data -> CO2_FLASK + $data -> CO2_STANDARD;
            $total_IO2 += $data -> IO2_FLASK + $data -> IO2_MEDIUM + $data -> IO2_STANDARD + $data -> IO2_OVERSIZE;
            $total_LPG += $data -> LPG_11KG + $data -> LPG_22KG + $data -> LPG_50KG;
            $total_MO2 += $data -> MO2_FLASK + $data -> MO2_MEDIUM + $data -> MO2_STANDARD + $data -> MO2_OVERSIZE;
            $total_N2 += $data -> N2_FLASK + $data -> N2_STANDARD;
            $total_N2O += $data -> N2_FLASK + $data -> N2_STANDARD;
            $total_H += $data -> H_STANDARD;
            $total_COMPMED += $data -> COMPMED_STANDARD;
            $total_FIREEXT += $data -> FIREEXT_10LBS;
            $amount_total += $data->TOTAL;

        }


        $words = $amount_total;
        //$words =  IntToEnglish::Int2Eng($amount_total);

        view()->share([
            'statement' => $statement,
            'name' => $name,
            'logo' => $logo ,
            'address' => $address ,
            'from_date' => $from_date ,
            'words' => $words,
            'total_C2H2' => $total_C2H2 ,
            'total_AR' => $total_AR ,
            'total_CO2' => $total_CO2 ,
            'total_IO2' => $total_IO2 ,
            'total_LPG' => $total_LPG ,
            'total_MO2' => $total_MO2 ,
            'total_N2' => $total_N2 ,
            'total_N2O' => $total_N2O,
            'total_H' => $total_H ,
            'total_COMPMED' => $total_COMPMED ,
            'total_FIREEXT' => $total_FIREEXT ,
            'amount_due' =>$amount_total ,
            'sa_number' => $sa_number,
            'count' => $count ]);

        $pdf = PDF::loadView('PDF.soa_pdf', $statement);



        ob_end_clean();

        // download PDF file with download method
        return $pdf->stream('soa.pdf',array('Attachment'=>0));
    }
}
