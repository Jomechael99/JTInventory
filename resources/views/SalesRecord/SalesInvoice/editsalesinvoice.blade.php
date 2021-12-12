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

        @include('purchase_order.otherproduct')
        @foreach(Session::get('user') as $user)
        @endforeach

        <section class="content">

            @if($status == 1)
                <input type="hidden" id="status" value="{{ $status }}">    
            @endif
        
            <div class="box">
                <div class="box-header text-center">
                    <span> Sales Invoice Information </span>
                </div>
                <form method="post" id="salesinvoiceform">
                    <div class="box-body">
                        {{ csrf_field() }}
                        <div class="row">
                            @foreach($sales as $sales)
                            @endforeach
                            <input type="hidden" name="id" value="{{$sales->ID}}">
                            <div class="form-group col-md-4">
                                <label for="">INVOICE NO. &nbsp;<label id="status"></label> </label>
                                <input type="text" class="form-control" id="invoiceNo" name="invoiceNo" value="{{ $sales->INVOICE_NO }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="lbl" for=""> &nbsp;</label>
                                <button type="button" class="form-control btn btn-primary btn-validate" id="invoiceValidate" value="invoice"> Validate Invoice </button>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="lbl" for="">INVOICE DATE</label>
                                <input type="date" id="invoiceDate" name="invoiceDate" class="form-control" value="{{ $sales->INVOICE_DATE }}">
                            </div>
                        </div>
                        <div id="salesDetails">

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for=""> CUSTOMER DETAILS </label>
                                    <select id="custDetails" class="form-control custDetails" name="custDetails">
                                        <option value="" custId="">Choose Option</option>
                                        @foreach($data as $data)
                                            <option value="{{ $data-> CLIENTID }}" {{ ( $data->CLIENTID == $sales -> CLIENT_ID) ? 'selected' : '' }}>{{ $data->CLIENT_CODE }} - {{ $data -> NAME}}</option>
                                        @endforeach
                                    </select>
                                    {{--<input type="text" id="custName" class="form-control">--}}
                                </div>
                                <div class="form-group col-md-4 hidden">
                                    <label for=""> P.O. NO. </label>
                                    <select id="poNo" class="form-control poNo" name="poNo" disabled>
                                        {{--@foreach($poNo as $po)
                                            <option value="{{ $po->PO_NO }}" custId="{{ $po->CLIENTID }}">{{ $po->PO_NO }}</option>
                                        @endforeach--}}
                                    </select>
                                </div>

                                <div class="form-group col-md-4 hidden" id="poDateClass">
                                    <label for=""> PO DATE </label>
                                    <input type="date" id="poDate" name="poDate" class="form-control " readonly>
                                </div>

                                <div class="form-group col-md-4 hidden" id="">
                                    <label for=""> PRICE DATE </label>
                                    <select id="priceDate" class="form-control priceDate">
                                        <option value=""> Choose Option </option>
                                    </select>
                                </div>

                            </div>

                        </div>
                        <div class="product col-md-12">
                            <div class="row hidden">
                                <div class="box-header text-center">
                                    <span> Product Information </span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">PRODUCTS</label>
                                    <select id="productItem" class="form-control">
                                        <option value=""> Choose Option </option>
                                    </select>
                                </div>
                                <div class="form-group hidden">
                                    <label for="">SIZE</label>
                                    <input type="text" id="productSize" class="form-control"  readonly>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Rem. Qty</label>
                                    <input type="text" id="remQuantity" name="remQty" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Quantity</label>
                                    <input type="text" id="productQuantity" value="0" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="">Amount</label>
                                    <input type="text" id="productAmount" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for=""> &nbsp;</label>
                                    <button type="button" class="btn-info form-control" id="addProduct"> Add Product</button>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for=""> &nbsp;</label>

                                    <button type="button" class="btn-success form-control" id="otherCharges" data-toggle="modal" data-target="#otherModal"> Others Charges</button>
                                </div>

                            </div>
                            <div class="box-header text-center">
                                <span> Product List  </span>
                                <hr class="solid">
                            </div>
                            <div class="row table-responsive col-md-12">
                                <table id="prodListTable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-center"> Product </th>
                                        <th class="text-center"> Products Size </th>
                                        <th class="text-center"> Product Price </th>
                                        <th class="text-center"> Product Qty </th>
                                        {{--<th class="text-center"> Action </th>--}}
                                    </tr>
                                    </thead>
                                    <tbody id="productBody">
                                    @foreach($product as $product)
                                        <tr class="text-center">
                                            <td>{{ $product -> PRODUCT }}</td>
                                            <td>{{ $product -> SIZE }}</td>
                                            <td> {{ $product ->  UNIT_PRICE }}</td>
                                            <td> {{ $product ->  QTY }}</td>
                                            {{--<td>
                                                <button type="button" class="btn btn-warning" id="deleteButton" value="{{ $product -> ID }}">Delete</button>
                                            </td>--}}
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>


                            <div class="row table-responsive col-md-12">
                                <div class="box-header text-center">
                                    <span> Other Charges Information </span>
                                    <hr class="dotted">
                                </div>
                                <table id="otherTable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-center"> Particulars </th>
                                        <th class="text-center"> Particular Price </th>
                                        <th class="text-center"> Particular Qty </th>
                                        <th class="text-center"> Action </th>
                                    </tr>
                                    </thead>
                                    <tbody id="otherBody">

                                    </tbody>

                                </table>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="">Deposit</label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="" id="depCheckbox" style="text-align: center;display: block;">
                                        <input type="text" value="0" class="form-control payment" name="depositAmt" id="depositAmt" style="" readonly>
                                    </label>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="">Downpayment</label>
                                    <input type="text" value="0.00" class="form-control " name="downPay" id="downPay" value="0">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="">Other Charges</label>
                                    <input type="text" value="0" class="form-control payment" name="otherCharge" id="otherCharge" style="" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="">Grand Total</label>
                                    <input type="text" value="{{ $sales -> TOTAL }}" class="form-control" name="grandTotal" id="grandTotal"  style="" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="">Balance</label>
                                    <input type="text" value="{{ $sales -> BALANCE }}" class="form-control" name="balAmount" id="balAmount" style="" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="">Payment Type</label>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline1" name="PaymentType" value="1"  class="custom-control-input" {{ ( $sales -> SALES_TYPE == 1) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customRadioInline1" >Cash</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline2" name="PaymentType" value="2" class="custom-control-input" {{ ( $sales -> SALES_TYPE == 2) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customRadioInline2">Accounts</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="">Return cylinder</label>
                                    <select id="cylinderType" class="form-control" name="cylinderType">
                                        <option value="0" {{ ( $sales -> CYLINDER_ENTRY == 0) ? 'selected' : '' }}>Empty</option>
                                        <option value="1" {{ ( $sales -> CYLINDER_ENTRY == 1) ? 'selected' : '' }}>ICR</option>
                                        <option value="2" {{ ( $sales -> CYLINDER_ENTRY == 2) ? 'selected' : '' }}>CLC</option>
                                        <option value="3" {{ ( $sales -> CYLINDER_ENTRY == 3) ? 'selected' : '' }}>DR</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="" id="cylinderIdStatus"> Cylinder ID </label>
                                    <input type="text" class="form-control" id="inputtedTypeId" name="inputtedTypeId" value="{{ $sales->CYLINDER_IDS }}">
                                </div>
                                {{--<div class="form-group col-md-3">
                                    <label for="" id=""> &nbsp;</label>
                                   <button type="button" class="form-control btn btn-info" id="validateCylinder">Validate Cylinder</button>
                                </div>--}}
                                {{--<div class="form-group col-md-3">
                                    <label for="" id=""> &nbsp;</label>
                                    <button type="button" class="form-control btn btn-info" id="getCylinderRemain">Get Cylinder Remain from Invoice</button>
                                </div>--}}
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="" id="labelOfType"> Issued by </label>
                                    <input type="text" class="form-control" id="issuedBy" name="issuedBy" value="{{ $sales-> SALESREP_NAME }}" readonly>
                                    <input type="text" class="form-control hidden" id="issuedId" name="issuedId" readonly >
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="" id="labelOfType"> Received Date </label>
                                    <input type="date" class="form-control" id="recDate" name="recDate" value="{{ $sales->RECEIVED_DATE }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="" id="labelOfType"> Received By</label>
                                    <input type="text" class="form-control" id="recBy" name="recBy" value="{{ $sales->RECEIVED_BY }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="row">
                            <div class="form-group col-md-3 pull-left">
                                <button type="button" id="cancelInvoice" class="form-control btn btn-primary"> Cancel Invoice </button>
                            </div>
                            <div class="form-group col-md-1 pull-left">
                                <button type="button" id="reset" class="form-control btn btn-primary"> Reset </button>
                            </div>
                            @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I", "1", "2")))
                            <div class="form-group col-md-3 pull-right">
                                <button type="button" id="submitButton" class="form-control btn btn-primary"> Edit Sales Invoice </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </form>

            </div>

            <!-- /.row -->
        </section>

    </div>

