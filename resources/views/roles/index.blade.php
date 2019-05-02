@push('style')
	<link href="{{asset('css/datatable.css')}}" rel="stylesheet">
@endpush


@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">

          <!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 mr-3 text-gray-800 d-inline-block">Roles</h1>
            <a href="{{route('roles.create')}}"
               class="d-inline-block btn btn-sm btn-success shadow-sm"><i
			            class="fas fa-plus fa-sm text-white-50"></i> Add Role</a>
          </div>
		
		@component('components.myTable',['paginator'=>$roles])
			<table class="table table-bordered datatables" width="100%"
			       cellspacing="0">
                  <thead>
                    <tr>
	                    <th>Name </th>
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
                    @foreach($roles as $role)
	                    <tr>
                        <td>{{$role->name}}</td>
                        <td>
	                        @can('edit_role')
		                        <a class="btn btn-primary btn-sm btn-circle mb-1"
		                           href="{{route("roles.edit", $role)}}"><i
					                        class="fas fa-edit"></i></a>
	                        @endcan
	                        @can('delete_role')
		                        <button class="btn btn-danger btn-sm btn-circle mb-1"
		                                :disabled="busy"
		                                @click.prevent="removeItem({{$role->id}}, '{{$role->title}}')"><i
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
