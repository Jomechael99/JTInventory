@extends('main')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            @foreach(Session::get('user') as $user)
            @endforeach
            <div class="box">
                <div class="box-body">
                    <div class="box-body table-responsive">
                        <table id="salesInvoice" class="table table-bordered table-striped salesInvoice">

                            <thead>
                            <tr>
                                <th class="text-center">SA NUMBER</th>
                                <th class="text-center">CUSTOMER</th>
                                <th class="text-center">FROM DATE</th>
                                <th class="text-center">TO DATE</th>
                                <th class="text-center">ACTIONS</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            {{--@foreach($invoice_data->chunk(100) as $chunk)
                                @foreach($chunk as $data)
                                    <tr class="text-center">
                                        <td><a href="#invoiceModal" id="invoiceData" data-toggle="modal" data-target="#invoiceModal">{{ $data->INVOICE_NO }}</a></td>
                                        <td>{{ $data->INVOICE_DATE }}</td>
                                        <td>{{ $data->NAME }}</td>
                                        <td>{{ $data->DESIGNATION }}</td>
                                        <td>{{ $data->CELL_NO }}</td>
                                        @if($user -> user_authorization == "ADMINISTRATOR" || $user->user_authorization == 1)
                                        <td class="text-center">
                                            <div class="btn-group-vertical">
                                                <a type="button" class="btn btn-info" href="{{ route('Sales.edit', $data->ID) }}"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforeach--}}
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

            var table = $('.salesInvoice').DataTable({
                processing: true,
                serverSide: true,
                bjQueryUI: true,
                ajax : {
                    url : "{{ route('soa_history_data') }}",
                    type : "GET",
                    dataType: 'JSON'
                },
                columns: [
                    {data: 'sa_number', name: 'sa_number'},
                    {data: 'NAME', name: 'NAME'},
                    {data: 'from_date', name: 'to_date'},
                    {data: 'to_date', name: 'to_date'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    }
                ]
            });
        });
    </script>

@endsection
