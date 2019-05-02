<!-- The Modal -->
<div class="modal" id="invoice-payment-modal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
 {{Form::open(['url'=>route('invoices.pay'),'method'=>'POST'])}}
 <!-- Modal Header -->
	 <div class="modal-header">
        <h4 class="modal-title">Pay Invoice</h4>
        <button type="button" class="close"
                data-dismiss="modal">&times;</button>
      </div>
	
	 <!-- Modal body -->
      <div class="modal-body">
	      <div class="form-group">
        	{{Form::label('invoice_number','Invoice',['class'=>'form-label'])}}
		      {{Form::select('invoice_number',$invoiceToBePaid,null,['class'=>$errors->has('invoice_number')?"form-control is-invalid":"form-control",'placeholder'=>"Pick an invoice","required"])}}
		      @if ($errors->has('invoice_number'))
			      <span class="invalid-feedback">
                  <strong>{{ $errors->first('invoice_number') }}</strong>
              </span>
		      @endif
        </div>
        <div class="form-group">
        	{{Form::label('amount','Amount',['class'=>'form-label'])}}
	        {{Form::number('amount',null,['class'=>$errors->has('amount')?"form-control is-invalid":"form-control","required","min"=>0,"step"=>0.01,'placeholder'=>'Payment amount'])}}
	        @if ($errors->has('amount'))
		        <span class="invalid-feedback">
                  <strong>{{ $errors->first('amount') }}</strong>
              </span>
	        @endif
        </div>
	      
      </div>
	
	 <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Confirm</button>
        <button type="button" class="btn btn-danger"
                data-dismiss="modal">Close</button>
      </div>
	 {{Form::close()}}
    </div>
  </div>
</div>

@push('js')
	<script>
        $('#invoice-payment-modal').on('hide.bs.modal', function (e) {
          $('input#amount').val(null)
          $('select#invoice_id').val(null)
        })

        @if($errors->has('invoice_number')or $errors->has('amount'))
        $('#invoice-payment-modal').modal('show')
		@endif
    </script>
@endpush