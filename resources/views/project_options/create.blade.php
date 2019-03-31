@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">

          <!-- Page Heading -->
            <h1 class="h3 mb-0 text-gray-800">New Project Option</h1>
		<p></p>
		
		<div class="card shadow mb-4">
			<div class="card-body">
				<form action="{{route('project_options.store')}}" method="POST">
					@csrf
					<legend>Option info</legend>
					<div class="form-group">
						{{Form::label('title','Title:',['class'=>'form-label'])}}
						{{Form::text('title',null,['class'=>$errors->has('title')?"form-control is-invalid":"form-control"])}}
						@if ($errors->has('title'))
							<span class="invalid-feedback">
					          <strong>{{ $errors->first('title') }}</strong>
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
