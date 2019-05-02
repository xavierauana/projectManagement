@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">
          <!-- Page Heading -->
            <h1 class="h3 mb-0 text-gray-800">New Project Invoice</h1>
		<p></p>
		
		<div class="card shadow mb-4">
			<div class="card-body">
				<create-client-invoice-form
						invoice-number="{{App\Invoice::getInvoiceNumber($client)}}"
						action="{{route('clients.invoices.store',$client)}}"
						min-date="{{\Carbon\Carbon::now()->toDateString()}}"
						:client="{{$client}}"
						:products="{{\App\Product::whereIsActive(true)->select('name','id','price')->get()}}"
						back-url="{{url()->previous('/')}}">
				</create-client-invoice-form>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
@endcomponent
