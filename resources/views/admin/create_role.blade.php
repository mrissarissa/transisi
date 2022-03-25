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
				<form action="{{ route('admin.addRole') }}" id="form-create" method="POST">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-lg-6">
							<div class="row">
								<label class="display-block text-semibold">Nama</label>
								<input type="text" name="nama" id="nama" class="form-control" required="" style="text-transform: uppercase;">
							</div>
							<div class="row">
								<label class="display-block text-semibold">Display</label>
								<input type="text" name="display" id="display" class="form-control"  required="" style="text-transform: uppercase;">
							</div>
							<div class="row">
								<label class="display-block text-semibold">Description</label>
								<input  type="text" name="descript" id="descript" class="form-control"  required="" style="text-transform: uppercase;">
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
												
											<tr>
												<td>
													<input type="checkbox" id="active" name="active[]" value="{{ $p->id }}" data-on="success" data-off="default">
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

<a href="{{route('admin.formRole')}}" id="load"></a>
@endsection

@section('js')
<script type="text/javascript">
$(document).ready(function(){

	$('#form-create').submit(function(event){
		event.preventDefault();
		var data = [];

		$('#active:checked').each(function(){
			data.push({
				id:$(this).val()
			})
		});

		if (data.length==null) {
			alert(422,"permissions required ! ! !");
			return false;
		}
		
		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type : "post",
            url : $("#form-create").attr("action"),
            data: {nama:$('#nama').val(),display:$('#display').val(),descript:$('#descript').val(),data:data},
            beforeSend: function () {
               loading();
            },
            success: function(response) {
            	var notif = response.data;

            	
                alert(notif.status,notif.output);
            	$.unblockUI();
            	// window.location.href=$('#load').attr('href');

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

