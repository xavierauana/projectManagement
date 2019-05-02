@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">
          <!-- Page Heading -->
            <h1 class="h3 mb-0 text-gray-800">Invoice: {{$invoice->invoice_number}}</h1>
		<p></p>
		
		<div class="card shadow mb-4">
			<div class="card-body">
				<section class="mb-4">
					<h3>Invoice Info:</h3>
					<p><Strong>Billable: </Strong>
						@if($invoice->billable instanceof \App\Project and auth()->user()->can('read_project',$invoice->billable))
							<a href="{{route('projects.show',$invoice->billable)}}">{{$invoice->billable()->payee()->first()->getTitle()}}</a>
						@else
							{{$invoice->billable()->payee()->first()->getTitle()}}
						@endif
					</p>
					
					<p><Strong>Payee: </Strong>
						@can('read_project')
							<a href="{{route('clients.show',$invoice->billable->getPayee())}}">{{$invoice->billable->getPayee()->getTitle()}}</a>
						@else
							{{$invoice->billable->getPayee()->getTitle()}}
						@endcan
					</p>
					
					<section>
						<table class="table">
							<thead>
							<th>Product Name</th>
							<th>Quantity</th>
							<th>Unit Price</th>
							<th>Subtotal</th>
							</thead>
							<tbody>
							@forelse($invoice->invoiceItems() as $item)
								<tr>
									<td>{{$item->product->name}}</td>
									<td>{{$item->quantity}}</td>
									<td>{{money_format("%i",$item->unit_price)}}</td>
									<td>{{money_format("%i",$item->total())}}</td>
								</tr>
							@empty
								No Item
							@endforelse
							</tbody>
						</table>
					</section>
					<section>
					<div class="row">
						<div class="col-sm-6">
							<div class="panel">
								<h3 class="panel-heading">Internal Note</h3>
								<div class="panel-body"
								     style="min-height: 50px">
									{{$invoice->internal_note ?? "None"}}
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<div class="panel">
								<h3 class="panel-heading">Note</h3>
								<div class="panel-body"
								     style="min-height: 50px">
									{{$invoice->note??"None"}}
								</div>
							</div>
							</div>
						</div>
					</div>
					</section>
				</section>
				<section>
					<h3>Payment Records:</h3>
					<table class="table">
						<thead>
							<th>Amount</th>
							<th>Pay On Date</th>
						</thead>
						<tbody>
						@foreach($invoice->payments as $payment)
							<tr>
								<td>{{money_format('%i',$payment->amount)}}</td>
								<td>{{$payment->pay_on_date->toDateString()}}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
					</section>
			</div>
			<div class="card-footer">
				<a href="{{url()->previous('/')}}" class="btn btn-info btn-sm">Back</a>
				<a href="{{route('invoices.edit',$invoice)}}"
				   class="btn btn-primary btn-sm">Edit</a>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
@endcomponent
