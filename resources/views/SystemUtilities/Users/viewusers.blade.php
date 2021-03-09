@extends('main')

@section('content')

    @foreach(Session::get('user') as $user)
    @endforeach

     <div class="content-wrapper">
        <section class="content">
            <div class="box">
              <div class="box-header">
                <div class="col-md-2" role="alert">
                    @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I", "1", "2")))
                     <a href="{{ route('SystemUsersController.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Users </a>
                    @endif
              </div>
              </div>
             <div class="box-body">
                <div class="box-body table-responsive">
                        <table id="salesRep" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">User ID</th>
                                    <th class="text-center">Username</th>
                                    <th class="text-center">User Fullname</th>
                                    <th class="text-center">User Designation</th>
                                    <th class="text-center">User Authorization</th>
                                    <th class="text-center">User Email</th>
                                    @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I","USER LEVEL II", "1", "2" ,"3")))
                                        <th class="text-center">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($systemUsers as $systemUsers)
                                    <tr class="text-center">
                                        <td>{{ $systemUsers -> id }}</td>
                                        <td>{{ $systemUsers -> userid }}</td>
                                        <td>{{ $systemUsers -> lastname }} , {{ $systemUsers -> firstname }} {{ $systemUsers -> middlename }}</td>
                                        <td>{{ $systemUsers -> designation }}</td>
                                        <td>{{ $systemUsers -> user_authorization }}</td>
                                        <td>{{ $systemUsers -> email }}</td>
                                        @if(in_array($user->user_authorization, array("ADMINISTRATOR", "USER LEVEL I","USER LEVEL II", "1", "2" ,"3")))
                                            <td class="text-center">
                                                <div class="btn-group-vertical">
                                                    <a type="button" class="btn btn-info" href=" {{ route('SystemUsersController.show', $systemUsers -> id) }}"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
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
    <script>
        $(document).ready(function(){
            $('#salesRep').dataTable();
        });
    </script>
@endsection
