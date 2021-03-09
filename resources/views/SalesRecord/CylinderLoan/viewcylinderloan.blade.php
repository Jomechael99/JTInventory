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
        });
    </script>
@endsection