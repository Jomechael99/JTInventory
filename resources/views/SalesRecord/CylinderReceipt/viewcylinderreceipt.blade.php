@extends('main')

@section('content')
    @foreach(Session::get('user') as $user)
    @endforeach
    <div class="content-wrapper">
        <section class="content">
            <div class="box">
                <div class="box-header">
                    <div class="col-md-4" role="alert">
                        <br>
                        @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I", "1", "2")))
                        <a href="{{ route('CylinderReceipt.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Cylinder Receipt</a>
                        @endif
                    </div>
                </div>
                <div class="box-body">
                    <div class="box-body table-responsive">
                        <table id="salesInvoice" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center">ICR NO.</th>
                                <th class="text-center">ICR DATE</th>
                                <th class="text-center">CUSTOMER NAME</th>
                                @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I","USER LEVEL II", "1", "2" ,"3")))
                                    <th class="text-center">Actions</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($cylinder_data as $data)
                                    <tr class="text-center">
                                        <td>{{ $data -> ICR_NO }}</td>
                                        <td>{{ $data -> ICR_DATE }}</td>
                                        <td>{{ $data -> NAME }}</td>
                                        @if(in_array($user->user_authorization, array("ADMINISTRATOR", "1")))
                                            <td class="text-center">
                                                <div class="btn-group-vertical">
                                                    <a type="button" class="btn btn-info" href="{{ route('CylinderReceipt.edit', $data->ID) }}"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                                                    @if($data -> Receipt_Status == 1)
                                                    <a type="button" class="btn btn-warning btn-cancel" data-id='{{ $data->ID }}'><span class="fa fa-times">&nbsp;&nbsp;</span>Cancel DR INVOICE</a>
                                                    @endif
                                                </div>
                                            </td>
                                        @elseif(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I","1", "2")))
                                            <td class="text-center">
                                                <div class="btn-group-vertical">
                                                    <a type="button" class="btn btn-info" href="{{ route('CylinderReceipt.edit', $data->ID) }}"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                                                </div>
                                            </td>
                                        @elseif(in_array($user->user_authorization, array("USER LEVEL II","3")))

                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#salesInvoice').dataTable({
                "paging":   true,
                "ordering": true,
                "info":     true,
                'searching': true,
                'bJQueryUI': true
            });
        });
        $(document).on('click' , '.btn-cancel' , function(){
            var id = $(this).attr("data-id");
            swal({
                title: "Are you sure to cancel the Cylinder Receipt?",
                text: "Once cancelled, you will not be able to recover this recancelled this Cylinder Receipt!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type:"POST",
                            url: '{{ route('cancel_icr') }}' ,
                            data: {
                                '_token': $('input[name=_token]').val(),
                                'id' : id,
                            }, // get all form field value in serialize form
                            success: function(response){
                                /*swal.fire("Sorry this function currently not working");*/
                                if(response.status == "success"){
                                    swal("Cancellation of Cylinder Receipt is Success", {
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
