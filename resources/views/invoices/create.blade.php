@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">
          <!-- Page Heading -->
            <h1 class="h3 mb-0 text-gray-800">New Invoice</h1>
		<p></p>
		
		<div class="card shadow mb-4">
			<div class="card-body">
				<create-invoice-form
						back-url="{{url()->previous('/')}}"
						action="{{route('invoices.store')}}"
						:products="{{\App\Product::whereIsActive(true)->select('id','name','price')->get()}}"
						min-date="{{\Carbon\Carbon::now()->toDateString()}}"
				></create-invoice-form>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
@endcomponent
