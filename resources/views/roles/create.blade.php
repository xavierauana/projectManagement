@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">

          <!-- Page Heading -->
            <h1 class="h3 mb-0 text-gray-800">New User</h1>
		<p></p>
		
		<div class="card shadow mb-4">
			<div class="card-body">
				<form action="{{route('users.store')}}" method="POST">
					@csrf
					<legend>User info</legend>
					<div class="form-group">
						{{Form::label('first_name','First Name',['class'=>'form-label'])}}
						{{Form::text('first_name',null,['class'=>$errors->has('first_name')?"form-control is-invalid":"form-control","required"])}}
						@if ($errors->has('first_name'))
							<span class="invalid-feedback">
					          <strong>{{ $errors->first('first_name') }}</strong>
					      </span>
						@endif
					</div>
					<div class="form-group">
						{{Form::label('last_name','Last Name',['class'=>'form-label'])}}
						{{Form::text('last_name',null,['class'=>$errors->has('last_name')?"form-control is-invalid":"form-control","required"])}}
						@if ($errors->has('last_name'))
							<span class="invalid-feedback">
					          <strong>{{ $errors->first('last_name') }}</strong>
					      </span>
						@endif
					</div>
					<div class="form-group">
						{{Form::label('email','Email',['class'=>'form-label'])}}
						{{Form::email('email',null,['class'=>$errors->has('email')?"form-control is-invalid":"form-control",'required'])}}
						@if ($errors->has('email'))
							<span class="invalid-feedback">
					          <strong>{{ $errors->first('email') }}</strong>
					      </span>
						@endif
					</div>
					
					<div class="form-group">
						{{Form::label('roles[]','Role',['class'=>'form-label'])}}
						{{Form::select('roles[]',$roles,null,['class'=>$errors->has('roles[]')?"form-control is-invalid":"form-control",'required','multiple'])}}
						@if ($errors->has('roles[]'))
							<span class="invalid-feedback">
					          <strong>{{ $errors->first('roles[]') }}</strong>
					      </span>
						@endif
					</div>
					
					<div class="form-group clearfix">
						<a class="btn btn-info btn-sm shadow-sm text-light"
						   href="{{url()->previous('/')}}"><i
									class="fas fa-sm fa-chevron-left"></i> Back</a>
						<button class="btn btn-sm btn-success shadow-sm float-right"
						        type="submit"><i class="fas fa-plus fa-sm"></i>
							Create</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
@endcomponent
