<div class="sidebar-user-material">
	<div class="category-content">
		<div class="sidebar-user-material-content" style="height: ">
			<div class="row">
				<h4 style="color: white;"><b>{{ Auth::user()->name}}</b></h4>
			</div>		
		</div>
									
		<div class="sidebar-user-material-menu">
			<a href="#user-nav" data-toggle="collapse"><span>My account</span> <i class="caret"></i></a>
		</div>
	</div>
	
	<div class="navigation-wrapper collapse" id="user-nav">
		<ul class="navigation">
			<li><a href="{{ route('account.myAccount') }}"><i class="icon-cog5"></i> <span>Change Password</span></a></li>
			<li><a href="{{ route('logout') }}" onclick="event.preventDefault();
									document.getElementById('logout-form').submit();">
					<i class="icon-switch2"></i> 
					<span>Logout</span>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
					</a>
			</li>
		</ul>
	</div>
</div>