@extends('layouts.app')

@section('content')
	
	<body id="page-top" class="sidebar-toggled">
		<div id="app">
	  <!-- Page Wrapper -->
		  <div id="wrapper">
			  @include('partials.sidebar')
			  <!-- Content Wrapper -->
				  <div id="content-wrapper" class="d-flex flex-column">
		
				      <!-- Main Content -->
				      <div id="content">
				
				       @include('partials.topbar')
				
				       <!-- Begin Page Content -->
					       <div class="container-fluid">
						       @if(session()->has('message'))
							       <div class="alert alert-success alert-dismissible fade show"
							            role="alert">
									   {{session('message')}}
								       <button type="button" class="close"
								               data-dismiss="alert"
								               aria-label="Close">
									    <span aria-hidden="true">&times;</span>
									  </button>
									</div>
						       @endif
						
						       {{$slot}}
				
				        </div>
					       <!-- /.container-fluid -->
				
				      </div>
				      <!-- End of Main Content -->
					
					  @include('partials.footer')
				  </div>
		  </div>
	  <!-- End of Content Wrapper -->
		</div>
		<!-- End of Page Wrapper -->
		
		<!-- Scroll to Top Button-->
		<a class="scroll-to-top rounded" href="#page-top">
			<i class="fas fa-angle-up"></i>
		</a>
  
        <script src="{{asset('js/app.js')}}"></script>
		@stack('js')

</body>
@endsection
