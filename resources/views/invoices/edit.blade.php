@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">

          <!-- Page Heading -->
            <h1 class="h3 mb-0 text-gray-800">Edit Invoice: {{$invoice->invoice_number}}</h1>
		<p></p>
		
		<div class="card shadow mb-4">
			<div class="card-body">
				
				<edit-project-invoice-form
						project-title="{{$project->title}}"
						action="{{route('projects.invoices.update',[$project,$invoice])}}"
						min-date="{{\Carbon\Carbon::now()->gt($invoice->due_date)?
						$invoice->due_date->toDateString():
						\Carbon\Carbon::now()->toDateString()}}"
						client-name="{{$project->client->name}}"
						:products="{{\App\Product::select('name','id','price')->get()}}"
						:invoice="{{$invoice}}"
						back-url="{{url()->previous('/')}}"
				></edit-project-invoice-form>
			
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
@endcomponent
