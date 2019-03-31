@extends("layouts.app")

@section("content")
	<body class="@if(isset($bodyBgColor)) {{$bodyBgColor}} @else bg-gradient-primary @endif "><div class="container">
	  <div id="app">
            {{$slot}}
	  </div>

  </div>
	
	<!-- Custom scripts for all pages-->
  <script src="{{asset('js/app.js')}}"></script>

</body>


@endsection