@extends('main')

@section('content')
    <style>
        .select2 {
            width:100%!important;
        }
    </style>

    <div class="content-wrapper">
        @foreach(Session::get('user') as $user)
        @endforeach
        <section class="content">
            <div class="box">
                <div class="box-header">
                    @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I", "1", "2")))
                    <div class="col-md-4" role="alert">
                        <a href="{{ route('DeliverSales.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Delivery as Invoice</a>

                        <button type="button" class="btn btn-block btn-warning btn-flat pull-right" data-toggle="modal" data-target="#cancelInvoice">
                            Cancel Invoice
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="cancelInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Cancellation of Invoice</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <label>DR No: </label>
                                        <input type="number" id="invoice_number" class="form-control" value="" autocomplete="off">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary cancelInvoice">Cancel Invoice</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endif
                </div>
                <div class="box-body table-responsive">
                    <table id="deliveryInvoice" class="table table-bordered table-striped">

                        <thead>
                        <th class="text-center"> Delivery No. </th>
                        <th class="text-center"> Delivery Date. </th>
                        <th class="text-center"> Customer Name </th>
                        @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I","USER LEVEL II", "1", "2" ,"3")))
                            <th class="text-center"> Actions </th>
                        @endif
                        </thead>
                        <tbody class="text-center">
                        {{--@foreach($deliver_invoice as $deliver_invoice)
                            <tr class="text-center">
                                <td> {{ $deliver_invoice -> DR_NO }}</td>
                                <td> {{ $deliver_invoice -> DR_DATE }}</td>
                                <td> {{ $deliver_invoice -> NAME }}</td>
                                @if($user -> user_authorization == "ADMINISTRATOR" || $user->user_authorization == 1)
                                    <td>
                                        <a type="button" class="btn btn-info" href="{{ route('DeliverSales.edit', $deliver_invoice->ID) }}"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach--}}
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.row -->
        </section>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function(){

            $('.poNo').select2({
                placeholder: 'Select an option',
                dropdownAutoWidth: true,
            });

            var table = $('#deliveryInvoice').DataTable({
                processing: true,
                serverSide: true,
                bjQueryUI: true,
                ajax : {
                    url : "{{ route('delivery_sales_data') }}",
                    type : "GET",
                    dataType: 'JSON'
                },
                columns: [
                    {data: 'DR_NO', name: 'a.DR_NO'},
                    {data: 'DR_DATE', name: 'a.DR_DATE'},
                    {data: 'NAME', name: 'b.NAME'},
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

            $(document).on('click', '.cancelInvoice',  function(){
                var id = $('#invoice_number').val();

                $.ajax({
                    url: "{{ route('cancelInvoice') }}",
                    method: 'GET',
                    data:
                        {
                            'id': id,
                            'type': 'delivery'
                        },
                    success: function(response){
                        swal("Cancellation of Invoice is Success", {
                            icon: "success",
                        });
                        $('#invoice_number').val("");
                    }
                });
            });

            $('#invoiceValidate').on('click', function(){
                var deliveryNo = $('#deliveryNo').val();
                var buttonVal = $('#invoiceValidate').val();

                $.ajax({
                    url: "/noValidate",
                    type: "POST",
                    data:{
                        '_token': $('input[name=_token]').val(),
                        'invoiceNo' : deliveryNo,
                        'buttonVal' : buttonVal
                    },
                    success: function(response){

                        if(response.status == "empty"){
                            $('#status').text("No Record Found");
                            $('#status').css("color", "red");
                            $('#status').css('font-size', '12px');
                            $('#issuedBy').val("");
                            $('#salesDetails').hide();
                            $('#submitButton').attr('disabled', true);
                        }else if(response.status == "DONE" || response.status == 'CANCELLED' || response.status == 'NO RECORD FOUND'){
                            $('#status').text(response.status);
                            $('#status').css("color", "red");
                            $('#status').css('font-size', '12px');
                            $('#issuedBy').val("");
                            $('#salesDetails').hide();
                            $('#submitButton').attr('disabled', true);
                        }else{
                            $('#status').text('Active');
                            $('#status').css("color", 'Green');
                            $('#status').css('font-size', '12px');
                            $('#issuedBy').val(response.issuedBy);
                            $('#issuedId').val(response.issuerID);
                            $('#salesDetails').show();
                            $('#submitButton').attr('disabled', false);
                        }
                    },
                    error: function(jqXHR){
                        console.log(jqXHR);
                    }
                });
            }); // Invoice Validation

            function submitButton(){

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('DeliverSales.store') }}" ,
                    type: "POST",
                    data: $('#deliverysalesinvoice').serialize(),
                    success: function(response){
                        try{
                            if(response.status == "success"){
                                swal('Delivery as Sales Invoice Successfully Inserted', '', 'success');
                            }else{
                                swal("Something has a error", "" , 'error');
                            }
                        }catch (Exception) {
                            swal(Exception , Exception , 'error');
                        }
                    },
                    error: function(jqXHR){
                        console.log(jqXHR);
                    }
                });
            }

            $('#submitButton').on('click', function(e){
                e.preventDefault();
                submitButton();
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
                                url: '{{ route('cancel_dr') }}' ,
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

            $(document).on('click' , '.btn-delete' , function(){
            var id = $(this).attr("data-id");
            var value = $(this).attr('value').trim();
          
            swal({
                title: "Are you sure to delete the invoice?",
                text: "Once deleted, you will not be able to recover this invoice!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type:"POST",
                            url: '{{ route('DeleteInvoice') }}' ,
                            data: {
                                '_token': $('input[name=_token]').val(),
                                'id' : id,
                                'value' : value
                            }, // get all form field value in serialize form
                            success: function(response){
                                /*swal.fire("Sorry this function currently not working");*/
                                if(response.status == "success"){
                                    swal("Deletion of Invoice is Success", {
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


        });
    </script>
@endsection
