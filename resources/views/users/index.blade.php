@push('style')
	<link href="{{asset('css/datatable.css')}}" rel="stylesheet">
@endpush


@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">

          <!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 mr-3 text-gray-800 d-inline-block">Users</h1>
            <a href="{{route('users.create')}}"
               class="d-inline-block btn btn-sm btn-success shadow-sm"><i
			            class="fas fa-plus fa-sm text-white-50"></i> Add User</a>
          </div>
		
		@component('components.myTable',['paginator'=>$users])
			<table class="table table-bordered datatables" width="100%"
			       cellspacing="0">
                  <thead>
                    <tr>
	                    <th>Name </th>
	                    <th>Role </th>
	                    <th>Status</th>
	                    <th>Actions</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
	                    <th>Name</th>
	                    <th>Role</th>
	                    <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($users as $user)
	                    <tr>
                        <td>{{$user->fullName()}}</td>
                        <td>{{implode(',',array_map('ucwords', $user->roles->map->name->toArray()))}}</td>
                        <td>{{$user->status ? "Active":"Inactive"}}</td>
                        <td>
	                        @can('edit_user')
		                        <a class="btn btn-primary btn-sm btn-circle mb-1"
		                           href="{{route("users.edit", $user)}}"><i
					                        class="fas fa-edit"></i></a>
	                        @endcan
	                        @can('delete_user')
		                        <button class="btn btn-danger btn-sm btn-circle mb-1"
		                                :disabled="busy"
		                                @click.prevent="removeItem({{$user->id}}, '{{$user->title}}')"><i
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
