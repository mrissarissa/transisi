<ul class="navigation navigation-main navigation-accordion">
	
	<!-- Main -->
	@permission(['menu-dashboard'])
	<li class="{{ $active == 'dashboard' ? 'active' : ''}}"><a href="{{ route('home.index') }}"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
	@endpermission

	@permission(['menu-user-management'])
	<li class="navigation-header"><span>User Management</span> <i class="icon-menu"></i></li>
	<li class="{{ $active == 'user_account' ? 'active' : ''}}"><a href="{{ route('admin.user_account')}}"><i class="icon-theater"></i> <span>User Account</span></a></li>
	<li class="{{ $active == 'role_user' ? 'active' : ''}}"><a href="{{route('admin.formRole')}}"><i class="icon-menu2"></i> <span>Role</span></a></li>
	@endpermission

	<!-- /page kits -->

</ul>