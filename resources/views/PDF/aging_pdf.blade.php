<table>
    <tr style="font-size: 20px" WIDTH="50%">
        <td width="25%"></td>
        <td width="25%"><b><center> JAMGASCO INCORPORATED </center> </b></td>
        <td width="25%"></td>
    </tr>
    {{-- <tr style="font-size: 20px">
        <td width=""><b></b></td>
        <td width="90%"><b> <center>#9005 Amethyst St., New Cavite Industrial City, Manggahan, General Trias, Cavite </center> </b></td>
        <td width="5%"><b></b></td>
    </tr>
    <tr style="font-size: 20px">
        <td width="5"><b></b></td>
        <td><b> <center> Tel No : (046) 686-7966, (046) 686-2661, (02) 475-4557 </center> </b></td>
        <td width="5"><b></b></td>
    </tr> --}}
  </table>
  <table width="100%">
    <tr style="font-size: 20px">
        <td width="5%"><b></b></td>
        <td width="90%"><b> <center>#9005 Amethyst St., New Cavite Industrial City, Manggahan, General Trias, Cavite </center> </b></td>
        <td width="5%"><b></b></td>
    </tr>
  </table>
  <table width="100%">
    <tr style="font-size: 20px">
        <td width="5"><b></b></td>
        <td><b> <center> Tel No : (046) 686-7966, (046) 686-2661, (02) 475-4557 </center> </b></td>
        <td width="5"><b></b></td>
    </tr>
  </table>
  <hr style="border: 0;
  border-top: 3px solid #094CFA;">
  
  <br>
  <table>
      <tr style="font-size: 20px"> <td>{{ date('d-F-y') }}</td></tr>
  </table>
  <br>
  <table>
      <tr style="font-size: 20px"> <td><b> JAYTEE GASES INCORPORATED </b></td></tr>
  </table>
  <table>
    <tr style="font-size: 20px"> <td> NIOG 11, BACOOR CAVITE </td></tr>
  </table>
  <br>
  <table>
    <tr style="font-size: 20px"> <td> ATTENTION: &nbsp;&nbsp;&nbsp; Accounting Dept. </td></tr>
  </table>
  <br>
  <table>
    <tr style="font-size: 20px"> <td> RE: &nbsp;&nbsp;&nbsp; AGING OF ACCOUNT RECEIVABLES </td></tr>
  </table>
  <br>
  <table>
    <tr style="font-size: 20px"> <td> Terms: &nbsp;&nbsp;&nbsp; 30 DAYS </td></tr>
  </table>

  <style>
    thead th {border-bottom: 3px solid #333; text-align: center; font-weight: bold;
        border-top: 3px solid #333; text-align: center; font-weight: bold;
        }
    tbody {
        text-align: center;
    }
    tfoot tr td{
        border-bottom: 3px solid #333; text-align: center; font-weight: bold;
        border-top: 3px solid #333; text-align: center; font-weight: bold;
    }
  </style>

  <table width="100%">
    <thead>
      <tr>
          <th><b>Date</b></th>
          <th><b>INVOICE</b></th>
          <th><b>0-30</b></th>
          <th><b>31-60</b></th>
          <th><b>61-90</b></th>
          <th><b>Over 90</b></th>
          <th><b>Amount Due</b></th>
      </tr>
    </thead>
      <tbody>
            @foreach($delivery as $data)
                <tr>
                    <td> {{ $data -> REPORTDATE }}</td>
                    <td> {{ $data -> REPORTNO }}{{$data->REPORTTYPE}}</td>
                    <td>
                        @if($data -> AGING <= 30)
                            {{ number_format($data -> BALANCE, 2) }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($data -> AGING > 30 && $data -> AGING <= 60)
                            {{ number_format($data -> BALANCE, 2) }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($data -> AGING > 60 && $data -> AGING <= 90)
                            {{number_format($data -> BALANCE, 2) }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($data -> AGING > 90)
                            {{ number_format($data -> BALANCE, 2) }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        {{ number_format($data -> BALANCE, 2) }}
                    </td>
                </tr>
            @endforeach
      </tbody>
      <tfoot>
                <tr>
                    <td>TOTAL</td>
                    <td></td>
                    <td>
            
                        {{ number_format($total1, 2) }}
                      
                    </td>
                    <td>
                       
                        {{ number_format($total2, 2) }}
                        
                    </td>
                    <td>
                       
                        {{number_format($total3, 2) }}
                    
                    </td>
                    <td>
                      
                        {{ number_format($total4, 2) }}
                    
                    </td>
                    <td>
                        {{ number_format($amount_due, 2) }}
                    </td>
                </tr>
          
      </tfoot> 
  </table>
  <br>
  <table>
    <tr style="font-size: 20px"> <td> Please settle your overdue accounts. Your prompt action will be highly appreciated. </td></tr>
  </table>
  <table>
    <tr style="font-size: 20px"> <td> Disregard this notice if payment has been made. </td></tr>
  </table>
  <br>
  <br>

  <table width="100% ">
    <tr style="font-size: 20px"> 
        <td width="50%"> Prepared by:  </td>
        <td> Received by:  </td>
    </tr>
    
  </table>
  <table  width="100% ">
    <tr style="font-size: 20px"> 
        <td width="50%"> ___________________  </td>
        <td> ___________________  </td>
    </tr>
  </table>
  <table  width="100% ">
    <tr style="font-size: 20px"> 
        <td width="50%"> Accounting Department  </td>
        <td width="50%"> &nbsp;  </td>
    </tr>
  </table>