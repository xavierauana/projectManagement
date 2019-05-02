@push('style')
	<link href="{{asset('css/datatable.css')}}" rel="stylesheet">
@endpush


@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">

          <!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 mr-3 text-gray-800 d-inline-block">Projects</h1>
            <a href="{{route('projects.create')}}"
               class="d-inline-block btn btn-sm btn-success shadow-sm"><i
			            class="fas fa-plus fa-sm text-white-50"></i> Create Project</a>
          </div>
			<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a
						target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>
		
		@component('components.myTable',['paginator'=>$projects])
			<table class="table table-bordered datatables" width="100%"
			       cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name </th>
                      <th>Client Name</th>
                      <th>Start Date</th>
	                    <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Name</th>
	                    <th>Client Name</th>
	                    <th>Start Date</th>
	                    <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($projects as $project)
	                    <tr>
                        <td>{{$project->title}}</td>
		                    
                        <td>
	                        @can('read_client',$project->client)
		                        <a href="{{route('clients.show',$project->client)}}">{{$project->client->name}}</a>
	                        @else
		                        {{$project->client->name}}
	                        @endcan
	                        </td>
                        <td>{{$project->start_date}}</td>
                        <td>{{$project->status}}</td>
                        <td>
	                        @can('edit_project')
		                        <a class="btn btn-primary btn-sm btn-circle mb-1"
		                           href="{{route("projects.edit", $project)}}"><i
					                        class="fas fa-edit"></i></a>
	                        @endcan
	                        @can('browse_invoice', $project)
		                        <a class="btn btn-success btn-sm btn-circle mb-1"
		                           :disabled="busy"
		                           href="{{route("projects.invoices.index",$project)}}"><i
					                        class="fas fa-file-invoice-dollar"></i></a>
	                        @endcan
	                        @can('delete_project')
		                        <button class="btn btn-danger btn-sm btn-circle mb-1"
		                                :disabled="busy"
		                                @click.prevent="removeItem({{$project->id}}, '{{$project->title}}')"><i
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
