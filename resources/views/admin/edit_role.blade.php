@extends('layouts.app', ['active' => 'role_user'])
@section('header')
<div class="page-header page-header-default">
	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="#"><i class="icon-home2 position-left"></i> Admin</a></li>
			<li class="active">Edit Role User</li>
		</ul>
	</div>
</div>
@endsection

@section('content')
<div class="content">
	<div class="row">
		<div class="panel panel-flat">
			<div class="panel-body">
				<form action="{{ route('admin.updateRole') }}" id="form-update" method="POST">
					@csrf
					<div class="row">
						<div class="col-lg-6">
							<div class="row">
								<label class="display-block text-semibold">Nama</label>
								<input type="text" name="nama" id="nama" class="form-control " value="{{ $role->name}}" required="" disabled="">
								<input type="text" name="role_id" id="role_id" value="{{ $role->id}}" class="hidden">
							</div>
							<div class="row">
								<label class="display-block text-semibold">Display</label>
								<input type="text" name="display" id="display" class="form-control" value="{{ $role->display_name}}" required="" disabled="">
							</div>
							<div class="row">
								<label class="display-block text-semibold">Description</label>
								<input  type="text" name="descript" id="descript" class="form-control" value="{{ $role->description}}" required="" disabled="">
							</div>
						</div>
						<div class=col-lg-1></div>
						<div class=col-lg-5>
							<div class="row">
								<div class="table-responsive" >
									<table id="list" class="table table-basic table-condensed" style="height: 100%;">
										<thead>
											<tr>
												<th>#</th>
												<th>Name</th>
												<th>Display</th>
											</tr>
										</thead>
										<tbody>
											@foreach($permissions as $p)
												@php($isRoles = 0)
											<tr>
												<td>
													@foreach($permission_role as $perol)
														@if($p->id == $perol->permission_id)
															@php($isRoles = 1)
															@break
														@endif
				        							@endforeach

				        							@if($isRoles == 1) 
														<input type="checkbox" id="active" name="active[]" value="{{ $p->id }}" data-on="success" data-off="default" checked>
				        							@else
														<input type="checkbox" id="active" name="active[]" value="{{ $p->id }}" data-on="success" data-off="default">
				        							@endif
												</td>
												<td>{{ $p->display_name }}</td>
												<td>{{ $p->description }}</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<button class="btn btn-primary update" id="save" type="submit">UPDATE</button>
					</div>
					
				</form>
				
			</div>
		</div>
	</div>
</div>


@endsection

@section('js')
<script type="text/javascript">
$(document).ready(function(){

	$('#form-update').submit(function(event){
		event.preventDefault();

		var data = [];

		$('#active:checked').each(function(){
			data.push({
				id:$(this).val()
			})
		});

		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type : "POST",
            url : $("#form-update").attr("action"),
            data: {role_id:$('#role_id').val(),nama:$('#nama').val(),display:$('#display').val(),descript:$('#descript').val(),data:data},
            beforeSend: function () {
               loading();
            },
            success: function(response) {
            	var notif = response.data;
                alert(notif.status,notif.output);
            	$.unblockUI();

            },
            error: function(response) {
                var notif = response.data;
                alert(notif.status,notif.output);
            	$.unblockUI();
            }
        });
	});
});
</script>
@endsection

