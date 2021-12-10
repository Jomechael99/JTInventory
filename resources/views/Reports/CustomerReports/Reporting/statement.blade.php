@extends('main')

@section('content')

    <style>
        .btn-validate{
            display:inline-block;
            text-align:center;
        }
        .lbl {
            display:block;
        }
        .select2 {
            width:100%!important;
            height:100%!important;
        }
    </style>

    <div class="content-wrapper">

        <section class="content">
            <div class="box">
                <div class="box-header text-center">
                    <span> Statement of Account </span>
                </div>
                <div class="box-body">
                    <div class="box-body table-responsive">
                        <span> <a href="{{ route('soa_pdf_print', ['id' => $id , 'from_date' => $from_date , 'to_date' => $to_date , 'sa_number' => $sa_number]) }}" class="btn btn-info"> Download PDF </a> </span>
                        <table id="salesInvoice" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                @foreach($count as $count)
                                @endforeach
                                <th class="text-center">REPORT NO</th>
                                <th class="text-center">REPORT DATE</th>
                                <th class="text-center">REPORT PO</th>
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
                                <th class="text-center">TOTAL</th>
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
                        </table>
                    </div>
                </div>

            </div>

            <!-- /.row -->
        </section>

    </div>

@endsection


@section('scripts')

    <script>
        $(document).ready(function() {

            $('#salesInvoice').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                   'excel',
                ],
                paging: 'false',
                sorting: 'false',
                orientation: 'landscape',
                pageSize: 'A5',
            } );

        } );

        var td1 = 0;

        $('.valueBody').each(function () {
            td1 = td1 + parseFloat($(this).find('.td1').text());
        })


    </script>

@endsection
