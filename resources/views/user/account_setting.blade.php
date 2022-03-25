@extends('layouts.app', ['active' => 'user'])
@section('header')
<div class="page-header page-header-default">
	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="#"><i class="icon-home2 position-left"></i> User</a></li>
			<li class="active">Change Password</li>
		</ul>
	</div>
</div>
@endsection

@section('content')
<div class="row panel panel-default">
	<div class="panel-header">
		<h4 style="padding-left: 20px;">Change Password</h4>
		<hr>
	</div>
	<div class="panel-body">

		<div class="col-lg-5">
			<form action="{{ route('account.editPassword') }}" id="form-edit">
				<div class="row">
					<label><b>NIK</b></label>
					<input type="text" class="form-control" id="nik" value="{{$nik}}" disabled="" style="color: black;">
					<input type="text" name="id" id="id" value="{{$id}}" hidden>
				</div>
				<div class="row">
					<label><b>Name</b></label>
					<input type="text" class="form-control" id="name" value="{{$name}}" disabled="" style="color: black;">
				</div>
				<div class="row">
					<label><b>New Password</b></label>
					<input type="password" class="form-control" id="newpass" placeholder="New Password" required="">
				</div>
				<div class="row">
					<label><b>Confrim New Password</b></label>
					<input type="password" class="form-control" id="confrimnew" placeholder="Confrim New Password" required="">
				</div>
				<br>
				<div class="row">
					<button type="submit" id="btn-save" class="btn btn-primary">Save</button>
					<button type="reset" id="btn-reset" class="btn btn-warning">Reset</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
$(document).ready(function(){
	$('#form-edit').submit(function(event){
		event.preventDefault();
		var id = $('#id').val();
		var newpass = $('#newpass').val();
		var confrimnew = $('#confrimnew').val();

		if (newpass!==confrimnew) {
			alert(422,"Password not match . . .");
			return false;
		}

		if (newpass.length<6) {
			alert(422,"Password length less then 6 character . . .");
			return false;
		}


		bootbox.confirm("Are you sure change password ?",function(result){
			if (result) {
				$.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type:'post',
                        url : $('#form-edit').attr('action'),
                        data : {id:id,newpass:newpass},
                        beforeSend : function(){
				        	loading();
				        },
                        success:function(response){
                            var notif = response.data;
                            alert(notif.status,notif.output);

                            window.location.reload();

                        },
                        error:function(response){
                            var notif = response.data;
                            alert(notif.status,notif.output);

                            // $.unblockUI();
                            window.location.reload();
                        }
                    });
			}
		});
		
	});
});
</script>
@endsection