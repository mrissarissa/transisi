@extends('layouts.app', ['active' => 'role_user'])
@section('header')
<div class="page-header page-header-default">
	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="#"><i class="icon-home2 position-left"></i> Admin</a></li>
			<li class="active">Role User</li>
		</ul>
	</div>
</div>
@endsection

@section('content')
<div class="content">
	<div class="row">
		<div class="panel panel-flat">
			<div class="panel-body">
				<div class="row form-group">
					<button class="btn btn-default" id="btn-add"><i class="icon-plus2 position-left"></i>Create New</button>
				</div>
			

				<div class="row form-group">
					<div class="table-responsive">
						<table class ="table table-basic table-condensed" id="table-list" width="100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Display name</th>
									<th>Description</th>
									<th>Action</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('js')
<script type="text/javascript">
$(document).ready(function(){
	
	$('#btn-add').click(function(){
		window.location.href= "{{route('admin.newRole')}}";
	});

	

	var table = $('#table-list').DataTable({
		processing:true,
		serverSide:true,
		deferRender:true,
		dom:'<"datatable-header"fBl><t><"datatable-footer"ip>',
		language: {
            search: '<span>Filter:</span> _INPUT_',
            searchPlaceholder: 'Type to filter...',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        ajax: {
            type: 'GET',
            url: "{{ route('admin.ajaxRoleData') }}"
        },
        fnCreatedRow: function (row, data, index) {
            var info = table.page.info();
            var value = index+1+info.start;
            // $('td', row).eq(0).html(value);
        },
        columns: [
            // {data: null, sortable: false, orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'display_name', name: 'display_name'},
            {data: 'description', name: 'description'},
            {data: 'action', name: 'action', searchable:false, sortable:false, orderable:false}
        ]
	});

	$(window).on('load',function(){
		loading();
		table.clear();
		table.draw();
		$.unblockUI();
	});

// table.on('preDraw', function() {
// 	loading();
//     Pace.start();
// })
// .on('draw.dt', function() {
//     $.unblockUI();
//     Pace.stop();
// });

});
</script>
@endsection

