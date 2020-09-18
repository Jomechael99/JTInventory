@extends('main')



@section('content')

    <style>

    </style>

    <div class="content-wrapper">

        <section class="content">



            <div class="box">
                <div class="box-header text-center">
                    <h3>Daily Aging Report</h3>
                </div>
                <div class="box-body text-center">
                    <div class="row-content">
                        <div class="col-12">
                            <div class="box-body">
                                <div class="box-body table-responsive">
                                    <table id="salesInvoice" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">REPORT NO</th>
                                                <th class="text-center">REPORT DATE</th>
                                                <th class="text-center">Customer_Name</th>
                                                <th class="text-center">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        @foreach($Aging->chunk(50) as $chunk)
                                            @foreach($chunk as $data)
                                            <tr>
                                                <td> {{ $data -> REPORTNO }}</td>
                                                <td> {{ $data -> REPORTDATE }}</td>
                                                <td> {{ $data -> NAME }}</td>
                                                <td> {{ $data -> BALANCE }}</td>
                                            </tr>
                                            @endforeach
                                        @endforeach
                                        </tbody>

                                    </table>

                                </div>
                             </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
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

            swal("There is {{ $cnt }} Client over 120 days of no payment today", "", "info");

            $('#salesInvoice').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'print'
                ],
                orientation: 'landscape',
                pageSize: 'A5',
                order: [[ 1, "desc" ]]
            } );
        } );
    </script>
@endsection