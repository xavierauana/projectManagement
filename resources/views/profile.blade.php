@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Profile</h1>
         
          </div>

          <!-- Content Row -->
          <div class="row">
	          <div class="col">
		           {{Form::model($user,['url'=>route('profile'), 'method'=>'PUT','class'=>'form'])}}
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
		          {{Form::email('email',null,['class'=>$errors->has('email')?"form-control is-invalid":"form-control",'disabled'])}}
		          @if ($errors->has('email'))
			          <span class="invalid-feedback">
	                    <strong>{{ $errors->first('email') }}</strong>
	                </span>
		          @endif
	          </div>
	          <div class="form-group">
	          	{{Form::label('password','Password',['class'=>'form-label'])}}
		          {{Form::password('password',['class'=>$errors->has('password')?"form-control is-invalid":"form-control"])}}
		          @if ($errors->has('password'))
			          <span class="invalid-feedback">
	                    <strong>{{ $errors->first('password') }}</strong>
	                </span>
		          @endif
	          </div>
	          <div class="form-group">
	          	{{Form::label('password_confirmation','Confirm Password',['class'=>'form-label'])}}
		          {{Form::password('password_confirmation',['class'=>$errors->has('password_confirmation')?"form-control is-invalid":"form-control"])}}
		          @if ($errors->has('password_confirmation'))
			          <span class="invalid-feedback">
	                    <strong>{{ $errors->first('password_confirmation') }}</strong>
	                </span>
		          @endif
	          </div>
		          <div class="form-group">
	          	<a href="{{url()->previous('/')}}" class="btn btn-info">Back</a>
	          	<button type="submit"
	                    class="btn btn-success float-right">Update</button>
	          </div>
		
		          {{Form::close()}}
	          </div>
           
          </div>

          
        </div>
	<!-- /.container-fluid -->
	
	@include('components.invoice-payment-modal')
@endcomponent