@endsection


@section('scripts')

    <script type="text/javascript" src="{{ asset('BladeJavascript/SalesRecord/AddSalesInvoice.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $('.custDetails').select2({
                placeholder: 'Select an option',
                dropdownAutoWidth: true,
                allowClear: true
            });

            $('#reset').on('click', function(){
                location.reload();
            });

            function submitButton(){

                var deliveryNo = $('#invoiceNo').val();
                var cylinderDate = $('#invoiceDate').val();

                if(deliveryNo == "0" ){
                    swal("Please input required fields", "With red line", "error");
                    $('#invoiceNo').css("border", "1px solid red");
                }if(cylinderDate == ""){
                    swal("Please input required fields", "With red line", "error");
                    $('#invoiceDate').css("border", "1px solid red");
                }if(deliveryNo != "0" && cylinderDate != "") {
                    $('#invoiceNo').css("border", "");
                    $('#invoiceDate').css("border", "");

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('updateSALES') }}",
                        type: "POST",
                        data: $('#salesinvoiceform').serialize(),
                        success: function (response) {
                            try {
                                location.reload();
                                swal('Sales invoice Edited successfully', '', 'success');

                            } catch (Exception) {
                                swal(Exception, Exception, 'error');
                            }
                        },
                        error: function (jqXHR) {
                            console.log(jqXHR);
                        }
                    });
                }
            }

            $('#submitButton').on('click', function(e){
                e.preventDefault();
                submitButton();
            });
        });
    </script>

@endsection
