<table  width="100%" height="10%" >
    <tr>
        <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td>
        <td width="12%" height="5%">
            <img src="{{ $logo }}" width="100" height="120" style="margin-bottom: 50px" />
        </td>
        <td></td> <td></td> <td></td> <td></td> <td></td>
        <td width="100%">
            <h3> JAYTEE GASES INCORPORATED</h3>
            <h3>2655,Sampaguita St.,Goodwill Village 1,Tambo Paranaque City</h3>
            <h3>Tel. Nos. (02)514138 &nbsp;&nbsp; Niog (02) 8064361</h3>
        </td>
    </tr>
</table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>

<table>
    <tr>
        <td><h3>To: {{ $name }}</h3></td>
    </tr>
</table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table>
    <tr>
        <td><h3>Attention: Accounting Department</h3></td>
    </tr>
</table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table>
    <tr>
        <td><b1>Dear Sir/Mam;</b1></td>
    </tr>
</table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table><tr></tr></table><table><tr></tr></table>
<table>
    <tr>
        <td><span>Greetings of Peace. We would like to inform your good office that upon the review of you accounts receivable file , there are still unpaid accounts</span></td>
    </tr>
    <tr>
        <td><span>Our records indicate that you have an outstanding balance in the amount of <b>(php {{ number_format($amount_due, 2) }})</b>&nbsp;<b>{{ strtoupper($words) }} PESOS ONLY</b></span>
            Listed below the following Summary of accounts for your review.
        </td>
    </tr>
</table>
<br>
<br>
<table width="100%" style="text-align: center">
    <thead>
    <tr>
        <th>DATE</th>
        <th>INVOICE NO</th>
        <th>AMOUNT</th>
    </tr>
    </thead>

        <tbody class="text-center">
        <tr></tr>
        @foreach($summary as $data)
            <tr>
                <td>{{ date( 'm-d-y', strtotime($data->INVOICE_DATE) ) }}</td>
                <td>{{ $data->INVOICE_NO }}</td>
                <td>{{ number_format($data->TOTAL,2) }}</td>
            </tr>
        @endforeach
        </tbody>
</table>
<br><br><br>
<table>
    <tr>
        <td><span>Attached here with photocopies of Sales Invoices, Statement of Accoutn and Summary of Account for your easy reference.</span></td>
    </tr>
    <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>    <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
    <tr>
        <td>
            <span>
                We would appreciate if you could let us know the status of his payment. For any queries, please call us at 02-5143138; 02-4258316.
            </span>
        </td>
        <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr>
        <td>
            <span>
                Thank you very much for your prompt attention regarding this matter.
            </span>
        </td>
    </tr>
    <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>    <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
    <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>    <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
    <tr>
    <td>
            <span>
                Sincerely yours,
            </span>
    </td>
    </tr>
    <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>    <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
    <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>    <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
    <tr>
    <td>
        <span>
            Prepared By: <u>Merjorie Lubiano</u>
        </span>
    </td>
    </tr>
    <tr>
        <td>
        <span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Accounting Staff
        </span>
        </td>
    </tr>
    <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
    <tr>
        <td>
        <span>
            Reviewed By: <u>Heide Espiritu</u>
        </span>
        </td>
    </tr>
    <tr>
        <td>
        <span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Accounting Staff
        </span>
        </td>
    </tr>
</table>

