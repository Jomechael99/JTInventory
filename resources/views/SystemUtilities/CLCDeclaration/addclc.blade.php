@extends('main')

@section('content')

  <div class="content-wrapper">

   <section class="content">
       <div class="box">
          <div class="box-header text-center">
            <span> Add CLC Declaration </span>
          </div>
           <form method="post" action="{{ route('CLCDeclaration.store') }}">
               <div class="box-body">
                   {{ csrf_field() }}
                   <div class="row">
                       <input type="hidden" name="id" value="{{ $id }}" >
                       <div class="form-group col-md-3">
                         <label for=""> Date Assigned </label>
                         <input type="date" class="form-control" id="DateAssign" name="DateAssign" placeholder="Enter Nickname">
                       </div>
                       <div class="form-group col-md-3">
                         <label for=""> From Invoice No. </label>
                         <input type="text" class="form-control" id="FromInvoice" name="FromInvoice" placeholder="Enter From Invoice No.">
                       </div>
                       <div class="form-group col-md-3">
                         <label for=""> To Invoice No. </label>
                         <input type="text" class="form-control" id="ToInvoice" name="ToInvoice" placeholder="Enter To Invoice No.">
                       </div>
                       <div class="form-group col-md-3">
                           @foreach(Session::get('user') as $user)
                           @endforeach
                         <label for=""> Assigned By: </label>
                         <input type="text" class="form-control" id="assignedBy" name="assignedBy" value="{{ $user->userid }}" placeholder="" readonly>
                       </div>
                   </div>
               </div>
               <div class="box-footer">
                   <div class="row">
                       <div class="form-group col-md-4 pull-right">
                           <button type="submit" id="addSalesInvoice" class="form-control btn btn-primary"> Add CLC Decleration </button>
{{--                           <a href="{{ route('SalesInvoice.index') }}" class="form-control btn btn-primary"> Back</a>--}}
                       </div>
                       <div class="form-group col-md-1">
                            <button type="button" id="reset" class="form-control btn btn-primary pull-left">Reset</button>
                        </div>
                   </div>
                   <div class="row">
                        
                   </div>
                   
               </div>
               </form>
       </div>

       <div class="box">
          <div class="box-header text-center">
            <span> CLC Declaration </span>
          </div>

          <div class="box-body">
                <div class="table-responsive">
                        <table id="salesRep" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">From</th>
                                    <th class="text-center">To</th>
                                    <th class="text-center">Assigned Date</th>
                                    <th class="text-center">Assigned By</th>
                                    @if($user -> user_authorization == "ADMINISTRATOR" || $user->user_authorization == 1)
                                        <th class="text-center">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($clc as $clc)
                                    <tr class="text-center">
                                        <td>{{ $clc -> ID }}</td>
                                        <td>{{ $clc -> FROM_NO }} </td>
                                        <td>{{ $clc -> TO_NO }}</td>
                                        <td>{{ $clc -> ENCODED_DATE }}</td>
                                        <td>{{ $clc -> ASSIGNED_BY }}</td>
                                        @if($user -> user_authorization == "ADMINISTRATOR" || $user->user_authorization == 1)
                                           <td>
                                               <a href="{{ route('viewCLC', $clc -> ID) }}" class="btn btn-info"> Edit </a>
                                               <button type="button" id="delete" value="{{ $clc -> ID }}" class="btn btn-info"> Delete </button>
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
        $(document).ready( function(){
            $('#salesRep').DataTable({
                "paging":   true,
                "ordering": true,
                "info":     true,
                'searching': true,
                'bJQueryUI': true
            });
            
            $('#reset').on('click', function(){
                location.reload();
            });
        });

        @if(Session::has('status'))

        swal( '{{ Session::get('status') }}' , "", "Success");

        @endif

        $('#delete').on('click', function(){
            var id = $(this).val();
            $.ajax({
                url: "{{ route('deleteCLC') }}",
                type: "POST",
                data: {'id': id,
                    "_token": "{{ csrf_token() }}"},
                success: function (response) {
                    try {
                        if (response.status == "success") {
                            swal({title: "Success!", text: "CLC Declaration Deleted.", type: "Success"})
                                .then((value) => {
                                    location.reload();
                                });
                        }

                    } catch (Exception) {
                        swal(Exception, Exception, 'error');
                    }
                },
                error: function (jqXHR) {
                    console.log(jqXHR);
                }
            });
        });
    </script>
@endsection
