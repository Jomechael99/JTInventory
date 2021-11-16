$(document).ready(function () {

    $('#customer').select2();

    $(document).on('click', '#cancelInvoice', function () {
        window.history.back();
    });

    $('#amountPaid').maskMoney();

    var status = $('#status').val();

    if (status != 1) {
        $('#submitButton').attr('disabled', true);
        $('.btn-validate').attr('disabled', false);
    } else {
        $('#submitButton').attr('disabled', false);
        $('.btn-validate').attr('disabled', true);
    }



    function idValidation() {

        var orNo = $('#orNo').val();
        var buttonVal = $('#invoiceValidate').val();

        $.ajax({
            url: "/noValidate",
            type: "POST",
            data: {
                '_token': $('input[name=_token]').val(),
                'invoiceNo': orNo,
                'buttonVal': buttonVal
            },
            success: function (response) {

                console.log(response);

                if (response.status == "empty") {
                    $('#status').text("No Record Found");
                    $('#status').css("color", "red");
                    $('#status').css('font-size', '12px');
                    $('#issuedBy').val("");
                    // $('#salesDetails').hide();
                    $('#submitButton').attr('disabled', true);
                }
                if (response.status == "active") {
                    $('#status').text('Active');
                    $('#status').css("color", 'Green');
                    $('#status').css('font-size', '12px');
                    $('#issuedBy').val(response.issuedBy);
                    $('#issuedId').val(response.issuerID);
                    $('#salesDetails').show();
                    $('#submitButton').attr('disabled', false);
                }
                if (response[0].status == "DONE" || response[0].status == 'CANCELLED' || response[0].status == 'NO RECORD FOUND') {
                    $('#status').text(response[0].status);
                    $('#status').css("color", "red");
                    $('#status').css('font-size', '12px');
                    $('#issuedBy').val("");
                    // $('#salesDetails').hide();
                    $('#submitButton').attr('disabled', true);
                }
            },
            error: function (jqXHR) {
                console.log(jqXHR);
            }
        });
    }

    $('#invoiceValidate').on('click', function () {
        idValidation();
    });

    /*function client_sales_invoice(){
        var client_id = $('#customer option:selected').val();

        $.ajax({
            url: "/getClientSalesInvoice",
            type: "POST",
            data:{
                '_token': $('input[name=_token]').val(),
                'client_id' : client_id
            },
            success: function(response){
                $('#productBody').empty();
                $('#productBody').append(response.table_data2);

            },
            error: function(jqXHR){
                console.log(jqXHR);
            }
        });
    }*/


    /* $('#prodListTable').DataTable({
         processing: true,
         serverSide: true,

         ajax: {
             url: "/getClientSalesInvoice",
             type: 'GET',
             data: function (d) {
                 d.id = $('#customer option:selected').val();
             },

         },
         Columns: [
             /!*{
                 mData: 'action',
                 name: 'action',
                 orderable: true,
                 searchable: true
             },
             {mData: 'INVOICE_NO', name: 'INVOICE_NO'},
             {mData: 'INVOICE_DATE', name: 'INVOICE_DATE'},*!/
             {data: 'BALANCE'}
         ]

     });*/

    if(status != 1){
        var table = $('#prodListTable').DataTable({
            processing: true,
            serverSide: true,
            bjQueryUI: true,
            ajax: {
                url: "/getClientSalesInvoice",
                type: "GET",
                dataType: 'JSON',
                data: function (d) {
                    d.id = $('#customer option:selected').val();
                },
            },
            columns: [
                {
                    mData: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
                {mData: 'INVOICE_NO', name: 'INVOICE_NO'},
                {mData: 'INVOICE_DATE', name: 'INVOICE_DATE'},
                {mData: 'BALANCE', name: 'BALANCE'},
            ],
            scrollY:        '30vh',
            scrollCollapse: true,
            paging: false,
            searching: true,
            sort: false,
        });


        $('#customer').on('change', function () {
            $('#prodListTable').DataTable().draw(true);
        });

    }else{

    }



    function compute_amount() {

        var totalAmount = '';
        var e = '';

        $("#productBody2").find("tr").each(function () {
            var amount = parseFloat($(this).find("td:eq(2)").text().replace(/,/g, ''));
            totalAmount = parseFloat(totalAmount + amount);

        });

        try {
            $('#remBalance , #netSales , #grossSales').val(totalAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#remBalance').attr("data-value", totalAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        } catch (Exception) {
            $('#remBalance , #netSales , #grossSales').val(0);

        }


    }

    $(document).on('click', '#radioButton', function () {

        if ($(this).prop("checked") == true) {

            var rowValue = $(this).closest("tr");

            var firstTd = rowValue.find("td:eq(1)").text();
            var secondTd = rowValue.find("td:eq(2)").text();
            var thirdTd = rowValue.find("td:eq(3)").text();
            var fourthTd = rowValue.find("td:eq(4)").text();

            var tableData = "<tr class='text-center'> " +
                "<td> <input type='hidden' name='reportNo[]' value='" + firstTd + "'> " + firstTd + "</td> " +
                "<td> <input type='hidden' name='reportDate[]' value='" + secondTd + "'>" + secondTd + "</td> " +
                "<td> <input type='hidden' name='reportAmount[]' value='" + thirdTd + "'>" + thirdTd + "</td> " +
                "<td class='hidden'> <input type='hidden' name='reportType[]' value='" + fourthTd + "'>" + fourthTd + "</td> " +
                "<td> <input type='radio' id='radButton' name='radButton'> P/O </td>" +
                "</tr>";
            
            var flag = 0;
        
            $("#productBody2").find("tr").each(function () {
                var td1 = $(this).find("td:eq(0)").text().trim();
                if(td1 == firstTd){
                    flag = 1;
                    return false;
                }else{
                    flag = 0;
                }
            });

            if(flag == 1){
                swal("Existing Data", "Please select another no.", "error");
            }else{
                $('#productBody2').append(tableData);
            }
            

            compute_amount();
            credValue();

        } else {

            var rowValue = $(this).closest("tr");

            var firstTd = rowValue.find("td:eq(1)").text().trim();


            $("#productBody2").find("tr").each(function () {

                // console.log($(this).find("td:eq(0)").text().trim());

                if ($(this).find("td:eq(0)").text().trim() == firstTd) {
                    $(this).closest('tr').remove();
                }
            });

            $('#amountPaid').val(0);
            compute_amount();
            credValue();

        }

    });

    function payment_computation() {

        var remBalance = parseFloat($('#remBalance').attr('data-value').replace(/,/g, ''));
        var amountPaid = parseFloat($('#amountPaid').val().replace(/,/g, ''));

        if (amountPaid > remBalance) {
            $('#p2').prop('checked', true);
            $('#labelId').text("Exceeding Balance");
            var exceed = amountPaid - remBalance;
            $('#remBalance').val(exceed.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        } else if (remBalance > amountPaid) {
            $('#p1').prop('checked', true);
            $('#labelId').text("Remaining Balance");
            var exceed = remBalance - amountPaid;
            $('#remBalance').val(exceed.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        } else if ((remBalance - amountPaid) == 0) {
            $('#p3').prop("checked", true);
            $('#labelId').text("Remaining Balance");
            var exceed = remBalance - amountPaid;
            $('#remBalance').val(exceed.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }
    }

    $('#amountPaid').on('keyup', function () {
        payment_computation();
        credValue();
    });

    function credValue() {
        var credValue = '';
        var GrossSales = parseFloat($('#grossSales').val().replace(/,/g, ''));
        var paymentPaid = parseFloat($('#amountPaid').val().replace(/,/g, ''));
        var netSales = parseFloat($('#netSales').val().replace(/,/g, ''));


        if ($('#credCheck').prop("checked") == true) {
            console.log(paymentPaid);
            if (isNaN(paymentPaid)) {
                credValue = GrossSales / 112;
                var newNet = netSales - credValue;
            } else {
                credValue = paymentPaid / 112;
                var newNet = paymentPaid - credValue;
            }


            $('#creditable').val(credValue.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#netSales').val(newNet.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","))

        } else {
            $('#creditable').val(0);
            $('#netSales').val(GrossSales.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","))

        }
    }

    $('#credCheck').on('click', function () {
        credValue();
    });

    $('.payType').on('click', function () {

        console.log($(this).val());

        if ($(this).val() == 1) {
            $('.cheque').attr("readonly", false);
        } else if ($(this).val() == 0) {
            $('.cheque').attr("readonly", true);
        }
    })


});