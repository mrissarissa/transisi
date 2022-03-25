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
		<div class="panel panel-flat">
			<div class="panel-body">
				
				<div class="row">
					<div class="col-lg-6">
						<form action="{{ route('admin.editAccount') }}" id="form-edit">
							@csrf
							<div class="row">
								<label class="display-block text-semibold"><b>NIK</b></label>
								<input type="text" name="nik" id="nik" readonly="" class="form-control" value="{{$user->nik}}">
								<input type="text" name="user_id" id="user_id" value="{{$user->id}}" class="hidden">
								<input type="text" name="role_id" id="role_id" value="{{$role_id}}" class="hidden">
							</div>
							<br>
							<div class="row">
								<label class="display-block text-semibold"><b>Nama</b></label>
								<input type="text" name="nama" id="nama" readonly="" class="form-control" value="{{$user->name}}" style="text-transform: uppercase;">
							</div>
							<br>
							<div class="row">
								<label class="display-block text-semibold"><b>Admin Role</b></label>
								<label class="radio-inline " style="padding-top: 20px;">
									<input type="radio" name="admin_role" value="true"  id="admin_role">
									<b>YA</b>
								</label>
								<label class="radio-inline" style="padding-top: 20px;">
									<input type="radio" name="admin_role" value="false" id="admin_role">
									<b>TIDAK</b>
								</label>
								<input type="text" name="setadmin" id="setadmin" value="{{$user->admin}}" class="hidden">
							</div>
							<br>
							<div class="row form-group">
								<label class="display-block text-semibold"><b>Factory</b></label>
								<select id="select_factory" class="select form-control">
									
								</select>
								
							</div>
							<br>
							<div class="row">
								<label class="display-block text-semibold"><b>Role User</b></label>
								<select class="select form-control" id="role_user">
									<option>Choosse Role</option>
								</select>
							</div>
							<br>
							<div class="row">
								<button class="btn btn-primary" type="submit" id="btn-save">Submit</button>
							</div>
						</form>
					</div>
					<div class="col-lg-1"></div>
					<div class="col-lg-5">
						<div class="row form-group">
							<label class="display-block text-semibold"><b>Reset Password</b></label>
							<input type="text" name="reset_id" id="reset_id" value="{{$user->id}}" class="hidden">
							<button class="btn btn-success" id="btn-reset"><span class="icon-spinner9"></span>  Reset Password</button>
						</div>
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
	var role_id = $('#role_id').val();
	


	$(window).on('load',function(){
		roleUser(role_id);
		var admin_role = $('#setadmin').val();
		var factory_id = $('#setfactory').val();
		factory(factory_id);
		
		if (admin_role==1) {
			$("input[name=admin_role][value=true]").prop('checked', true);
		
		}else{
			$("input[name=admin_role][value=false]").prop('checked', true);
		}
		
	});

	$('#form-edit').submit(function(event){
		event.preventDefault();
		var user_id = $('#user_id').val();
		var admin = $('input[name=admin_role]:checked').val();
		var factory_id = $('input[name=factory_id]:checked').val();
		var role_user = $('#role_user').val();
		console.log(admin,factory_id);
		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'get',
            url : $('#form-edit').attr('action'),
            data : {user_id:user_id,admin:admin,factory_id:factory_id,role_user:role_user},
            beforeSend : function(){
	        	loading();
	        },
            success:function(response){
                var notif = response.data;
                alert(notif.status,notif.output);

                $.unblockUI();
                window.location.reload();
            },
            error:function(response){
                var notif = response.data;
                alert(notif.status,notif.output);

                $.unblockUI();
                window.location.reload();
            }
        });
		
	});

	$('#btn-reset').click(function(event){
		event.preventDefault();

		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'get',
            url : "{{ route('admin.passwordReset') }}",
            data : {user_id:$('#reset_id').val()},
            beforeSend : function(){
	        	loading();
	        },
            success:function(response){
                var notif = response.data;
                alert(notif.status,notif.output);

                $.unblockUI();
                window.location.reload();
            },
            error:function(response){
                var notif = response.data;
                alert(notif.status,notif.output);

                $.unblockUI();
                window.location.reload();
            }
        });

	})
	
});

function roleUser(role_id){
	
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
            	if (drl[i]['id']==role_id) {
            		var select = "Selected";
            	}else{
            		var select = "";
            	}
               $('#role_user').append('<option value="'+drl[i]['id']+'" '+select+'>'+drl[i]['display_name']+'</option>');
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function factory(factory_id){
	
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
            	if (lfac[i]['id']==factory_id) {
            		var select = "Selected";
            	}else{
            		var select = "";
            	}
               $('#select_factory').append('<option value="'+lfac[i]['id']+'" '+select+'>'+lfac[i]['factory_name']+'</option>');
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
}
</script>
@endsection