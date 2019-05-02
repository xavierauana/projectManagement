@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">
          <!-- Page Heading -->
            <h1 class="h3 mb-0 text-gray-800">New Project Invoice</h1>
		<p></p>
		
		<div class="card shadow mb-4">
			<div class="card-body">
				<create-project-invoice-form
						invoice-number="{{App\Invoice::getInvoiceNumber($project->client, $project)}}"
						:project="{{$project}}"
						:selected-products="{{$selectedItems ?? null}}"
						action="{{route('projects.invoices.store',$project)}}"
						min-date="{{\Carbon\Carbon::now()->toDateString()}}"
						client-name="{{$project->client->name}}"
						:products="{{\App\Product::whereIsActive(true)->select('name','id','price')->get()}}"
						back-url="{{url()->previous('/')}}">
				</create-project-invoice-form>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
@endcomponent
