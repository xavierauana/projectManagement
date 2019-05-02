<fieldset>
	<legend>Project info</legend>
	<div class="form-group">
		{{Form::label('title','Title:',['class'=>'form-label'])}}
		{{Form::text('title',null,['class'=>$errors->has('title')?"form-control is-invalid":"form-control"])}}
		@if ($errors->has('title'))
			<span class="invalid-feedback">
	          <strong>{{ $errors->first('title') }}</strong>
	      </span>
		@endif
	</div>
	<div class="form-group">
		{{Form::label('client_id','Client:',['class'=>'form-label'])}}
		{{Form::select('client_id',$clients,null,['class'=>$errors->has('client_id')?"form-control is-invalid":"form-control"])}}
		@if ($errors->has('client_id'))
			<span class="invalid-feedback">
	          <strong>{{ $errors->first('client_id') }}</strong>
	      </span>
		@endif
	</div>
	<div class="form-group">
		{{Form::label('start_date','Start date',['class'=>'form-label'])}}
		{{Form::date('start_date',null,['class'=>$errors->has('start_date')?"form-control is-invalid":"form-control"])}}
		@if ($errors->has('start_date'))
			<span class="invalid-feedback">
	          <strong>{{ $errors->first('start_date') }}</strong>
	      </span>
		@endif
	</div>
	<div class="form-group">
		{{Form::label('end_date','End date',['class'=>'form-label'])}}
		{{Form::date('end_date',null,['class'=>$errors->has('end_date')?"form-control is-invalid":"form-control"])}}
		@if ($errors->has('end_date'))
			<span class="invalid-feedback">
	          <strong>{{ $errors->first('end_date') }}</strong>
	      </span>
		@endif
	</div>
</fieldset>
<fieldset>
	<legend>Product info</legend>
	<invoice-items
			:show-unit-price="false"
			:init-items="{{$selectedProducts??json_encode([])}}"
			:products="{{$products}}"></invoice-items>

</fieldset>
	<fieldset>
	<legend>Notification Setting</legend>
	<div class="form-group">
		{{Form::label('publish_at','Notification publish at',['class'=>'form-label'])}}
		{{Form::datetimelocal('publish_at',null,['class'=>$errors->has('publish_at')?"form-control is-invalid":"form-control"])}}
		@if ($errors->has('publish_at'))
			<span class="invalid-feedback">
	          <strong>{{ $errors->first('publish_at') }}</strong>
	      </span>
		@endif
	</div>
	<div class="form-group">
		{{Form::label('sent_to','Notification send to',['class'=>'form-label'])}}
		{{Form::select('sent_to',$users->first(),null,['class'=>$errors->has('sent_to')?"form-control is-invalid":"form-control","multiple"])}}
		@if ($errors->has('sent_to'))
			<span class="invalid-feedback">
	          <strong>{{ $errors->first('sent_to') }}</strong>
	      </span>
		@endif
	</div>
</fieldset>
