$(document).ready(function(){
    $('#customer').select2();

    $(document).on('click', '#cancelInvoice', function () {
        window.history.back();
    });

    
    var status = $('#status').val();

    if(status != 1){
        $('#submitButton').attr('disabled', true);
        $('.btn-validate').attr('disabled', false);
    }else{
        $('#submitButton').attr('disabled', false);
        $('.btn-validate').attr('disabled', true);
    }

    function idValidation() {

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

                if (response.status == "empty") {
                    $('#status').text("No Record Found");
                    $('#status').css("color", "red");
                    $('#status').css('font-size', '12px');
                    $('#issuedBy').val("");
                    $('#submitButton').attr('disabled', true);
                }
                if(response.status == "active") {
                    $('#status').text('Active');
                    $('#status').css("color", 'Green');
                    $('#status').css('font-size', '12px');
                    $('#issuedBy').val(response.issuedBy);
                    $('#issuedId').val(response.issuerID);
                    $('#submitButton').attr('disabled', false);
                }
                if(response[0].status == "DONE"){
                    $('#status').text(response[0].status);
                    $('#status').css("color", "red");
                    $('#status').css('font-size', '12px');
                    $('#issuedBy').val("");
                    $('#submitButton').attr('disabled', true);
                }
                if(response[0].status.REMARKS == "DONE" || response[0].status.REMARKS == 'CANCELLED' || response[0].status.REMARKS == 'NO RECORD FOUND'){
                    $('#status').text(response[0].status.REMARKS);
                    $('#status').css("color", "red");
                    $('#status').css('font-size', '12px');
                    $('#issuedBy').val("");
                    $('#submitButton').attr('disabled', true);
                }
            },
            error: function(jqXHR){
                console.log(jqXHR);
            }
        });
    }

    $('#invoiceValidate').on('click', function () {
        idValidation();
    });

    function clear_form(){
        $('#size').val("");
        $('#quantity').val("");
    }

    function addProduct_Table(){
        var product_name = $('#product').val();
        var size = $('#size').val();
        var qty = $('#quantity').val();

        var flag = 0;

        $("#productBody").find("tr").each(function () {
            var td1 = $(this).find("td:eq(0)").text();

            if (product_name == td1) {
                flag = 1;
            }
        });

        if(flag == 1){
            swal("Exisiting Product" , "" , "error");
        }else {

            if(product_name == ""){

            }else{

                var tableElements = "<tr class='text-center'> " +
                    "<td><input type='hidden' name='productCode[]' id='productCode' value='" + product_name + "'>" + product_name + "</td> " +
                    "<td><input type='hidden' name='productSize[]' id='productSize' value='" + size + "'>" + size + "</td> " +
                    "<td><input type='hidden' name='productQty[]' id='productQty' value='" + qty + "'>" + qty + "</td> " +
                    "<td><button class='btn btn-error' type='button' id='btn-remove'> Remove </button></td>" +
                    " </tr>";
            }

        }

        $('#productBody').append(tableElements);
    }

    function totalAmount(){
        var finalAmount = "";

        $("#productBody tr").each(function () {
            var amount = parseFloat( $(this).find("td:eq(1)").text().replace(/,/g, ''));
            var qty = parseFloat($(this).find("td:eq(2)").text().replace(/,/g, ''));
            finalAmount = parseFloat(finalAmount + (amount *qty ));
        });


        var totalCharges = parseFloat(finalAmount) ;
        console.log(totalCharges);

        $('#totalAmount').val(totalCharges.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    }

    $('#addProduct').on('click', function(){
        var product_code = $('#product').val();
        var quantity = $('#quantity').val();
        var price = $('#size').val();

        if(product_code == ""){
            swal("Please select product", '', 'error');
        }
        else if(quantity == ""){
            swal("Please input quantity", '', 'error');
        }
        else if(price == ""){
            swal("Please input unit price", '', 'error');
        }
        else{

            addProduct_Table();
            totalAmount();

        }
    });

    $(document).on('click', '#btn-remove', function(){
        $(this).closest('tr').remove();
    });

});
