@extends('main')

@section('content')
    @include('SalesRecord.SalesInvoice.viewinvoice')
  <div class="content-wrapper">
     <section class="content">
         @foreach(Session::get('user') as $user)
         @endforeach
         <div class="box">
           <div class="box-header">
             <div class="col-md-4" role="alert">
                 <br>
                 @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I", "1", "2")))
                 <a href="{{ route('Sales.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Sales Invoice </a>
                @endif
             </div>
           </div>
            <div class="box-body">
                <div class="box-body table-responsive">
                        <table id="salesInvoice" class="table table-bordered table-striped salesInvoice">

                            <thead>
                                <tr>
                                    <th class="text-center">INVOICE NO</th>
                                    <th class="text-center">INVOICE DATE</th>
                                    <th class="text-center">CUSTOMER NAME</th>
                                    <th class="text-center">DESIGNATION</th>
                                    <th class="text-center">CONTACT NO</th>
                                    @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I","USER LEVEL II", "1", "2" ,"3")))
                                    <th class="text-center">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                {{--@foreach($invoice_data->chunk(100) as $chunk)
                                    @foreach($chunk as $data)
                                        <tr class="text-center">
                                            <td><a href="#invoiceModal" id="invoiceData" data-toggle="modal" data-target="#invoiceModal">{{ $data->INVOICE_NO }}</a></td>
                                            <td>{{ $data->INVOICE_DATE }}</td>
                                            <td>{{ $data->NAME }}</td>
                                            <td>{{ $data->DESIGNATION }}</td>
                                            <td>{{ $data->CELL_NO }}</td>
                                            @if($user -> user_authorization == "ADMINISTRATOR" || $user->user_authorization == 1)
                                            <td class="text-center">
                                                <div class="btn-group-vertical">
                                                    <a type="button" class="btn btn-info" href="{{ route('Sales.edit', $data->ID) }}"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endforeach--}}
                            </tbody>
                        </table>
                      </div>
           </div>
         </div>
         <!-- /.row -->
       </section>
   </div>

@endsection

@section('scripts')

    <script type="text/javascript">

        $(document).ready(function(){

            var table = $('.salesInvoice').DataTable({
                processing: true,
                serverSide: true,
                bjQueryUI: true,
                ajax : {
                    url : "{{ route('sales_invoice_data') }}",
                    type : "GET",
                    dataType: 'JSON'
                },
                columns: [
                    {data: 'INVOICE_NO', name: 'a.INVOICE_NO'},
                    {data: 'INVOICE_DATE', name: 'a.INVOICE_DATE'},
                    {data: 'NAME', name: 'b.NAME'},
                    {data: 'DESIGNATION', name: 'b.DESIGNATION'},
                    {data: 'CELL_NO', name: 'b.CELL_NO'},
                    @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I","USER LEVEL II", "1", "2" ,"3")))
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                    @endif
                ]
            });

            $(document).on('click', '#invoiceData',  function(){
                var id = $(this).text();

                $.ajax({
                    url: "{{ route('invoiceModal') }}",
                    method: 'GET',
                    data:
                        {
                            'id': id,
                        },
                    success: function(response){
                        $('#Deposit').val(response.dataArray[0].Deposit.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        $('#Downpayment').val((response.dataArray[0].Downpayment).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        $('#Type').val(response.dataArray[0].Type);
                        $('#totalAmt').val(response.dataArray[0].Total.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        $('#invoiceDetails').empty();
                        $('#particularProduct').empty();
                        $('#invoiceDetails').append(response.table_data);
                        $('#particularProduct').append(response.table_data2);
                    }
                });
            });

        });


        $(document).on('click' , '.btn-cancel' , function(){
            var id = $(this).attr("data-id");

            swal({
                title: "Are you sure to cancel the invoice?",
                text: "Once cancelled, you will not be able to recover this recancelled this invoice!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type:"POST",
                            url: '{{ route('cancel_sales') }}' ,
                            data: {
                                '_token': $('input[name=_token]').val(),
                                'id' : id,
                            }, // get all form field value in serialize form
                            success: function(response){
                                /*swal.fire("Sorry this function currently not working");*/
                                if(response.status == "success"){
                                    swal("Cancellation of Invoice is Success", {
                                        icon: "success",
                                    }).then(function(){
                                        location.reload();
                                    });
                                }else{
                                    swal("Something is wrong , Please contact the developer!!", {
                                        icon: "error",
                                    })
                                }
                            }
                        });

                    } else {
                        swal("Your imaginary file is safe!");
                    }
                });
        });
    </script>

@endsection
