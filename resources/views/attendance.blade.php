@extends('layout.base')

@section('breadcrum', 'Attendance')
@section('attendanceActive','actives')

@section('content')

<div class="row form-row-gap">
	<div class="row form-row-gap-internal">
		<div class="col-lg-2">
			<b>First Name :</b>
		</div>
		<div class="col-lg-4">
			<input id="txtfirstname" type="text" class="form-control">
		</div>
		<div class="col-lg-2">
			<b>Last Name :</b>
		</div>
		<div class="col-lg-4">
			<input id="txtlastname" type="text" class="form-control">
		</div>
	</div>
	<div class="row form-row-gap-internal">
		<div class="col-lg-2">
			<b>Primary Contact No. :</b>
		</div>
		<div class="col-lg-4">
			<input id="txtprimaryno" type="text" class="form-control">
		</div>
		<div class="col-lg-2">
			<b>Alternate Contact No.:</b>
		</div>
		<div class="col-lg-4">
			<input id="txtalternateno" type="text" class="form-control">
		</div>
	</div>
	<div class="row form-row-gap-internal">
		<div class="col-lg-2">
			<b>Password :</b>
		</div>
		<div class="col-lg-4">
			<input id="txtpassword" type="password" class="form-control">
		</div>
		<div class="col-lg-2">
			<b>Retype Password :</b>
		</div>
		<div class="col-lg-4">
			<input id="txtrpassword" type="password" class="form-control">
		</div>
	</div>
	<div class="row form-row-gap-internal">
		<div class="col-lg-2">
			<b>Emp Type :</b>
		</div>
		<div class="col-lg-4">
			<select class="form-control" id="ddltype">
			  <option value="1">Admin</option>
			  <option value="2">Employee</option>
			</select>
		</div>
		<div class="col-lg-2">
			<b>Emp Status:</b>
		</div>
		<div class="col-lg-4">
			<select class="form-control" id="ddlstatus">
			  <option value="1">Activate</option>
			  <option value="0">Deactivate</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-10">
			<input id="txtEmployeeID" type="hidden" class="form-control">
		</div>
		<div class="col-lg-2 content-align-right">
			<button id="addEmployee" type="button" class="btn btn-primary">Add</button>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div id="toolbar">
					<div class="form-inline" role="form">
						<button id="addNewEmployee" type="button" class="btn btn-primary">Add New Employee</button>
					</div>
				</div>
				<table id="employee" data-toggle="table" data-show-refresh="false" data-show-toggle="true" data-show-columns="true" data-search="true" data-pagination="true" data-sort-name="name" data-sort-order="desc" data-toolbar="#toolbar">
					<thead>
					<tr>
						<th data-field="sl_no" data-sortable="false">Sl. No.</th>
						<th data-field="firstname"  data-sortable="true">First Name</th>
						<th data-field="lastname" data-sortable="false">Last Name</th>
						<th data-field="primary" data-sortable="false">Primary Contact No.</th>
						<th data-field="alternate" data-sortable="false">Alternate Contact No.</th>
						<th data-field="opIcon" data-sortable="false"></th>
					</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
//http://issues.wenzhixin.net.cn/bootstrap-table/index.html
//http://bootstrap-table.wenzhixin.net.cn/documentation/#methods
	
	$(document).ready(function() {
				
		pagereload();
				
		document.onkeyup = fkey;
		
		var wasPressed = false;

		function fkey(e){
			e = e || window.event;
			if( wasPressed ) return; 
			
			if (e.keyCode == 116) {
				location.reload(true);
			}
		}
		
		function pagereload() {
			$(".form-row-gap").hide();
		}
		
		$('#addNewEmployee').click(function() {
			$('#addEmployee').text('Add');
			$(".form-row-gap").show();
		});
				
		window.binddata = function() {
			var data = getALLEmployee();
			$('#employee').bootstrapTable('load', data);
		}
		
		binddata();
		
		function getALLEmployee() {
			
			var rows = "";
			$.ajax({
                    url: BASEURL + '/getALLEmployee',
                    cache: false,
					async: false,
                    method: 'GET',
                    success: function(data) {
						rows = data;
                    },
                    error: function(xhr,status,error) {
                        console.log(xhr.responseText);
                    }
                });
			return rows;
		}
		
		$('#addEmployee').click(function() {
					
			if (validation()) {
				$.ajax({
					url: BASEURL + '/updateEmployee',
					cache: false,
					type: 'POST',
					data: {EmployeeID: $('#txtEmployeeID').val(), firstname: $('#txtfirstname').val(), lastname: $('#txtlastname').val(), primaryno: $('#txtprimaryno').val(), alternateno: $('#txtalternateno').val(), password: $('#txtpassword').val(), type: $("#ddltype").val(), status: $("#ddlstatus").val()},
					success: function(data) {
						clearFields();
						alert(data);
						$(".form-row-gap").hide();
						binddata();
					},
					error: function(xhr,status,error) {
						alert(xhr.responseText);
					}
				});
			}
		});
	});
	
	deletes = function(id) {
		$.ajax({
                    url: BASEURL + '/deleteEmployee',
                    cache: false,
                    type: 'DELETE',
                    data: {EmployeeID: id},
                    success: function(data) {
						alert(data);
						binddata();
                    },
                    error: function(xhr,status,error) {
                        alert(xhr.responseText);
                    }
                });
	}
	
	edits = function(id) {
		$.ajax({
                    url: BASEURL + '/getEmployee',
                    cache: false,
                    type: 'get',
                    data: {EmployeeID: id},
                    success: function(datas) {
						$.each(datas, function(i, data) {
							console.log(data);
							$("#txtfirstname").val(data.emp_firstname);
							$("#txtlastname").val(data.emp_lastname);
							$("#txtprimaryno").val(data.emp_primaryno);
							$("#txtalternateno").val(data.emp_secondaryno);
							$("#txtpassword").val("");
							$("#txtrpassword").val("");
							$("#txtEmployeeID").val(data.emp_id);
							$("#ddltype").val(data.emp_type);
							$("#ddlstatus").val(data.emp_status);
							$('#addEmployee').text('Update');
							$(".form-row-gap").show();
						});
                    },
                    error: function(xhr,status,error) {
                        alert(xhr.responseText);
                    }
                });
	}
</script>

@endsection