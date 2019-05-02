@push('style')
	<link href="{{asset('css/datatable.css')}}" rel="stylesheet">
@endpush


@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">

          <!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 mr-3 text-gray-800 d-inline-block">Contacts</h1>
            <a href="{{route('contacts.create')}}"
               class="d-inline-block btn btn-sm btn-success shadow-sm"><i
			            class="fas fa-plus fa-sm text-white-50"></i> Create Contact</a>
          </div>
		
		@component('components.myTable',['paginator'=>$contacts])
			<table class="table table-bordered datatables" width="100%"
			       cellspacing="0">
                  <thead>
                    <tr>
                     <th>First Name</th>
	                    <th>Company</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
	                    <th>First Name</th>
	                    <th>Company</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($contacts as $contact)
	                    <tr>
                        <td>
	                        @can('read_contact')
		                        <a href="{{route('contacts.show',$contact)}}">{{$contact->fullName()}}</a>
	                        @else
		                        {{$contact->fullName()}}
	                        @endcan
                        </td>
		                    
                        <td>
	                        @can('read_client',$contact->client)
		                        <a href="{{route('clients.show',$contact->client)}}">{{$contact->client->name}}</a>
	                        @else
		                        {{$contact->client->name}}
	                        @endcan
	                        </td>
                        <td>
	                        @can('edit_project')
		                        <a class="btn btn-primary btn-sm btn-circle mb-1"
		                           href="{{route("contacts.edit", $contact)}}"><i
					                        class="fas fa-edit"></i></a>
	                        @endcan
	                        @can('delete_project')
		                        <button class="btn btn-danger btn-sm btn-circle mb-1"
		                                :disabled="busy"
		                                @click.prevent="removeItem({{$contact->id}}, '{{$contact->title}}')"><i
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
