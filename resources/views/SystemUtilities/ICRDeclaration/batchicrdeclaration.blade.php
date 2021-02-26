@extends('main')

@section('content')

    <div class="content-wrapper">

        <section class="content">
            <div class="box">
                <div class="box-header text-center">
                    <span> Add ICR Batch Declaration </span>
                </div>
                <div class="box-body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for=""> Date Assigned </label>
                            <input type="date" class="form-control" id="DateAssign" name="DateAssign" placeholder="Enter Nickname">
                        </div>
                        <div class="form-group col-md-4">
                            <label for=""> Sales Representative </label>
                            <select class="form-control" id="sales_rep" name="sales_rep">
                                <option selected="selected" value="">Choose Option</option>
                                @foreach($salesrep as $row)
                                    <option value="{{ $row -> ID }}"> {{ $row -> SALESREP_NAME }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            @foreach(Session::get('user') as $user)
                            @endforeach
                            <label for=""> Assigned By: </label>
                            <input type="text" class="form-control" id="assignedBy" name="assignedBy" value="{{ $user->userid }}" placeholder="" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for=""> From Invoice No. </label>
                            <input type="text" class="form-control" id="FromInvoice" name="FromInvoice" placeholder="Enter From Invoice No.">
                        </div>
                        <div class="form-group col-md-6">
                            <label for=""> To Invoice No. </label>
                            <input type="text" class="form-control" id="ToInvoice" name="ToInvoice" placeholder="Enter To Invoice No.">
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="form-group col-md-4 pull-right">
                            <button type="button" id="addInvoice" class="form-control btn btn-primary"> Add ICR </button>
                            {{--                           <a href="{{ route('SalesInvoice.index') }}" class="form-control btn btn-primary"> Back</a>--}}
                        </div>
                    </div>
                </div>

            </div>



            <div class="box">
                <div class="box-header text-center">
                    <span> ICR Declaration </span>
                </div>
                <form method="post" id="batch_form">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="salesRep" class="table table-bordered table-striped">

                                <thead>
                                <tr>
                                    <th class="text-center">Assigned Date</th>
                                    <th class="text-center">Sales Rep</th>
                                    <th class="text-center">Assigned By</th>
                                    <th class="text-center">From</th>
                                    <th class="text-center">To</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody class="batch_table">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box box-footer">
                        <div class="form-group col-md-4 pull-right">
                            <button type="button" id="btnAdd" class="form-control btn btn-primary"> Add Batch ICR </button>
                            {{--                           <a href="{{ route('SalesInvoice.index') }}" class="form-control btn btn-primary"> Back</a>--}}
                        </div>
                        <div class="form-group col-md-1 pull-left">
                            <button type="button" id="reset" class="form-control btn btn-primary pull-left">Reset</button>
                        </div>
                    </div>
            </div>
            <!-- /.row -->
        </section>

    </div>

@endsection


@section('scripts')
    <script>
        $(document).ready( function(){

            $('#btnAdd').on('click', function(){

                $.validate({
                    form: '#batch_form'
                });

                $.ajax({
                    url: '{{ route('addICRBatch') }}' ,
                    type: "POST",
                    data: $('#batch_form').serialize(),
                    success: function( response ) {
                        if(response.status == "success"){
                            swal("Data is inserted", "Success", "success").then(function(){
                                window.location.href = "http://jtinventory.test/SalesInvoice";
                            });
                        }else{
                            swal("Failed to insert the data", response.status, "error");
                        }
                    }
                });
            });

            $('#sales_rep').select2({
                selectOnClose: true,
            });

            $('#reset').on('click', function(){
                location.reload();
            });



            function addProduct(){
                var date = $('#DateAssign').val();
                var sales_rep = $('#sales_rep option:selected').text();
                var sales_id = $('#sales_rep option:selected').val();
                var assigned_by = $('#assignedBy').val();
                var from_no = $('#FromInvoice').val();
                var to_no = $('#ToInvoice').val();

                var flag = '';

                $("#salesRep").find("tr").each(function () {
                    var td1 = $(this).find("td:eq(1)").text();
                    var td2 = $(this).find("td:eq(2)").text();
                    var td3 = $(this).find("td:eq(3)").text();


                    if ((sales_rep == td1 && from_no == td2 && to_no == td3)) {
                        flag = 1;
                    }
                });

                if(flag == 1){
                    swal("Exisiting Sales Invoice No" , "" , "error");
                }else{
                    var tableElements = "<tr class='text-center'> " +
                        "<td><input type='hidden' name='date[]' id='date' value='"+ date + "'>" + date + "</td> " +
                        "<td><input type='hidden' name='sales_rep[]' id='sales_rep' value='"+ sales_id + "'>"+ sales_rep +"</td> " +
                        "<td><input type='hidden' name='assigned_by[]' id='assigned_by' value='"+ assigned_by + "'>"+ assigned_by +"</td> " +
                        "<td><input type='hidden' name='from_no[]' id='from_no' value='"+ from_no + "'>" + from_no + "</td> " +
                        "<td><input type='hidden' name='to_no[]' id='to_no' value='"+ to_no + "'>"+ to_no +"</td> " +
                        "<td><button class='btn btn-warning' type='button' id='btn-remove'> Remove </button></td>" +
                        " </tr>";

                    $('.batch_table').append(tableElements);
                }
            }

            function clear_form(){
                $('#DateAssign').val("");
                $("#sales_rep").select2("val", "");
                $('#FromInvoice').val("");
                $('#ToInvoice').val("");
            }

            $('#addInvoice').on('click', function(){
                var date = $('#DateAssign').val();
                var sales_rep = $('#sales_rep option:selected').text();
                var sales_id = $('#sales_rep option:selected').val();
                var from_no = $('#FromInvoice').val();
                var to_no = $('#ToInvoice').val();

                if(date == "" || sales_rep == "" || from_no == "" || to_no == "" ){
                    swal("Some field is empty and required to be inputted", "" , "error");
                }else{
                    addProduct();
                    clear_form();
                }

            })

            $(document).on('click', '#btn-remove', function(){
                $(this).closest('tr').remove();
            });

        });

    </script>
@endsection
