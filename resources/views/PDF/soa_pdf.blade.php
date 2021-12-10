<table  width="100%" height="10%" >
    <tr>
        <td width="10%" height="5%">
            <img src="{{ $logo }}" width="100" height="150" style="margin-bottom: 50px" />
        </td>
        <td width="80%">
            <b1> JAYTEE GASES INCORPORATED</b1>
            <br>
            <b1> 2655 Sampaguita Streed Goodwill Village 1</b1>
            <br>
            <b1> Tambo Paranaque</b1>
            <br>
            <b1> Telephone Nos. Niog (02) 8806-4361 (046) 431-2991</b1>
            <br>
            <b1>Sucat (02) 8781-6482</b1>
            <br>
            <b1> Paranaque (02)8851-1649,852-3764</b1>
            <br>
            <b1> Email: jaytee_gasestambo@yahoo.com</b1>
            <h1><b1> STATEMENT OF ACCOUNT</b1></h1>
            <br>
        </td>
    </tr>
</table>
<br>
<table width="100%">
    <tr>
        <td width="80%">
            <b> Customer Name : {{ $name }}</b>
        </td>
        <td style="text-align: center">
           SA#: {{ $sa_number }}
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="80%">
            <b> Address : {{ $address }}</b>
        </td>
        <td style="text-align: center">
           {{ date('d-F-Y') }}
        </td>
    </tr>
