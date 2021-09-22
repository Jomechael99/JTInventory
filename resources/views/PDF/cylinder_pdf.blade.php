<table  width="100%">
    <tr>
        <td width="10%">
            <img src="{{ $logo }}" width="100" height="100" />
        </td>
        <td style="text-align: center">
            <b> JAYTEE GASES INCORPORATED</b>
            <br>
            <b> Statement of Cylinder Balance</b>
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
            <b> {{ date('F d Y h:i:s a ') }}</b>
        </td>
    </tr>
</table>
<br>
<table width="100%" border="1">
    <thead>
        <tr>
            <th>Invoice Date</th>
            <th>Invoice No</th>
            <th>CLC No</th>
            <th>ICR No</th>
            <th colspan="3">Acetylene</th>
            <th colspan="3">Industrial Oxygen</th>
            <th colspan="3">LPG</th>
        </tr>
    </thead>
    <thead>
    <tr>
        <th colspan="4">****Size****</th>
        <th colspan="3">Standard</th>
        <th colspan="3">Standard</th>
        <th colspan="3">11Kg</th>
    </tr>
    </thead>
    <thead>
    <tr>
        <th colspan="4">****Size****</th>
        <th colspan="1">Delivery</th>
        <th colspan="1">Pickup</th>
        <th colspan="1">Balance</th>
        <th colspan="1">Delivery</th>
        <th colspan="1">Pickup</th>
        <th colspan="1">Balance</th>
        <th colspan="1">Delivery</th>
        <th colspan="1">Pickup</th>
        <th colspan="1">Balance</th>
    </tr>
    </thead>
    <tbody>
        @foreach($cylinder as $cylinder)
            <tr>
                <td>{{ $cylinder->INVOICE_DATE }}</td>
                <td>{{ $cylinder->INVOICE_NO }}</td>
                <td>{{ $cylinder->CLC_NO }}</td>
                <td>{{ $cylinder->ICR_NO }}</td>
                <td>{{ $cylinder->C2H2_STANDARD_DELIVER }}</td>
                <td>{{ $cylinder->C2H2_STANDARD_PICKUP }}</td>
                <td>{{ $cylinder->C2H2_STANDARD_BALANCE }}</td>
                <td>{{ $cylinder->IO2_STANDARD_DELIVER }}</td>
                <td>{{ $cylinder->IO2_STANDARD_PICKUP }}</td>
                <td>{{ $cylinder->IO2_STANDARD_BALANCE }}</td>
                <td>{{ $cylinder->LPG_11KG_DELIVER }}</td>
                <td>{{ $cylinder->LPG_11KG_PICKUP }}</td>
                <td>{{ $cylinder->LPG_11KG_BALANCE }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
