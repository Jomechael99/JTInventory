<table  width="100%" height="10%" >
    <tr>
        <td width="10%" height="5%">
            <img src="{{ $logo }}" width="100" height="150" />
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
           SA#:
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="80%">
            <b> Address : {{ $address }}</b>
        </td>
        <td style="text-align: center">
           {{ date('d-F-Y', strtotime($from_date)) }}
        </td>
    </tr>
</table>
<br>
<table width="100%" border="1" style="text-align: center">
    <thead>
        <tr>
            <th>DATE</th>
            <th>S.I</th>
            <th>DR</th>
            <th>P.O</th>
            <th>LPG(S)</th>
            <th>CO2</th>
            <th>OXY</th>
            <th>ACE</th>
            <th>AMOUNT</th>
        </tr>
    </thead>
    <tbody>
        @foreach($statement as $statement)
            <tr>
                <td>{{ $statement->INVOICE_DATE }}</td>
                <td>{{ $statement->INVOICE_NO }}</td>
                <td>-</td>
                <td>{{ $statement->PO_NO }}</td>
                <td>{{ $statement->LPG }}</td>
                <td>{{ $statement->CO2}}</td>
                <td>{{ $statement->MO2S }}</td>
                <td>{{ $statement->C2H2 }}</td>
                <td>{{ number_format($statement->TOTAL,2) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td>TOTAL</td>
        <td></td>
        <td></td>
        <td></td>
        <td>

            {{$total1 }}

        </td>
        <td>

            {{ $total2 }}

        </td>
        <td>

            {{$total3 }}

        </td>
        <td>

            {{ $total4}}

        </td>
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
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Signature Over Printed Name</td>
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
