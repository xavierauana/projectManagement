@push('style')
	<link href="{{asset('css/datatable.css')}}" rel="stylesheet">
@endpush


@component('components.sidebar-wrapper')
	<!-- Begin Page Content -->
	<div class="container-fluid">

          <!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 mr-3 text-gray-800 d-inline-block">Project Invoices</h1>
            <a href="{{route('projects.invoices.create',$project)}}"
               class="d-inline-block btn btn-sm btn-success shadow-sm"><i
			            class="fas fa-plus fa-sm text-white-50"></i> Add Project Invoice</a>
          </div>
			<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a
						target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>
		
		@component('components.myTable',['paginator'=>$invoices])
			<table class="table table-bordered datatables" width="100%"
			       cellspacing="0">
                  <thead>
                    <tr>
	                    <th>Invoice Number</th>
	                    <th>Due Date</th>
	                    <th>Amount</th>
	                    <th>Remaining</th>
	                    <th>Status</th>
	                    <th>Actions</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
	                    <th>Invoice Number</th>
	                    <th>Due Date</th>
	                    <th>Amount</th>
	                    <th>Remaining</th>
	                    <th>Status</th>
	                    <th>Actions</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($invoices as $invoice)
	                    <tr>
                        <td>
	                        @can('read_invoice',$invoice)
		                        <a href="{{route('invoices.show',$invoice)}}">{{$invoice->invoice_number}}</a>
	                        @else
		                        {{$invoice->invoice_number}}
	                        @endcan
                        </td>
                        <td>{{$invoice->due_date}}</td>
                        <td>{{money_format('%i',$invoice->total())}}</td>
                        <td>{{money_format('%i',$invoice->remaining())}}</td>
                        <td>
	                         @switch($invoice->status)
		                        @case(\App\Enums\InvoiceStatus::Paid())
		                        <span class="badge badge-pill badge-success">{{ucwords($invoice->status->getValue())}}</span>
		                        @break
		                        @default
		                        <span class="badge badge-pill badge-primary">{{ucwords($invoice->status->getValue())}}</span>
	                        @endswitch
	                        @if($invoice->status->equals(\App\Enums\InvoiceStatus::Active()))
		                        @if(\Carbon\Carbon::now()->gt($invoice->due_date))
			                        <span class="badge badge-pill badge-danger">Overdue</span>
		                        @elseif(!$invoice->due_date->gte(\Carbon\Carbon::now()))
			                        <span class="badge badge-pill badge-warning">Due Soon</span>
		                        @endif
	                        @endif
	                        </td>
                        <td>
	                        @can('edit_invoice',$invoice)
		                        <a class="btn btn-primary btn-sm btn-circle"
		                           href="{{route("projects.invoices.edit", [$project,$invoice])}}"><i
					                        class="fas fa-edit"></i></a>
	                        @endcan
	                        @can('delete_invoice',$invoice)
		                        <button class="btn btn-danger btn-sm btn-circle"
		                                :disabled="busy"
		                                @click.prevent="removeItem({{$invoice->id}}, '{{$invoice->title}}')"><i
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
