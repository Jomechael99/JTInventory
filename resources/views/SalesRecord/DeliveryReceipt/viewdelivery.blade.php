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
                    <div class="col-md-4" role="alert">
                        @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I", "1", "2")))
                        <a href="{{ route('Deliver.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Delivery </a>
                        @endif
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <table id="delivery" class="table table-bordered table-striped">

                        <thead>
                            <th class="text-center"> Delivery No. </th>
                            <th class="text-center"> Delivery Date. </th>
                            <th class="text-center"> Customer Name </th>
                            @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I","USER LEVEL II", "1", "2" ,"3")))
                                <th class="text-center"> Actions </th>
                            @endif
                        </thead>
                        <tbody class="text-center">
                        {{--@foreach($deliver_receipt as $deliver_data)
                            <tr class="text-center">
                                <td> {{ $deliver_data -> DR_NO }}</td>
                                <td> {{ $deliver_data -> DR_DATE }}</td>
                                <td> {{ $deliver_data -> NAME }}</td>
                                @if($user -> user_authorization == "ADMINISTRATOR" || $user->user_authorization == 1)
                                    <td>
                                        <a type="button" class="btn btn-info" href="{{ route('Deliver.edit', $deliver_data->ID) }}"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
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
            var table = $('#delivery').DataTable({
                processing: true,
                serverSide: true,
                bjQueryUI: true,
                ajax : {
                    url : "{{ route('delivery_sales_data2') }}",
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