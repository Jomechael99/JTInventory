@extends('main')

@section('content')

    <div class="content-wrapper">
        <section class="content">
            @foreach(Session::get('user') as $user)
            @endforeach
            <div class="box">
                <div class="box-header">
                    <div class="col-md-4" role="alert">
                        <br>
                        @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I","1", "2")))
                            <a href="{{ route('CylinderLoan.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Cylinder Loan Contract</a>
                        @endif
                    </div>
                </div>
                <div class="box-body">
                    <div class="box-body table-responsive">
                        <table id="salesInvoice" class="table table-bordered table-striped">

                            <thead>
                            <tr>
                                <th class="text-center">CLC NO.</th>
                                <th class="text-center">CLC DATE</th>
                                <th class="text-center">CUSTOMER NAME</th>
                                @if($user -> user_authorization == "ADMINISTRATOR" || $user->user_authorization == 1)
                                    <th class="text-center">Actions</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($cylinder_data as $data)
                                    <tr class="text-center">
                                        <td>{{ $data -> CLC_NO }}</td>
                                        <td>{{ $data -> CLC_DATE }}</td>
                                        <td> {{ $data ->  NAME }}</td>
                                        @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I","USER LEVEL II", "1", "2" ,"3")))
                                        <td>
                                                <a type="button" class="btn btn-info" href="{{ route('CylinderLoan.edit', $data->ID) }}"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                                            @if($data -> loan_status == 1)
                                                <a type="button" class="btn btn-warning btn-cancel" data-id='{{ $data->ID }}'><span class="fa fa-times">&nbsp;&nbsp;</span>Cancel CLC</a>
                                            @endif
                                        </td>
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
            $('#salesInvoice').dataTable();
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
                                url: '{{ route('cancel_loan') }}' ,
                                data: {
                                    '_token': $('input[name=_token]').val(),
                                    'id' : id,
                                }, // get all form field value in serialize form
                                success: function(response){
                                    /*swal.fire("Sorry this function currently not working");*/
                                    if(response.status == "success"){
                                        swal("Cancellation of Cylinder Loan is Success", {
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
