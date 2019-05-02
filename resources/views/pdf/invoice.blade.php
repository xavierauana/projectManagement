<!DOCTYPE html>
<html lang="en">

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
    <style>
    .page-break {
	    page-break-after: always;
    }
    </style>


</head>

<body>
  <h1 style="text-align: center">Testing</h1>
<table style="width: 100%">
  <tr>
    <th style="text-align: center;background-color: yellow">Product / Service</th>
    <th style="text-align: center;background-color: yellow">Unit Price</th>
    <th style="text-align: center;background-color: yellow">Quantity</th>
  </tr>
	@foreach($invoice->invoiceItems() as $item)
		<tr>
			<td>{{$item->product->name}}</td>
			<td>{{money_format("%i",$item->unit_price)}}</td>
			<td>{{$item->quantity}}</td>
		</tr>
	@endforeach
	<tr>
		<td colspan="2" style="text-align: right">Total</td>
		<td style="text-align: right; border-bottom-style: double">{{money_format("%i",$item->total())}}</td>
	</tr>
  
</table>
</body>

</html>


