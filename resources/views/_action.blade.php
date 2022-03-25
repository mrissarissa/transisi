<ul class="icons-list">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<i class="icon-menu9"></i>
		</a>

		<ul class="dropdown-menu dropdown-menu-right">
			
			@if(isset($edituser))
			<li><a href="{!! $edituser !!}"><i class="icon-paragraph-justify2"></i> Edit User</a></li>
			@endif

			@if(isset($innactive))
			<li><a href="{!! $innactive !!}"><i class="icon-x"  class="ignore-click innactive"></i> Innactive User</a></li>
			@endif

			@if(isset($editrole))
			<li><a href="{!! $editrole !!}"><i class="icon-paragraph-justify2"  class="ignore-click"></i> Edit Role</a></li>
			@endif

		</ul>
	</li>
</ul>