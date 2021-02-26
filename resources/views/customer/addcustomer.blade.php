@extends('main')

@section('content')

<div class="content-wrapper">

    <section class="content">

        @foreach(Session::get('user') as $user)
        @endforeach
       
        <div class="box">
          <div class="box-header">
            <div class="" role="alert">
                <h3 class="box-title">Customer Information</h3>
            </div>
          </div>
          <div class="box-body">
          <form role="form" method="post" id="custInfo" }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="CustomerName">Customer Name</label>
                        <input type="text" class="form-control" data-validation="required" id="custName" name="custName" placeholder="Customer Name">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="Address">Address</label>
                        <input type="text" class="form-control" data-validation="required" id="Address" name="Address" placeholder="Address">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="CityMuni">City/Municipality</label>
                        <input type="text" class="form-control" data-validation="required" id="City" name="City" placeholder="City">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="CustomerName">Customer Type</label>
                        <select name="custType" id="custType" data-validation="required" class="form-control">
                            <option value="" selected>Choose option</option>
                            @foreach ($clientType as $cType)
                        <option value="{{ $cType -> ID}}">{{ $cType -> CLIENT_TYPE}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                   
                    <div class="form-group col-md-3">
                        <label for="Customer Since">Customer Since</label>
                        <input type="date" class="form-control" data-validation="date" id="custSince" name="custSince"  >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="tinNo">Tin NO.</label>
                        <input type="text" class="form-control" id="tinNo" name="tinNo" placeholder="Tin NO.">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="contPerson">Contact Person</label>
                        <input type="text" class="form-control" data-validation="required" id="contPerson" name="contPerson" placeholder="Contact Person">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="Designation">Designation</label>
                        <input type="text" class="form-control" id="Designation" data-validation="required" name="Designation" placeholder="Designation">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="telNumber">Telephone No.</label>
                        <input type="text" class="form-control" id="telNo" name="telNo" placeholder="Telephone NO.">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="contNumber">Contact No.</label>
                        <input type="text" class="form-control" id="contNo" name="contNo" placeholder="Contact NO.">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="emailAddress">Email Address</label>
                        <input type="text" class="form-control" id="emailAddress"  name="emailAddress" placeholder="Email Address">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        &nbsp;
                    </div>
                    {{-- <div class="form-group col-md-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="cashPayment" id="cashPayment"> 
                                Cash Payment
                                <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                               Original Copy
                                <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                              Pink Copy
                            </label>
                        </div>
                    </div> --}}
                    <div class="form-group col-md-4">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="cashPay" id="cashPay" value="1">Cash Payment
                        </label>
                        &nbsp;&nbsp;&nbsp;
                        <label class="radio-inline">
                            <input type="radio" name="orCopy" id="origCopy" value="0">Original Copy
                            </label>
                        <label class="radio-inline">
                            <input type="radio" name="orCopy" id="pinkCopy" value="1">Pink Copy
                        </label>
                    </div>
                </div>

                <div class="box box-info">
                    <div class="box-header">
                        <button id="show_product" type="button" class="btn btn-primary ">Add Pricelist</button>
                        <button id="hide_product" type="button" class="btn btn-warning hidden">Remove Pricelist</button>
                    </div>
                    <div class="box-body hidden" id="customer_product">
                        <div class="box">

                            <div class="box-header">
                                <h3 class="box-title"> Pricelist Information </h3>
                            </div>

                            <div class="row" id="template">
                                <div class="form-group col-md-3">
                                    <label for="Products"> Products </label>
                                    <select name="productCode" id="prodCode" data-validation="required" class="form-control">
                                        <option value="" selected> Choose Option</option>
                                        @foreach($product as $product)
                                            <option value="{{ $product -> PROD_CODE }}"> {{ $product -> PRODUCT  }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group col-md-3 prodToBeClear">
                                    <label for="Products"> Product Size </label>
                                    <select name="prodSize" id="prodSize"  data-validation="required" class="form-control" disabled="true">
                                        <option value="" selected> Choose Option</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="Products"> Product Price </label>
                                    <input type="text" id="prodPrice"data-validation="required"  name="prodPrice" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="PriceDate">Price Date</label>
                                    <input type="date" class="form-control" data-validation="date" id="PriceDate" name="PriceDate" value="" >
                                </div>

                            </div>
                            <div class="box-footer">
                                <div class="btn-group pull-right">
                                    <button type="button" id="addPrice" class="btn btn-primary ">Add Price</button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row table-responsive col-md-12">
                                    <table id="prodListTable" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-center"> Products </th>
                                            <th class="text-center"> Products Size </th>
                                            <th class="text-center"> Product Price </th>
                                            <th class="text-center"> Product Date </th>
                                            @if($user -> user_authorization == "ADMINISTRATOR" || $user->user_authorization == 1)
                                                <th class="text-center"> Action </th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody class="customer_product_table">

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
              <form>


                <div class="section">
                    <div class="btn-group pull-right">
                        <button type="button" id="submit" class="btn btn-primary ">Submit</button>
                    </div>
                    <div class="btn-group">
                        <button type="button" id="back" class="btn btn-primary pull-left">Back</button>
                    </div>
                    <div class="btn-group">
                        <button type="button" id="reset" class="btn btn-primary pull-left">Reset</button>
                    </div>
                </div>



              
        </div>
        <!-- /.row -->
        </div>
      </section>

</div>


@endsection

@section('scripts')
    <script type="text/javascript">

    


    $(document).ready(function(){
        
        $('#reset').on('click', function(){
            location.reload();
        })

        $('#prodCode').on('change', function(){
            $('#prodName').val($('#prodCode option:selected').text());
            $.ajax({
                url: "{{ route('getProductSize') }}?prodcode=" + $(this).val(),
                method: 'GET',
                success: function($data){
                    if($data == ''){
                        $('#prodSize option:selected').text("Choose Option");

                    }else{
                        $('#prodSize').html($data);
                        $('#prodSize').attr("disabled", false);
                    }
                }
            });
        });

        $('#submit').on('click', function(){

            $.validate({
                form: '#custInfo'
            });

            $.ajax({
                url: '{{ route('CustomerController.store') }}' ,
                type: "POST",
                data: $('#custInfo').serialize(),
                success: function( response ) {
                    if(response.status == "success"){
                        swal("Customer is inserted", "Success", "success").then(function(){
                            window.location.href = "http://jtinventory.test/Customer";
                        });
                    }else{
                        swal("Failed to insert the data", response.status, "error");
                    }
                }
            });
        });

        $(document).on('click', '#btn-remove', function(){
            $(this).closest('tr').remove();
        });


        $('#show_product').on('click', function(){
            $('#customer_product').removeClass("hidden");
            $('#show_product').addClass("hidden");
            $('#hide_product').removeClass("hidden");
        });

        $('#hide_product').on('click', function(){
            $('#customer_product').addClass("hidden");
            $('#show_product').removeClass("hidden");
            $('#hide_product').addClass("hidden");
            $('.customer_product_table').empty();
        });

        $('#addPrice').on('click', function(){

            var productCode = $('#prodCode option:selected').val();
            var productSize = $('#prodSize option:selected').val();
            var productPrice = $('#prodPrice').val();
            var productDate = $('#PriceDate').val();

            if(productCode != "" && productSize != "" && productPrice != "" && productDate != ""){
                addProduct();
                resetValue();
            }else{
                swal("Error in adding of Product", "", "error");
            }
        });

        function resetValue(){
            $('#prodCode').prop('selectedIndex',0);
            $('#prodSize').empty();
            $('#prodSize').append('<option value="" selected>Choose Option<option>');
            $('#prodSize').attr("disabled", true);
            $('#prodPrice').val("");
            $('#PriceDate').val("");
        }

        function addProduct(){
            var productName = $('#prodCode option:selected').text();
            var productCode = $('#prodCode option:selected').val();
            var productSize = $('#prodSize option:selected').text();
            var productPrice = $('#prodPrice').val();
            var productDate = $('#PriceDate').val();

            var flag = '';

            /*$(".poTable").find("tr").each(function () {
                var td1 = $(this).find("td:eq(0)").text();
                var td2 = $(this).find("td:eq(1)").text();


                if ((productName == td1 && productSize == td2)) {
                    flag = 1;
                }
            });*/

            if(flag == 1){
                swal("Exisiting Product" , "" , "error");
            }else{
                var tableElements = "<tr class='text-center'> " +
                    "<td><input type='hidden' name='productCode[]' id='productCode' value='"+ productCode + "'><input type='hidden' name='prodName[]' id='prodName' value='"+ productName + "'>" + productName + "</td> " +
                    "<td><input type='hidden' name='productSize[]' id='productSize' value='"+ productSize + "'>"+ productSize +"</td> " +
                    "<td><input type='hidden' name='prodPrice[]' id='productPrice' value='"+ productPrice + "'>"+ productPrice +"</td> " +
                    "<td><input type='hidden' name='PriceDate[]' id='productDate' value='"+ productDate + "'>"+ productDate +"</td> " +
                    "<td><button class='btn btn-danger' type='button' id='btn-remove'> Remove </button></td>" +
                    " </tr>";

                $('.customer_product_table').append(tableElements);
            }
        }


        
    });
       

    </script>

@endsection