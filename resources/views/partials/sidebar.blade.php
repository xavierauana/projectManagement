<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled"
    id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center"
     href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
{{--      <i class="fas fa-laugh-wink"></i>--}}
	    A & A
    </div>
    <div class="sidebar-brand-text mx-3">Project</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item ">
    <a class="nav-link" href="/home">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>
	@can('browse_project')
		<li class="nav-item ">
    <a class="nav-link" href="{{route('projects.index')}}">
      <i class="fas fa-project-diagram"></i>
      <span>Projects</span></a>
  </li>
	@endcan
	@can('browse_project_option')
		<li class="nav-item ">
    <a class="nav-link" href="{{route('project_options.index')}}">
      <i class="fas fa-ellipsis-v"></i>
      <span>Project Options</span></a>
  </li>
	@endcan
	@can('browse_invoice')
		<li class="nav-item ">
    <a class="nav-link" href="{{route('invoices.index')}}">
      <i class="fas fa-file-invoice-dollar"></i>
      <span>Invoices</span></a>
  </li>
	@endcan
	@can('browse_product')
		<li class="nav-item ">
    <a class="nav-link" href="{{route('products.index')}}">
      <i class="fas fa-shopping-cart"></i>
      <span>Products</span></a>
  </li>
	@endcan
	@can('browse_client','browse_contact')
		<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse"
       data-target="#customerSideBar" aria-expanded="true"
       aria-controls="customerSideBar">
      <i class="fas fa-fw fa-cog"></i>
      <span>Customer</span>
    </a>
    <div id="customerSideBar" class="collapse" aria-labelledby="headingTwo"
         data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        @can('browse_client')
		      <a class="collapse-item" href="{{route('clients.index')}}">Companies</a>
	      @endcan
	      @can('browse_contact')
		      <a class="collapse-item" href="{{route('contacts.index')}}">Contacts</a>
	      @endcan
      </div>
    </div>
  </li>
	@endcan
	
	@can('browse_user','browse_role','browse_permission')
		<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse"
       data-target="#userSideBar" aria-expanded="true"
       aria-controls="userSideBar">
      <i class="fas fa-users"></i>
      <span>Users</span>
    </a>
    <div id="userSideBar" class="collapse" aria-labelledby="headingTwo"
         data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        @can('browse_user')
		      <a class="collapse-item"
		         href="{{route('users.index')}}">Users</a>
	      @endcan
	      @can('browse_role')
		      <a class="collapse-item"
		         href="{{route('roles.index')}}">Roles</a>
	      @endcan
	      @can('browse_permission')
		      <a class="collapse-item" href="{{route('contacts.index')}}">Permissions</a>
	      @endcan
      </div>
    </div>
  </li>
@endcan
<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
		<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->