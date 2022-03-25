@extends('layouts.app', ['active' => 'dashboard'])
@section('header')
<div class="page-header page-header-default">
	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="index.html"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">Dashboard</li>
		</ul>
	</div>

</div>
@endsection

@section('content')
<div class="content">
	<!-- Main charts -->
	<div class="panel panel-flat">
		<div class="panel-heading">
			<div class="row">
				<div class="col-lg-9">
					<h5>DASHBOARD</h5>
				</div>
				<div class="col-lg-2" >
					<select class="select form-control {{ Auth::user()->admin_role===false ? 'hidden' : ''}}" id="factory_id">
						
					</select>
				</div>
			</div>
		</div>
		<div class="panel-body">
			<center><h1>COBA</h1></center>
		</div>
	</div>

</div>
@endsection

@section('js')
<script type="text/javascript">
$(document).ready(function(){

	var session= '{{Auth::user()->factory_id}}';
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
      
            $('#factory_id').empty();
          
            for (var i = 0; i < lfac.length; i++) {
            	if (lfac[i]['id']==session) {
            		var selct = "selected";
            	}else{
            		var selct ="";
            	}
               $('#factory_id').append('<option value="'+lfac[i]['id']+'" '+selct+'>'+lfac[i]['factory_name']+'</option>');
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
});
</script>
@endsection