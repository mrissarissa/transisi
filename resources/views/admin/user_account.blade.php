@extends('layouts.app', ['active' => 'user_account'])
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
					<a href="#" class="btn btn-default" id="btn-add"><i class="icon-plus2 position-left"></i>Create New</a>
				</div>
				<div class="row form-group">
					<div class="table-responsive">
						<table class ="table table-basic table-condensed" id="user-list">
							<thead>
								<tr>
									<th>#</th>
									<th>NIK</th>
									<th>Nama</th>
									<th>Factory</th>
									<th>Status</th>
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

@section('modal')
<div id="modal_add" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title">Create New User</h5>
			</div>

			<div class="modal-body">
				<form action="{{ route('admin.addUser') }}" id="form-adduser">
					@csrf
					<div class="row">
						<div class="col-lg-6">
							<label class="display-block text-semibold">NIK</label>
							<input type="text" name="nik" id="nik" class="form-control" required="" style="text-transform: uppercase;">
						</div>

						<div class="col-lg-6">
							<label class="display-block text-semibold"><b>Factory</b></label>
								<select id="select_factory" class="select form-control">
									
								</select>
						</div>
					</div>
					<br>
					<div class="row ">
						<div class="col-lg-6">
							<label class="display-block text-semibold">Nama</label>
							<input type="text" name="name" id="name" class="form-control" required="" style="text-transform: uppercase;">
						</div>

						<div class="col-lg-6">
							<label class="display-block text-semibold">Admin Role</label>
							<label class="radio-inline " style="padding-top: 20px;">
								<input type="radio" name="admin" value="true" id="admin">
								<b>YA</b>
							</label>
							<label class="radio-inline" style="padding-top: 20px;">
								<input type="radio" name="admin" value="false" checked="checked" id="admin">
								<b>Tidak</b>
							</label>
						</div>
					</div>
					<br>
					<div class="row ">
						<div class="col-lg-6">
							<label class="display-block text-semibold">Role User</label>
							<select class="select form-control" id="role_user">
								<option>Choose Role</option>
							</select>
						</div>
					</div>
					<br>
					<div class="row">
						<button type="submit" class="btn btn-primary" id="btn-save">Save</button>
						<button type="reset" class="btn btn-warning" id="btn-reset">Reset</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>

			<!-- <div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div> -->
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
            url: "{{ route('admin.getDataUser') }}"
        },
        fnCreatedRow: function (row, data, index) {
            var info = table.page.info();
            var value = index+1+info.start;
            $('td', row).eq(0).html(value);
        },
        columns: [
            {data: null, sortable: false, orderable: false, searchable: false},
            {data: 'nik', name: 'nik'},
            {data: 'name', name: 'name'},
            {data: 'factory_id', name: 'factory_id'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', searchable:false, sortable:false, orderable:false}
        ]
	});


	$('#btn-add').click(function(){
	    roleUser();
	    factory();
		$('#modal_add').modal('show');
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
	        data:{nik:$('#nik').val(),name:$('#name').val(),factory_id:$('input[name=factory_id]:checked').val(),admin_role:$('input[name=admin]:checked').val(),role_user:$('#role_user').val()},
	        beforeSend : function(){
	        	loading();
	        },
	        success: function(response) {

	         	var notif = response.data;
                alert(notif.status,notif.output);
    
	            
	            table.clear();
	            table.draw();
	            $.unblockUI();
	            dispose();
	            // $('#modal_add > .nik').val('');
	            // $('#modal_add > .name').val('');
	            // $('#modal_add > .admin_role').val('false');
	            // $('#modal_add > .factory_id').val('1');
	            // $('#modal_add').modal('hide');

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

function factory(){
	
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'get',
        url : "{{ route('admin.getFactory') }}",
        success: function(response) {
         
            var lfac = response.factory;
      
            $('#select_factory').empty();
            $('#select_factory').append('<option value="">Choosse Factory</option>');
            for (var i = 0; i < lfac.length; i++) {
            	
               $('#select_factory').append('<option value="'+lfac[i]['id']+'">'+lfac[i]['factory_name']+'</option>');
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function roleUser(){
	
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'get',
        url : "{{ route('admin.ajaxGetRole') }}",
        success: function(response) {
         
            var drl = response.role;
        
            $('#role_user').empty();
            $('#role_user').append('<option value="">Choosse Role</option>');
            for (var i = 0; i < drl.length; i++) {
            	
               $('#role_user').append('<option value="'+drl[i]['id']+'" >'+drl[i]['display_name']+'</option>');
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function dispose(){
	$('#nik').val('');
    $('#name').val('');
    $('#admin_role').val('false');
    $('#factory_id').val('1');
    $('#modal_add').modal('hide');
}


</script>
@endsection