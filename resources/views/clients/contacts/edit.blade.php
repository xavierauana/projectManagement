@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">

          <!-- Page Heading -->
            <h1 class="h3 mb-0 text-gray-800">Edit Contact: {{$contact->name}}</h1>
		<p></p>
		
		<div class="card shadow mb-4">
			<div class="card-body">
				{{Form::model($contact, ['url'=>route('clients.contacts.update', [$client,$contact]), 'method'=>"PUT"])}}
				<fieldset>
					<legend>Contact info</legend>
				
					<div class="form-group">
						{{Form::label('first_name','First Name:',['class'=>'form-label'])}}
						{{Form::text('first_name',null,['class'=>$errors->has('first_name')?"form-control is-invalid":"form-control",'required'])}}
						@if ($errors->has('first_name'))
							<span class="invalid-feedback">
						          <strong>{{ $errors->first('first_name') }}</strong>
						      </span>
						@endif
						</div>
					
					<div class="form-group">
						{{Form::label('last_name','Last Name:',['class'=>'form-label'])}}
						{{Form::text('last_name',null,['class'=>$errors->has('last_name')?"form-control is-invalid":"form-control",'required'])}}
						@if ($errors->has('last_name'))
							<span class="invalid-feedback">
						          <strong>{{ $errors->first('last_name') }}</strong>
						      </span>
						@endif
						</div>
					
				
				</fieldset>
				
				<fieldset>
					<legend>Address</legend>
					@forelse($contact->addresses as $index=>$address)
						<div class="form-group">
						{{Form::label('addresses['.$index.'][address_1]','Address 1',['class'=>'form-label'])}}
							{{Form::text('addresses['.$index.'][address_1]',$address->address_1,['class'=>$errors->has('addresses['.$index.'][address_1]')?"form-control is-invalid":"form-control"])}}
							@if ($errors->has('addresses['.$index.'][address_1]'))
								<span class="invalid-feedback">
					          <strong>{{ $errors->first('addresses['.$index.'][address_1]') }}</strong>
					      </span>
							@endif
					</div>
						<div class="form-group">
						{{Form::label('addresses['.$index.'][address_2]','Address 2',['class'=>'form-label'])}}
							{{Form::text('addresses['.$index.'][address_2]',$address->address_2,['class'=>$errors->has('addresses['.$index.'][address_2]')?"form-control is-invalid":"form-control"])}}
							@if ($errors->has('addresses['.$index.'][address_2]'))
								<span class="invalid-feedback">
					          <strong>{{ $errors->first('addresses['.$index.'][address_2]') }}</strong>
					      </span>
							@endif
					</div>
						<div class="form-group">
						{{Form::label('addresses['.$index.'][address_3]','Address 3',['class'=>'form-label'])}}
							{{Form::text('addresses['.$index.'][address_3]',$address->address_3,['class'=>$errors->has('addresses['.$index.'][address_3]')?"form-control is-invalid":"form-control"])}}
							@if ($errors->has('addresses['.$index.'][address_3]'))
								<span class="invalid-feedback">
					          <strong>{{ $errors->first('addresses['.$index.'][address_3]') }}</strong>
					      </span>
							@endif
					</div>
						<div class="form-group">
						{{Form::label('addresses['.$index.'][country]','Country',['class'=>'form-label'])}}
							{{Form::text('addresses['.$index.'][country]',$address->country,['class'=>$errors->has('addresses['.$index.'][country]')?"form-control is-invalid":"form-control"])}}
							@if ($errors->has('addresses['.$index.'][country]'))
								<span class="invalid-feedback">
					          <strong>{{ $errors->first('addresses['.$index.'][country]') }}</strong>
					      </span>
							@endif
					</div>
					
					@empty
						
						<div class="form-group">
						{{Form::label('addresses[0][address_1]','Address 1',['class'=>'form-label'])}}
							{{Form::text('addresses[0][address_1]',null,['class'=>$errors->has('addresses[0[address_1]')?"form-control is-invalid":"form-control"])}}
							@if ($errors->has('addresses[0][address_1]'))
								<span class="invalid-feedback">
					          <strong>{{ $errors->first('addresses[0][address_1]') }}</strong>
					      </span>
							@endif
					</div>
						<div class="form-group">
						{{Form::label('addresses[0][address_2]','Address 2',['class'=>'form-label'])}}
							{{Form::text('addresses[0][address_2]',null,['class'=>$errors->has('addresses[0[address_2]')?"form-control is-invalid":"form-control"])}}
							@if ($errors->has('addresses[0][address_2]'))
								<span class="invalid-feedback">
					          <strong>{{ $errors->first('addresses[0][address_2]') }}</strong>
					      </span>
							@endif
					</div>
						<div class="form-group">
						{{Form::label('addresses[0][address_3]','Address 3',['class'=>'form-label'])}}
							{{Form::text('addresses[0][address_3]',null,['class'=>$errors->has('addresses[0[address_3]')?"form-control is-invalid":"form-control"])}}
							@if ($errors->has('addresses[0][address_3]'))
								<span class="invalid-feedback">
					          <strong>{{ $errors->first('addresses[0][address_3]') }}</strong>
					      </span>
							@endif
					</div>
						<div class="form-group">
						{{Form::label('addresses[0][country]','Country',['class'=>'form-label'])}}
							{{Form::text('addresses[0][country]',null,['class'=>$errors->has('addresses[0[country]')?"form-control is-invalid":"form-control"])}}
							@if ($errors->has('addresses[0][country]'))
								<span class="invalid-feedback">
					          <strong>{{ $errors->first('addresses[0][country]') }}</strong>
					      </span>
							@endif
					</div>
					
					@endforelse
				</fieldset>
				
				<fieldset>
					<legend>Phone</legend>
					<div class="form-group">
						{{Form::label('phones[0][number]','Number',['class'=>'form-label'])}}
						{{Form::text('phones[0][number]',null,['class'=>$errors->has('phones[0][number]')?"form-control is-invalid":"form-control"])}}
						@if ($errors->has('phones[0][number]'))
							<span class="invalid-feedback">
					          <strong>{{ $errors->first('phones[0][number]') }}</strong>
					      </span>
						@endif
					</div>
					<div class="form-group">
						{{Form::label('phones[0][type]','Type',['class'=>'form-label'])}}
						{{Form::select('phones[0][type]',[array_merge(['office','mobile'],['office','mobile'])],null,['class'=>$errors->has('phones[0][type]')?"form-control is-invalid":"form-control"])}}
						@if ($errors->has('phones[0][type]'))
							<span class="invalid-feedback">
					          <strong>{{ $errors->first('phones[0][type]') }}</strong>
					      </span>
						@endif
					</div>
				</fieldset>
				<fieldset>
					<legend>Email</legend>
					<div class="form-group">
						{{Form::label('emails[0][email]','Number',['class'=>'form-label'])}}
						{{Form::text('emails[0][email]',null,['class'=>$errors->has('emails[0][email]')?"form-control is-invalid":"form-control"])}}
						@if ($errors->has('emails[0][email]'))
							<span class="invalid-feedback">
					          <strong>{{ $errors->first('emails[0][email]') }}</strong>
					      </span>
						@endif
					</div>
					<div class="form-group">
						{{Form::label('emails[0][type]','Type',['class'=>'form-label'])}}
						{{Form::select('emails[0][type]',[array_merge(['work','personal'],['work','personal'])],null,['class'=>$errors->has('emails[0][type]')?"form-control is-invalid":"form-control"])}}
						@if ($errors->has('emails[0][type]'))
							<span class="invalid-feedback">
					          <strong>{{ $errors->first('emails[0][type]') }}</strong>
					      </span>
						@endif
					</div>
				</fieldset>
				
					<div class="form-group clearfix">
						<a class="btn btn-info btn-sm shadow-sm text-light"
						   href="{{url()->previous('/')}}"><i
									class="fas fa-sm fa-chevron-left"></i> Back</a>
						<button class="btn btn-sm btn-success shadow-sm float-right"
						        type="submit"><i class="fas fa-plus fa-sm"></i>
							Update</button>
					</div>
				{{Form::close()}}
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
@endcomponent
