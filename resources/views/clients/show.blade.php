@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">
          <!-- Page Heading -->
            <h1 class="h3 mb-0 text-gray-800">Company: {{$client->name}}</h1>
		<p></p>
		
		<div class="card shadow mb-4">
			<div class="card-body">
				<section class="mb-4">
					<table class="table">
						<tr>
							<td>Company Name:</td>
							<td>{{$client->name}}</td>
						</tr>
					</table>
				</section>
				
			</div>
		</div>
		@can('read_contact',$client)
			<section class="mb-4">
				
				@component('components.myTable',['paginator'=>$contacts])
					@slot('heading')
						<div class="card-header">
							<h3>Contacts <small><a
											href="{{route('clients.contacts.create', $client)}}"
											class="btn btn-sm btn-success text-light float-right mt-2">Add Contact</a></small></h3>
							
						</div>
					@endslot
					<table class="table">
					<thead>
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
					</thead>
					<tbody>
					@foreach($contacts as $contact)
						<tr>
							<td>
								@can('read_contact', $contact)
									<a href="{{route('contacts.show', $contact)}}">{{$contact->fullName()}}</a>
								@else
									{{$contact->fullName()}}
								@endcan
							</td>
							<td>{{$contact->emails->first()->email}}</td>
							<td>{{$contact->phones->first()->number}}</td>
						</tr>
					@endforeach
						
					
					</tbody>
					
					</table>
				@endcomponent
				</section>
		@endcan
		<div class="card">
			<div class="card-footer">
				<a href="{{url()->previous('/')}}" class="btn btn-info btn-sm">Back</a>
				<a href="{{route('clients.edit',$client)}}"
				   class="btn btn-primary btn-sm">Edit</a>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
@endcomponent
