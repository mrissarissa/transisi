@extends('layouts.app', ['active' => 'role_user'])
@section('header')
<div class="page-header page-header-default">
	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="#"><i class="icon-home2 position-left"></i> Admin</a></li>
			<li class="active">User Account</li>
		</ul>
	</div>
</div>
@endsection

@section('content')
<div class="content">
	<div class="row">
		<div class=" panel panel-flat">
			<div class="panel-body">
				<div class="row form-group">
					<a href="{{ route('admin.newRole') }}" class="btn btn-default" id="btn-add"><i class="icon-plus2 position-left"></i>Create New</a>
				</div>
				<div class="row form-group">
					<div class="table-responsive">
						<table class ="table table-basic table-condensed" id="user-list" width="100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Display Name</th>
									<th width="200">Description</th>
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
	$(window).on('load',function(){
		loading();
		table.clear();
		table.draw();
		$.unblockUI();
	});

	var table = $('#user-list').DataTable({
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
            $('td', row).eq(0).html(value);
            $('td', row).eq(3).css('min-width','300px');
        },
        columns: [
            {data: null, sortable: false, orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'display_name', name: 'display_name'},
            {data: 'description', name: 'description'},
            {data: 'action', name: 'action', searchable:false, sortable:false, orderable:false}
        ]
	});


	
	$('#form-adduser').submit(function(event){
		event.preventDefault();

		$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	    });
	    $.ajax({
	        type: 'get',
	        url : "{{ route('admin.addUser') }}",
	        data:{nik:$('#nik').val(),name:$('#name').val(),factory_id:$('#factory_id').val(),admin_role:$('#admin').val(),role_user:$('#role_user').val()},
	        beforeSend : function(){
	        	loading();
	        },
	        success: function(response) {

	         	var notif = response.data;
                alert(notif.status,notif.output);
    
	            
	            table.clear();
	            table.draw();
	            $.unblockUI();
	            $('#modal_add > .nik').val('');
	            $('#modal_add > .name').val('');
	            $('#modal_add > .admin_role').val('false');
	            $('#modal_add > .factory_id').val('1');
	            $('#modal_add').modal('hide');
	        },
	        error: function(response) {
	           // var notif = response.data;
            //     alert(notif.status,notif.output);
            		$.unblockUI();
		           	alert(response.status,response.responseText);
                
	        }
	    });

	});

	

	

	
});



</script>
@endsection