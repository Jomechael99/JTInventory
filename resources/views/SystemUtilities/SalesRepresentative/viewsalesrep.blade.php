@extends('main')

@section('content')
    @foreach(Session::get('user') as $user)
    @endforeach
  <div class="content-wrapper">
     <section class="content">
         <div class="box">
           <div class="box-header">
             <div class="col-md-4" role="alert">
                 @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I", "1", "2")))
                    <a href="{{ route('SalesRepController.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Sales Representative </a>
                 @endif
             </div>
           </div>
           <div class="box-body">
                <div class="box-body table-responsive">
                        <table id="salesRep" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Sales Representative Nickname</th>
                                    <th class="text-center">Sales Representative Name</th>
                                    <th class="text-center">Designation</th>
                                    <th class="text-center">Address</th>
                                    <th class="text-center">Birthdate</th>
                                    <th class="text-center">Contact No.</th>
                                    <th class="text-center">Email Address</th>
                                    @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I","USER LEVEL II", "1", "2" ,"3")))
                                    <th class="text-center">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($salesrep as $salesrep)
                                    <tr class="text-center">
                                        <td>{{ $salesrep -> SALESREP_NAME }}</td>
                                        <td>{{ $salesrep -> LASTNAME }} , {{ $salesrep -> FIRSTNAME }} {{ $salesrep -> MIDDLENAME }}</td>
                                        <td>{{ $salesrep -> DESIGNATION }}</td>
                                        <td>{{ $salesrep -> ADDRESS }}</td>
                                        <td>{{ $salesrep -> BIRTH_DATE }}</td>
                                        <td>{{ $salesrep -> CONTACT_NO }}</td>
                                        <td>{{ $salesrep -> EMAIL }}</td>
                                        @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I","USER LEVEL II", "1", "2" ,"3")))
                                            <td class="text-center">
                                                <div class="btn-group-vertical">
                                                    <a type="button" class="btn btn-info" href=" {{ route('SalesRepController.show', $salesrep -> ID) }}"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                                                    {{--<a type="button" class="btn btn-warning" href=" {{ route('SalesRepController.show', $salesrep -> ID) }}"><span class="fa fa-exclamation">&nbsp;&nbsp;</span>Lost Report</a>--}}
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
         <!-- /.row -->
       </section>
   </div>

@endsection

@section('scripts')

    <script type="text/javascript">
        $(document).ready(function(){

              $('#salesRep').DataTable({});
        });
    </script>

@endsection
