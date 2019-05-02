@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">

          <!-- Page Heading -->
            <h1 class="h3 mb-0 text-gray-800">Edit Product: {{$product->name}}</h1>
		<p></p>
		
		<div class="card shadow mb-4">
			<div class="card-body">
				{{Form::model($product, ['url'=>route('products.update', $product), 'method'=>"PUT"])}}
				<legend>Project info</legend>
					<div class="form-group">
						{{Form::label('name','Product Name:',['class'=>'form-label'])}}
						{{Form::text('name',null,['class'=>$errors->has('name')?"form-control is-invalid":"form-control"])}}
						@if ($errors->has('name'))
							<span class="invalid-feedback">
					          <strong>{{ $errors->first('name') }}</strong>
					      </span>
						@endif
					</div>
					
				<div class="form-group">
					{{Form::label('price','Price',['class'=>'form-label'])}}
					{{Form::number('price',null,['class'=>$errors->has('price')?"form-control is-invalid":"form-control",'min'=>0,'required','step'=>0.01])}}
					@if ($errors->has('price'))
						<span class="invalid-feedback">
				          <strong>{{ $errors->first('price') }}</strong>
				      </span>
					@endif
				</div>
				
				<div class="form-group">
					{{Form::label('is_active','Is Active',['class'=>'form-label'])}}
					{{Form::select('is_active',['Inactive','Active'],null,['class'=>$errors->has('is_active')?"form-control is-invalid":"form-control"])}}
					@if ($errors->has('is_active'))
						<span class="invalid-feedback">
				          <strong>{{ $errors->first('is_active') }}</strong>
				      </span>
					@endif
				</div>
				
				
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
