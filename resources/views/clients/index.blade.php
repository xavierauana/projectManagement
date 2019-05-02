@push('style')
	<link href="{{asset('css/datatable.css')}}" rel="stylesheet">
@endpush


@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">

          <!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 mr-3 text-gray-800 d-inline-block">Companies</h1>
			@can('create_client')
				<a href="{{route('clients.create')}}"
				   class="d-inline-block btn btn-sm btn-success shadow-sm"><i
							class="fas fa-plus fa-sm text-white-50"></i> New Company</a>
			@endcan
          </div>
			<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a
						target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>
		
		@component('components.myTable',['paginator'=>$clients])
			<table class="table table-bordered datatables" width="100%"
			       cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Name</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($clients as $client)
	                    <tr>
                        <td>
	                        @can('read_client')
		                        <a href="{{route("clients.show", $client)}}">{{$client->name}}</a>
	                        @else
		                        {{$client->name}}
	                        @endcan
	                        </td>
                        <td>
	                        @can('edit_client')
		                        <a class="btn btn-primary btn-sm btn-circle"
		                           href="{{route("clients.edit", $client)}}"><i
					                        class="fas fa-edit"></i></a>
	                        @endcan
	                        @can('browse_contact',$client)
		                        <a href="{{route('clients.contacts.index',$client)}}"
		                           class="btn btn-warning btn-sm btn-circle"
		                           :disabled="busy"><i
					                        class="fas fa-address-book"></i></a>
	                        @endcan
	                        @can('browse_invoice',$client)
		                        <a href="{{route('clients.invoices.index',$client)}}"
		                           class="btn btn-success btn-sm btn-circle"
		                           :disabled="busy"><i
					                        class="fas fa-file-invoice-dollar"></i></a>
	                        @endcan
	                        @can('delete_client')
		                        <button class="btn btn-danger btn-sm btn-circle"
		                                :disabled="busy"
		                                @click.prevent='removeItem({{$client->id}},"{{$client->name}}")'><i
					                        class="fas fa-trash-alt"></i></button>
	                        @endcan
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
		@endcomponent
        </div>
	<!-- /.container-fluid -->
@endcomponent
