@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">

          <!-- Page Heading -->
            <h1 class="h3 mb-0 text-gray-800">Edit Project: {{$project->title}}</h1>
		<p></p>
		
		<div class="card shadow mb-4">
			<div class="card-body">
				{{Form::model($project, ['url'=>route('projects.update', $project), 'method'=>"PUT"])}}
				
				@include('projects.form.form')
				
				
				
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
