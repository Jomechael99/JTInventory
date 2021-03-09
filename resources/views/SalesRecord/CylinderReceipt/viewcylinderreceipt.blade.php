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
                                        @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I","USER LEVEL II", "1", "2" ,"3")))
                                        <td class="text-center">
                                                <div class="btn-group-vertical">
                                                    <a type="button" class="btn btn-info" href="{{ route('CylinderReceipt.edit', $data->ID) }}"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                                                </div>
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
            $('#salesInvoice').dataTable({
                "paging":   true,
                "ordering": true,
                "info":     true,
                'searching': true,
                'bJQueryUI': true
            });
        });
    </script>
@endsection