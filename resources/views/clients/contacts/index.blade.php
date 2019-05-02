@push('style')
	<link href="{{asset('css/datatable.css')}}" rel="stylesheet">
@endpush


@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">

          <!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 mr-3 text-gray-800 d-inline-block">Contacts for Company: {{$client->name}}</h1>
            <a href="{{route('clients.contacts.create',$client)}}"
               class="d-inline-block btn btn-sm btn-success shadow-sm"><i
			            class="fas fa-plus fa-sm text-white-50"></i> New Contact</a>
          </div>
		
		@component('components.myTable',['paginator'=>$contacts])
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
                    @foreach($contacts as $contact)
	                    <tr>
                        <td>{{$contact->fullName()}}</td>
                        <td>
	                        <a class="btn btn-primary btn-sm btn-circle"
	                           href="{{route("clients.contacts.edit", [$client,$contact])}}"><i
				                        class="fas fa-edit"></i></a>
	                       <button class="btn btn-danger btn-sm btn-circle"
	                               :disabled="busy"
	                               @click.prevent="removeItem({{$contact->id}}, '{{$contact->name}}')"><i
				                       class="fas fa-trash-alt"></i></button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
		@endcomponent
        </div>
	<!-- /.container-fluid -->
@endcomponent
