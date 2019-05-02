@push('style')
	<link href="{{asset('css/datatable.css')}}" rel="stylesheet">
@endpush


@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">

          <!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 mr-3 text-gray-800 d-inline-block">Products</h1>
            <a href="{{route('products.create')}}"
               class="d-inline-block btn btn-sm btn-success shadow-sm"><i
			            class="fas fa-plus fa-sm text-white-50"></i> Create Product</a>
          </div>
			<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a
						target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>
		
		@component('components.myTable',['paginator'=>$products])
			<table class="table table-bordered datatables" width="100%"
			       cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name </th>
	                    <th>Default Price</th>
	                    <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
	                    <th>Name</th>
	                    <th>Default Price</th>
	                    <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($products as $product)
	                    <tr>
                        <td>{{$product->name}}</td>
                        <td>{{money_format("%i",$product->price)}}</td>
                        <td>{{$product->is_active ? "Active":"Inactive"}}</td>
                        <td>
	                        @can('edit_product')
		                        <a class="btn btn-primary btn-sm btn-circle mb-1"
		                           href="{{route("products.edit", $product)}}"><i
					                        class="fas fa-edit"></i></a>
	                        @endcan
	                        @can('delete_product')
		                        <button class="btn btn-danger btn-sm btn-circle mb-1"
		                                :disabled="busy"
		                                @click.prevent="removeItem({{$product->id}}, '{{$product->title}}')"><i
					                        class="fas fa-trash-alt"></i></button>
	                        @endcan
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
		@endcomponent
        </div>
	<!-- /.container-fluid -->
@endcomponent
