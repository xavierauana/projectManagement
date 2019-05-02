@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">

          <!-- Page Heading -->
            <h1 class="h3 mb-0 text-gray-800">Edit User: {{$user->fullName()}}</h1>
		<p></p>
		
		<div class="card shadow mb-4">
			<div class="card-body">
				{{Form::model($user, ['url'=>route('users.update', $user), 'method'=>"PUT"])}}
				
				<div class="form-group">
	          	{{Form::label('first_name','First Name',['class'=>'form-label'])}}
					{{Form::text('first_name',null,['class'=>$errors->has('first_name')?"form-control is-invalid":"form-control"])}}
					@if ($errors->has('first_name'))
						<span class="invalid-feedback">
	                    <strong>{{ $errors->first('first_name') }}</strong>
	                </span>
					@endif
	          </div>
	          
	          <div class="form-group">
	          	{{Form::label('last_name','Last Name',['class'=>'form-label'])}}
		          {{Form::text('last_name',null,['class'=>$errors->has('last_name')?"form-control is-invalid":"form-control"])}}
		          @if ($errors->has('last_name'))
			          <span class="invalid-feedback">
	                    <strong>{{ $errors->first('last_name') }}</strong>
	                </span>
		          @endif
	          </div>
	          <div class="form-group">
	          	{{Form::label('email','Email',['class'=>'form-label'])}}
		          {{Form::email('email',null,['class'=>$errors->has('email')?"form-control is-invalid":"form-control"])}}
		          @if ($errors->has('email'))
			          <span class="invalid-feedback">
	                    <strong>{{ $errors->first('email') }}</strong>
	                </span>
		          @endif
	          </div>
				<div class="form-group">
	          	{{Form::label('roles[]','Status',['class'=>'form-label'])}}
					{{Form::select('roles[]',array_combine($roles->map->name->toArray(),$roles->map->name->toArray()),null,['class'=>$errors->has('roles[]')?"form-control is-invalid":"form-control",'required','multiple'])}}
					@if ($errors->has('roles[]'))
						<span class="invalid-feedback">
	                    <strong>{{ $errors->first('roles[]') }}</strong>
	                </span>
					@endif
	          </div>
	          <div class="form-group">
	          	{{Form::label('status','Status',['class'=>'form-label'])}}
		          {{Form::select('status',['Suspend', 'Active'],null,['class'=>$errors->has('status')?"form-control is-invalid":"form-control",'required'])}}
		          @if ($errors->has('status'))
			          <span class="invalid-feedback">
	                    <strong>{{ $errors->first('status') }}</strong>
	                </span>
		          @endif
	          </div>
	          
				<div class="form-group">
	          	<a href="{{url()->previous('/')}}" class="btn btn-info">Back</a>
	          	<a href="#" class="btn btn-warning">Reset Password</a>
	          	<button type="submit"
	                    class="btn btn-success float-right">Update</button>
	          </div>
				
				{{Form::close()}}
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
@endcomponent