</table>
<br>
<table width="100%" border="1" style="text-align: center">
    <thead>
        <tr>
            <th>DATE</th>
            <th>INVOICE NO</th>
            <th>P.O</th>
            @foreach($count as $count)
            @endforeach
            @if($count -> C2H2 != 0)
                <th class="text-center" colspan="3">C2H2</th>
            @endif
            @if($count -> AR != 0)
                <th class="text-center" colspan="1">AR</th>
            @endif
            @if($count -> CO2 != 0)
                <th class="text-center" colspan="2">CO2</th>
            @endif
            @if($count -> IO2 != 0)
                <th class="text-center" colspan="4">IO2</th>
            @endif
            @if($count -> LPG != 0)
                <th class="text-center" colspan="3">LPG</th>
            @endif
            @if($count -> MO2 != 0)
                <th class="text-center" colspan="4">MO2</th>
            @endif
            @if($count -> N2 != 0)
                <th class="text-center" colspan="2">N2</th>
            @endif
            @if($count -> N2O != 0)
                <th class="text-center" colspan="2">N2O</th>
            @endif
            @if($count -> H != 0)
                <th class="text-center" colspan="1">H</th>
            @endif
            @if($count -> COMPMED != 0)
                <th class="text-center" colspan="1">COMPMED</th>
            @endif
            @if($count -> FIREEXT != 0)
                <th class="text-center" colspan="1">FIREEXT</th>
            @endif
            <th>AMOUNT</th>
        </tr>
    </thead>
    @foreach($statement as $data)
        <tbody class="text-center" >
        <tr class="text-center" style="font-weight: bold; background-color: lightsteelblue;">
            <td colspan>-</td>
            <td colspan>-</td>
            <td colspan>-</td>
            @if($count -> C2H2 == 0)
            @else
                @if($data -> C2H2_PRESTOLITE != 0)
                    <td class="text-center" colspan="1">PRESTOLITE</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> C2H2_MEDIUM != 0)
                    <td class="text-center" colspan="1">MEDIUM</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> C2H2_STANDARD != 0)
                    <td class="text-center" colspan="1">STANDARD</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> AR == 0)
            @else
                @if($data -> AR_STANDARD != 0)
                    <td class="text-center" colspan="1">STANDARD</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> CO2 == 0)
            @else
                @if($data -> CO2_FLASK != 0)
                    <td class="text-center" colspan="1">FLASK</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> CO2_STANDARD != 0)
                    <td class="text-center" colspan="1">STANDARD</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> IO2 == 0)

            @else
                @if($data -> IO2_FLASK != 0)
                    <td class="text-center" colspan="1">FLASK</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> IO2_MEDIUM != 0)
                    <td class="text-center" colspan="1">MEDIUM</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> IO2_STANDARD != 0)
                    <td class="text-center" colspan="1">STANDARD</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> IO2_OVERSIZE != 0)
                    <td class="text-center" colspan="1">OVERSIZE</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> LPG == 0)
            @else
                @if($data -> LPG_11KG != 0)
                    <td class="text-center" colspan="1">11KG</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> LPG_22KG != 0)
                    <td class="text-center" colspan="1">22KG</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> LPG_50KG != 0)
                    <td class="text-center" colspan="1">50KG</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> MO2 == 0)
            @else
                @if($data -> MO2_FLASK != 0)
                    <td class="text-center" colspan="1">FLASK</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> MO2_MEDIUM != 0)
                    <td class="text-center" colspan="1">MEDIUM</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> MO2_STANDARD != 0)
                    <td class="text-center" colspan="1">STANDARD</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> MO2_OVERSIZE != 0)
                    <td class="text-center" colspan="1">OVERSIZE</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> N2 == 0)
            @else
                @if($data -> N2_FLASK != 0)
                    <td class="text-center" colspan="1">FLASK</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> N2_STANDARD != 0)
                    <td class="text-center" colspan="1">STANDARD</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> N2O == 0)
            @else
                @if($data -> N2O_FLASK != 0)
                    <td class="text-center" colspan="1">FLASK</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> N2O_STANDARD != 0)
                    <td class="text-center" colspan="1">STANDARD</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> H == 0)
            @else
                @if($data -> H_STANDARD != 0)
                    <td class="text-center" colspan="1">STANDARD</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> COMPMED == 0)
            @else
                @if($data -> COMPMED_STANDARD != 0)
                    <td class="text-center" colspan="1">STANDARD</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> FIREEXT == 0)
            @else
                @if($data -> FIREEXT_10LBS != 0)
                    <td class="text-center" colspan="1">10LBS</td>
                @else
                    <td>-</td>
                @endif
            @endif
            <th class="text-center">-</th>
        </tr>
        <tr>
            <td colspan>{{ $data-> INVOICE_DATE }}</td>
            <td colspan>{{$data-> INVOICE_NO}}</td>
            <td colspan>{{$data-> PO_NO}}</td>
            @if($count -> C2H2 == 0)
            @else
                @if($data -> C2H2_PRESTOLITE != 0)
                    <td class="text-center" colspan="1">{{$data -> C2H2_PRESTOLITE}}</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> C2H2_MEDIUM != 0)
                    <td class="text-center" colspan="1">{{$data -> C2H2_MEDIUM}}</td>
                @else
                    <td>-</td>
                @endif

                @if($data -> C2H2_STANDARD != 0)
                    <td class="text-center" colspan="1">{{$data -> C2H2_STANDARD}}</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> AR == 0)
            @else
                @if($data -> AR_STANDARD != 0)
                    <td class="text-center" colspan="1">{{ $data -> AR_STANDARD }}</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> CO2 == 0)
            @else
                @if($data -> CO2_FLASK != 0)
                    <td class="text-center" colspan="1">{{ $data -> CO2_FLASK }}</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> CO2_STANDARD != 0)
                    <td class="text-center" colspan="1">{{ $data -> CO2_STANDARD }}</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> IO2 == 0)

            @else
                @if($data -> IO2_FLASK != 0)
                    <td class="text-center" colspan="1">{{$data -> IO2_FLASK}}</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> IO2_MEDIUM != 0)
                    <td class="text-center" colspan="1">{{$data -> IO2_MEDIUM}}</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> IO2_STANDARD != 0)
                    <td class="text-center" colspan="1">{{$data -> IO2_STANDARD}}</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> IO2_OVERSIZE != 0)
                    <td class="text-center" colspan="1">{{$data -> IO2_OVERSIZE}}</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> LPG == 0)
            @else
                @if($data -> LPG_11KG != 0)
                    <td class="text-center" colspan="1">{{$data -> LPG_11KG}}</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> LPG_22KG != 0)
                    <td class="text-center" colspan="1">{{$data -> LPG_22KG}}</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> LPG_50KG != 0)
                    <td class="text-center" colspan="1">{{$data -> LPG_50KG}}</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> MO2 == 0)
            @else
                @if($data -> MO2_FLASK != 0)
                    <td class="text-center" colspan="1">{{$data -> MO2_FLASK}}</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> MO2_MEDIUM != 0)
                    <td class="text-center" colspan="1">{{$data -> MO2_MEDIUM}}</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> MO2_STANDARD != 0)
                    <td class="text-center" colspan="1">{{$data -> MO2_STANDARD}}</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> MO2_OVERSIZE != 0)
                    <td class="text-center" colspan="1">{{$data -> MO2_OVERSIZE}}</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> N2 == 0)
            @else
                @if($data -> N2_FLASK != 0)
                    <td class="text-center" colspan="1">{{$data -> N2_FLASK}}</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> N2_STANDARD != 0)
                    <td class="text-center" colspan="1">{{$data -> N2_STANDARD}}</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> N2O == 0)
            @else
                @if($data -> N2O_FLASK != 0)
                    <td class="text-center" colspan="1">{{$data -> N2O_FLASK}}</td>
                @else
                    <td>-</td>
                @endif
                @if($data -> N2O_STANDARD != 0)
                    <td class="text-center" colspan="1">{{$data -> N2O_STANDARD}}</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> H == 0)
            @else
                @if($data -> H_STANDARD != 0)
                    <td class="text-center" colspan="1">{{$data -> H_STANDARD}}</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> COMPMED == 0)
            @else
                @if($data -> COMPMED_STANDARD != 0)
                    <td class="text-center" colspan="1">{{$data -> COMPMED_STANDARD}}</td>
                @else
                    <td>-</td>
                @endif
            @endif
            @if($count -> FIREEXT == 0)
            @else
                @if($data -> FIREEXT_10LBS != 0)
                    <td class="text-center" colspan="1">{{$data -> FIREEXT_10LBS}}</td>
                @else
                    <td>-</td>
                @endif
            @endif
            <th class="text-center">{{ number_format($data -> TOTAL, 2) }}</th>
        </tr>
        </tbody>
    @endforeach
    <tfoot>
    <tr>
        <td>TOTAL</td>
        <td>-</td>
        <td>-</td>
        @if($count -> C2H2 != 0)
            <td colspan="3">{{ $total_C2H2 }}</td>
        @endif
        @if($count -> AR != 0)
            <td colspan="1">{{ $total_AR }}</td>
        @endif
        @if($count -> CO2 != 0)
            <td colspan="2">{{ $total_CO2 }}</td>
        @endif
        @if($count -> IO2 != 0)
            <td colspan="4">{{ $total_IO2 }}</td>
        @endif
        @if($count -> LPG != 0)
            <td colspan="3">{{ $total_LPG }}</td>
        @endif
        @if($count -> MO2 != 0)
            <td colspan="4">{{ $total_MO2 }}</td>
        @endif
        @if($count -> N2 != 0)
            <td colspan="2">{{ $total_N2 }}</td>
        @endif
        @if($count -> N2O != 0)
            <td colspan="2">{{ $total_N2O }}</td>
        @endif
        @if($count -> H != 0)
            <td colspan="1">{{ $total_H }}</td>
        @endif
        @if($count -> COMPMED != 0)
            <td colspan="1">{{ $total_COMPMED }}</td>
        @endif
        @if($count -> FIREEXT != 0)
            <td colspan="1">{{ $total_FIREEXT }}</td>
        @endif
        <td>
            {{ number_format($amount_due, 2) }}
        </td>
    </tr>

    </tfoot>
</table>
<br>
<table>
    <tr>
        <td> <h2><b> PESOS: &nbsp;&nbsp;&nbsp; {{ strtoupper($words) }} PESOS ONLY </b> </h2></td>
    </tr>
</table>
<table>
    <tr>
        <td> The above is a statement of your account as it appears in</td>
    </tr>
    <tr>
        <td> our books as of the date indicated. Should your records</td>
    </tr>
        <td> disagree with our statement, please advise us immediately</td>
    <tr>
        <td> Kindly make all checks payable to <b>JAYTEE GASES, INC.</b></td>
    </tr>
</table>
<br>
<table>
    <tr>
        <td> Received copy with original</td>
    </tr>
</table>
<br>
<table style="width: 30%;float: left">
    <tr>
        <td> By:_____________________________</td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature Over Printed Name</td>
    </tr>
</table>
<table border="1" style="width: 70%; height: 5%; float: left; text-align: center">
       <td> <br>___________________<br> Maker </td>
       <td> <br>___________________<br>  Checker </td>
       <td>  <br>___________________<br> Credit & Collection </td>
</table>


<table>
    <tr>
        <td> Date:_____________________ </td>
    </tr>
</table>
