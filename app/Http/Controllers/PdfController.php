<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;
use SujalPatel\IntToEnglish\IntToEnglish;
use Illuminate\Support\Facades\Storage;

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

    public function view_pdf(Request $request){

        $id = $request -> id;
        $from_date = $request -> from_date;
        $to_date =$request -> to_date;
        $sa_number = $request-> sa_number;

        DB::table('statement_account_pdf')->truncate();

        $sales_invoice = db::table('sales_invoice as a')
            ->select('a.INVOICE_NO as REPORTNO', 'a.INVOICE_DATE as REPORTDATE', db::raw('(TOTAL - DOWNPAYMENT) as TOTAL'),'b.PO_NO')
            ->selectRaw(" 'INVOICE' as TYPE")
            ->join('sales_invoice_po as b', 'a.INVOICE_NO', '=', 'b.INVOICE_NO')
            ->where('a.CLIENT_ID', $id)
            ->where('a.STATUS', "1")
            ->where('a.FULLY_PAID', "0")
            ->whereBetween('a.INVOICE_DATE', [$from_date, $to_date]);

        $delivery = db::table('delivery_receipt as a')
            ->select('a.DR_NO as REPORTNO', 'a.DR_DATE as REPORTDATE', db::raw('(TOTAL - DOWNPAYMENT) as TOTAL'),'b.PO_NO')
            ->selectRaw(" 'DR' as TYPE")
            ->join('delivery_receipt_po as b', 'a.DR_NO', '=', 'b.DR_NO')
            ->where('a.CLIENT_ID', $id)
            ->where('a.STATUS', "1")
            ->where('a.AS_INVOICE', "1")
            ->where('a.FULLY_PAID', "0")
            ->whereBetween('a.DR_DATE', [$from_date, $to_date])
            ->unionAll($sales_invoice)
            ->get();

        foreach($delivery as $data){

            if($data -> TYPE == "INVOICE"){

                $sales_product = db::table('sales_invoice_order')
                    ->where('INVOICE_NO', $data -> REPORTNO)
                    ->get();

                $C2H2_PRESTOLITE = 0;
                $C2H2_MEDIUM = 0;
                $C2H2_STANDARD = 0;
                $AR_STANDARD = 0;
                $CO2_FLASK = 0;
                $CO2_STANDARD = 0;
                $IO2_FLASK = 0;
                $IO2_MEDIUM = 0;
                $IO2_STANDARD = 0;
                $IO2_OVERSIZE = 0;
                $LPG_11KG = 0;
                $LPG_22KG = 0;
                $LPG_50KG = 0;
                $MO2_FLASK = 0;
                $MO2_MEDIUM = 0;
                $MO2_STANDARD = 0;
                $MO2_OVERSIZE = 0;
                $N2_FLASK = 0;
                $N2_STANDARD = 0;
                $N2O_FLASK = 0;
                $N2O_STANDARD = 0;
                $H_STANDARD = 0;
                $COMPMED_STANDARD = 0;
                $FIREEXT_10LBS = 0;

                foreach($sales_product as $product){

                    if($product ->PRODUCT == "C2H2" || $product ->PRODUCT == "ACETYLENE"){
                        /* $C2H2 +=  (int)$product -> QTY ;*/
                        if($product -> SIZE == "PRESTOLITE"){
                            $C2H2_PRESTOLITE += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "MEDIUM"){
                            $C2H2_MEDIUM += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "STANDARD"){
                            $C2H2_STANDARD += (int)$product -> QTY ;
                        }
                    }
                    if($product ->PRODUCT == "AR" || $product ->PRODUCT == "ARGON"){
                        $AR_STANDARD +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "CO2" || $product ->PRODUCT == "CARBON DIOXIDE"){
                        if($product -> SIZE == "FLASK"){
                            $CO2_FLASK += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "STANDARD"){
                            $CO2_STANDARD += (int)$product -> QTY ;
                        }
                    }
                    if($product ->PRODUCT == "IO2" || $product ->PRODUCT == "INDUSTRIAL OXYGEN"){
                        if($product -> SIZE == "FLASK"){
                            $IO2_FLASK += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "MEDIUM"){
                            $IO2_MEDIUM += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "STANDARD"){
                            $IO2_STANDARD += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "OVERSIZE"){
                            $IO2_OVERSIZE += (int)$product -> QTY ;
                        }
                    }
                    if($product -> PRODUCT == "LPG"){
                        if($product -> SIZE == "11KG"){
                            $LPG_11KG +=  (int)$product -> QTY ;
                        }elseif($product -> SIZE == "22KG"){
                            $LPG_22KG +=  (int)$product -> QTY ;
                        }elseif($product -> SIZE == "50KG"){
                            $LPG_50KG +=  (int)$product -> QTY ;
                        }
                    }
                    if($product ->PRODUCT == "MO2" || $product ->PRODUCT == "MEDICAL OXYGEN"){
                        if($product -> SIZE == "FLASK"){
                            $MO2_FLASK += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "MEDIUM"){
                            $MO2_MEDIUM += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "STANDARD"){
                            $MO2_STANDARD += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "OVERSIZE"){
                            $MO2_OVERSIZE += (int)$product -> QTY ;
                        }
                    }
                    if($product ->PRODUCT == "N2" || $product ->PRODUCT == "NITROGEN"){
                        if($product -> SIZE == "FLASK"){
                            $N2_FLASK += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "STANDARD"){
                            $N2_STANDARD += (int)$product -> QTY ;
                        }
                    }
                    if($product ->PRODUCT == "N2O" || $product ->PRODUCT == "NITROUS OXIDE"){
                        if($product -> SIZE == "FLASK"){
                            $N2O_FLASK += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "STANDARD"){
                            $N2O_STANDARD += (int)$product -> QTY ;
                        }
                    }
                    if($product ->PRODUCT == "H" || $product ->PRODUCT == "HYDROGEN"){
                        $H_STANDARD +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "COMPMED" || $product ->PRODUCT == "COMPRESSED AIR"){
                        $COMPMED_STANDARD +=  (int)$product -> QTY ;
                    }

                    if($product -> PRODUCT == "FIREEXT" || $product -> PRODUCT == "FIRE EXTINGUISHER"){
                        $FIREEXT_10LBS += (int)$product -> QTY;
                    }

                    $totalOther2 = 0;

                    $sales_other = db::table('other_charges')
                        ->select('QUANTITY', 'UNIT_PRICE')
                        ->where('INVOICE_NO', $product -> INVOICE_NO)
                        ->get();

                    foreach($sales_other as $other_price){
                        $totalOther2 = $totalOther2 + ($other_price -> UNIT_PRICE * $other_price -> QUANTITY);
                    }

                }

                $sales_invoice_report = array([
                    'INVOICE_NO' => $data -> REPORTNO,
                    'INVOICE_DATE' => $data -> REPORTDATE,
                    'PO_NO' => $data -> PO_NO,
                    'C2H2_PRESTOLITE'  => $C2H2_PRESTOLITE,
                    'C2H2_MEDIUM'  => $C2H2_MEDIUM,
                    'C2H2_STANDARD'  => $C2H2_STANDARD,
                    'AR_STANDARD' => $AR_STANDARD,
                    'CO2_FLASK' => $CO2_FLASK,
                    'CO2_STANDARD' => $CO2_STANDARD,
                    'IO2_FLASK' => $IO2_FLASK,
                    'IO2_MEDIUM' => $IO2_MEDIUM,
                    'IO2_STANDARD' => $IO2_STANDARD,
                    'IO2_OVERSIZE' => $IO2_OVERSIZE,
                    'LPG_11KG' => $LPG_11KG,
                    'LPG_22KG' => $LPG_22KG,
                    'LPG_50KG' => $LPG_50KG,
                    'MO2_FLASK' => $MO2_FLASK,
                    'MO2_MEDIUM' => $MO2_MEDIUM,
                    'MO2_STANDARD' => $MO2_STANDARD,
                    'MO2_OVERSIZE' => $MO2_OVERSIZE,
                    'N2_FLASK' => $N2_FLASK,
                    'N2_STANDARD' => $N2_STANDARD,
                    'N2O_FLASK' => $N2O_FLASK,
                    'N2O_STANDARD' => $N2O_STANDARD,
                    'H_STANDARD' => $H_STANDARD,
                    'COMPMED_STANDARD' => $COMPMED_STANDARD,
                    'FIREEXT_10LBS' => $FIREEXT_10LBS,
                    'TOTAL' => $data -> TOTAL + $totalOther2
                ]);

                db::table('statement_account_pdf')
                    ->insert($sales_invoice_report);

            }elseif($data->TYPE == "DR"){

                $delivery_product = db::table('delivery_receipt_order')
                    ->where('INVOICE_NO', $data -> REPORTNO)
                    ->get();

                $C2H2_PRESTOLITE = 0;
                $C2H2_MEDIUM = 0;
                $C2H2_STANDARD = 0;
                $AR_STANDARD = 0;
                $CO2_FLASK = 0;
                $CO2_STANDARD = 0;
                $IO2_FLASK = 0;
                $IO2_MEDIUM = 0;
                $IO2_STANDARD = 0;
                $IO2_OVERSIZE = 0;
                $LPG_11KG = 0;
                $LPG_22KG = 0;
                $LPG_50KG = 0;
                $MO2_FLASK = 0;
                $MO2_MEDIUM = 0;
                $MO2_STANDARD = 0;
                $MO2_OVERSIZE = 0;
                $N2_FLASK = 0;
                $N2_STANDARD = 0;
                $N2O_FLASK = 0;
                $N2O_STANDARD = 0;
                $H_STANDARD = 0;
                $COMPMED_STANDARD = 0;
                $FIREEXT_10LBS = 0;

                foreach($sales_product as $product){

                    if($product ->PRODUCT == "C2H2" || $product ->PRODUCT == "ACETYLENE"){
                        if($product -> SIZE == "PRESTOLITE"){
                            $C2H2_PRESTOLITE += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "MEDIUM"){
                            $C2H2_MEDIUM += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "STANDARD"){
                            $C2H2_STANDARD += (int)$product -> QTY ;
                        }
                    }
                    if($product ->PRODUCT == "AR" || $product ->PRODUCT == "ARGON"){
                        $AR_STANDARD +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "CO2" || $product ->PRODUCT == "CARBON DIOXIDE"){
                        if($product -> SIZE == "FLASK"){
                            $CO2_FLASK += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "STANDARD"){
                            $CO2_STANDARD += (int)$product -> QTY ;
                        }
                    }
                    if($product ->PRODUCT == "IO2" || $product ->PRODUCT == "INDUSTRIAL OXYGEN"){
                        if($product -> SIZE == "FLASK"){
                            $IO2_FLASK += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "MEDIUM"){
                            $IO2_MEDIUM += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "STANDARD"){
                            $IO2_STANDARD += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "OVERSIZE"){
                            $IO2_OVERSIZE += (int)$product -> QTY ;
                        }
                    }
                    if($product -> PRODUCT == "LPG"){
                        if($product -> SIZE == "11KG"){
                            $LPG_11KG +=  (int)$product -> QTY ;
                        }elseif($product -> SIZE == "22KG"){
                            $LPG_22KG +=  (int)$product -> QTY ;
                        }elseif($product -> SIZE == "50KG"){
                            $LPG_50KG +=  (int)$product -> QTY ;
                        }
                    }
                    if($product ->PRODUCT == "MO2" || $product ->PRODUCT == "MEDICAL OXYGEN"){
                        if($product -> SIZE == "FLASK"){
                            $MO2_FLASK += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "MEDIUM"){
                            $MO2_MEDIUM += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "STANDARD"){
                            $MO2_STANDARD += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "OVERSIZE"){
                            $MO2_OVERSIZE += (int)$product -> QTY ;
                        }
                    }
                    if($product ->PRODUCT == "N2" || $product ->PRODUCT == "NITROGEN"){
                        if($product -> SIZE == "FLASK"){
                            $N2_FLASK += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "STANDARD"){
                            $N2_STANDARD += (int)$product -> QTY ;
                        }
                    }
                    if($product ->PRODUCT == "N2O" || $product ->PRODUCT == "NITROUS OXIDE"){
                        if($product -> SIZE == "FLASK"){
                            $N2O_FLASK += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "STANDARD"){
                            $N2O_STANDARD += (int)$product -> QTY ;
                        }
                    }
                    if($product ->PRODUCT == "H" || $product ->PRODUCT == "HYDROGEN"){
                        $H_STANDARD +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "COMPMED" || $product ->PRODUCT == "COMPRESSED AIR"){
                        $COMPMED_STANDARD +=  (int)$product -> QTY ;
                    }

                    if($product -> PRODUCT == "FIREEXT" || $product -> PRODUCT == "FIRE EXTINGUISHER"){
                        $FIREEXT_10LBS += (int)$product -> QTY;
                    }

                    $totalOther2 = 0;

                    $sales_other = db::table('other_charges')
                        ->select('QUANTITY', 'UNIT_PRICE')
                        ->where('INVOICE_NO', $product -> INVOICE_NO)
                        ->get();

                    foreach($sales_other as $other_price){
                        $totalOther2 = $totalOther2 + ($other_price -> UNIT_PRICE * $other_price -> QUANTITY);
                    }

                }

                $sales_invoice_report = array([
                    'INVOICE_NO' => $data -> REPORTNO,
                    'INVOICE_DATE' => $data -> REPORTDATE,
                    'PO_NO' => $data -> PO_NO,
                    'C2H2_PRESTOLITE'  => $C2H2_PRESTOLITE,
                    'C2H2_MEDIUM'  => $C2H2_MEDIUM,
                    'C2H2_STANDARD'  => $C2H2_STANDARD,
                    'AR_STANDARD' => $AR_STANDARD,
                    'CO2_FLASK' => $CO2_FLASK,
                    'CO2_STANDARD' => $CO2_STANDARD,
                    'IO2_FLASK' => $IO2_FLASK,
                    'IO2_MEDIUM' => $IO2_MEDIUM,
                    'IO2_STANDARD' => $IO2_STANDARD,
                    'IO2_OVERSIZE' => $IO2_OVERSIZE,
                    'LPG_11KG' => $LPG_11KG,
                    'LPG_22KG' => $LPG_22KG,
                    'LPG_50KG' => $LPG_50KG,
                    'MO2_FLASK' => $MO2_FLASK,
                    'MO2_MEDIUM' => $MO2_MEDIUM,
                    'MO2_STANDARD' => $MO2_STANDARD,
                    'MO2_OVERSIZE' => $MO2_OVERSIZE,
                    'N2_FLASK' => $N2_FLASK,
                    'N2_STANDARD' => $N2_STANDARD,
                    'N2O_FLASK' => $N2O_FLASK,
                    'N2O_STANDARD' => $N2O_STANDARD,
                    'H_STANDARD' => $H_STANDARD,
                    'COMPMED_STANDARD' => $COMPMED_STANDARD,
                    'FIREEXT_10LBS' => $FIREEXT_10LBS,
                    'TOTAL' => $data -> TOTAL + $totalOther2
                ]);

                db::table('statement_account_pdf')
                    ->insert($sales_invoice_report);
            }

        }

        $statement = db::table('statement_account_pdf')
            ->get();

        $C2H2 = 0;
        $CO2 = 0;
        $IO2 = 0;
        $LPG = 0;
        $MO2 = 0;
        $N2 = 0;
        $N2O = 0;
        $AR = 0;
        $H = 0;
        $COMPMED = 0;
        $FIREEXT = 0;

        db::table('statement_count')
            ->truncate();

        foreach($statement as $data){

            if($data -> C2H2_PRESTOLITE != 0){
                $C2H2 += 1;
            }
            if($data -> C2H2_MEDIUM != 0){
                $C2H2 += 1;
            }
            if($data -> C2H2_STANDARD != 0){
                $C2H2 += 1;
            }
            if($data-> CO2_FLASK != 0){
                $CO2 += 1;
            }
            if($data -> CO2_STANDARD != 0){
                $CO2 += 1;
            }
            if($data -> IO2_FLASK != 0){
                $IO2 += 1;
            }
            if($data -> IO2_MEDIUM != 0){
                $IO2 += 1;
            }
            if($data -> IO2_STANDARD != 0){
                $IO2 += 1;
            }
            if($data -> IO2_OVERSIZE != 0){
                $IO2 += 1;
            }
            if($data -> LPG_11KG != 0){
                $LPG += 1;
            }
            if($data -> LPG_22KG != 0){
                $LPG += 1;
            }
            if($data -> LPG_50KG != 0){
                $LPG += 1;
            }
            if($data -> MO2_FLASK != 0){
                $MO2 += 1;
            }
            if($data -> MO2_MEDIUM != 0){
                $MO2 += 1;
            }
            if($data -> MO2_STANDARD != 0){
                $MO2 += 1;
            }
            if($data -> MO2_OVERSIZE != 0){
                $MO2 += 1;
            }
            if($data-> N2_FLASK != 0){
                $N2 += 1;
            }
            if($data -> N2_STANDARD != 0){
                $N2 += 1;
            }
            if($data-> N2O_FLASK != 0){
                $N2O += 1;
            }
            if($data -> N2O_STANDARD != 0){
                $N20 += 1;
            }
            if($data -> AR_STANDARD != 0){
                $AR += 1;
            }
            if($data -> H_STANDARD != 0){
                $H += 1;
            }
            if($data -> COMPMED_STANDARD != 0){
                $COMPMED += 1;
            }
            if($data -> FIREEXT_10LBS != 0){
                $FIREEXT += 1;
            }
        }

        db::table('statement_count')
            ->insert([
                'C2H2' => $C2H2 >= 4 ? 3 : $C2H2,
                'CO2' => $CO2 >= 2 ? 2 : $CO2,
                'IO2' => $IO2,
                'LPG' => $LPG,
                'MO2' => $MO2,
                'N2' => $N2,
                'N2O' => $N2O,
                'AR' => $AR,
                'H' => $H,
                'COMPMED' => $COMPMED,
                'FIREEXT' => $FIREEXT >= 1 ? 1 : $FIREEXT,
            ]);


        $statement_count = db::table('statement_count')
            ->get();

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
