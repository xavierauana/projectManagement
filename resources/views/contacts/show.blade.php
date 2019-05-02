@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">

          <!-- Page Heading -->
            <h1 class="h3 mb-0 text-gray-800">Contact: {{$contact->fullName()}}</h1>
		<p></p>
		
		<div class="row">
			<div class="col-md-4 col-sm-6">
				<div class="card shadow mb-4">
					<div class="card-body">
						<h4>Info</h4>
						<div class="row">
						    <div class="col-md-4 col-6"><strong>First Name:</strong></div>
						    <div class="col-md-8 col-6">{{$contact->first_name}}</div>
						</div>
						<div class="row">
						    <div class="col-md-4 col-6"><strong>Last Name:</strong></div>
						    <div class="col-md-8 col-6">{{$contact->last_name}}</div>
						</div>
						<div class="row">
						    <div class="col-md-4 col-6"><strong>Gender:</strong></div>
						    <div class="col-md-8 col-6">{{$contact->gender}}</div>
						</div>
						<div class="row">
						    <div class="col-md-4 col-6"><strong>Job Title:</strong></div>
						    <div class="col-md-8 col-6">{{$contact->job_title}}</div>
						</div>
						<div class="row">
						    <div class="col-md-4 col-6"><strong>Company:</strong></div>
						    <div class="col-md-8 col-6">
							    @can('read_client',$contact->client)
								    <a href="{{route('clients.show',$contact->client)}}">{{$contact->client->name}}</a>
							    @else
								    {{$contact->client->name}}
							    @endcan
							    </div>
						</div>
					</div>
			
				</div>
			</div>
			<div class="col-md-8  col-sm-6">
				<div class="card shadow mb-4">
					<div class="card-body">
						<section class="mb-4">
							<h4>Main Address</h4>
							<div class="row">
							    <div class="col-md-4 col-6"><strong>Address 1:</strong></div>
							    <div class="col-md-8 col-6">{{$contact->addresses()->first()->address_1}}</div>
							</div>
							<div class="row">
							    <div class="col-md-4 col-6"><strong>Address 2:</strong></div>
							    <div class="col-md-8 col-6">{{$contact->addresses()->first()->address_2}}</div>
							</div>
							<div class="row">
							    <div class="col-md-4 col-6"><strong>Address 3:</strong></div>
							    <div class="col-md-8 col-6">{{$contact->addresses()->first()->address_3}}</div>
							</div>
							<div class="row">
							    <div class="col-md-4 col-6"><strong>Country:</strong></div>
							    <div class="col-md-8 col-6">{{$contact->addresses()->first()->country}}</div>
							</div>
						</section>
						<section class="mb-4">
							<h4>Communication</h4>
							<section class="mb-3">
								<h5>Emails</h5>
								@foreach($contact->emails as $email)
									<div class="row">
									    <div class="col">
										    <a href="mailto:{{$email->email}}">{{$email->email}}</a>
									    </div>
									</div>
								@endforeach
							</section>
							<section class="mb-3">
								<h5>Phones</h5>
								@foreach($contact->phones as $phone)
									<div class="row">
									    <div class="col"> {{$phone->number}}</div>
									</div>
								@endforeach
							</section>
						</section>
					</div>
				</div>
			</div>
		<div class="clearfix col">
				<a class="btn btn-info float-left"
				   href="{{url()->previous("/")}}">Back</a>
			@can('edit_contact',$contact)
				<a class="btn btn-primary float-right"
				   href="{{route('contacts.edit',$contact)}}">Edit</a>
			@endcan
			</div>
		</div>
		
		
		
	</div>
	<!-- /.container-fluid -->
@endcomponent
