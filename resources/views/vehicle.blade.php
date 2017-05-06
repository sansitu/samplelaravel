@extends('layout.base')

@section('breadcrum', 'Manage Vehicles')
@section('vehicleActive','actives')

@section('content')

<div class="row form-row-gap">
	<div class="col-lg-2">
		<b>Vehicle Number :</b>
	</div>
	<div class="col-lg-4">
		<input id="txtvehicle" type="text" class="form-control">
	</div>
	<div class="col-lg-2">
		<button id="addVehicle" type="button" class="btn btn-primary">Add</button>
	</div>
	<div class="col-lg-1">
		<input id="txtVehicleID" type="hidden" class="form-control">
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div id="toolbar">
					<div class="form-inline" role="form">
						<button id="addNewVehicle" type="button" class="btn btn-primary">Add New Vehicle</button>
					</div>
				</div>
				<table id="vehicle" data-toggle="table" data-show-refresh="false" data-show-toggle="true" data-show-columns="true" data-search="true" data-pagination="true" data-sort-name="name" data-sort-order="desc" data-toolbar="#toolbar">
					<thead>
					<tr>
						<th data-field="sl_no" data-sortable="false">Sl. No.</th>
						<th data-field="v_number"  data-sortable="true">Vehicle Number</th>
						<th data-field="operation" data-sortable="false"></th>
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
			$("#txtvehicle").val("");
			$(".form-row-gap").hide();
		}
		
		$('#addNewVehicle').click(function() {
			$('#addVehicle').text('Add');
			$("#txtvehicle").val("");
			$("#txtVehicleID").val("");
			$(".form-row-gap").show();
		});
				
		window.binddata = function() {
			var data = getALLVehicle();
			$('#vehicle').bootstrapTable('load', data);
		}
		
		binddata();
		
		function getALLVehicle() {
			
			var rows = "";
			$.ajax({
                    url: BASEURL + '/getALLVehicle',
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
		
		$('#addVehicle').click(function() {
			if ($("#txtvehicle").val() == "") {
                alert("Enter the vehicle number");                  
            } else {
				$.ajax({
                    url: BASEURL + '/updateVehicle',
                    cache: false,
                    type: 'POST',
                    data: {VehicleID: $('#txtVehicleID').val(), Vehicle: $('#txtvehicle').val()},
                    success: function(data) {
						$("#txtvehicle").val("");
						$('#txtVehicleID').val("");
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
                    url: BASEURL + '/deleteVehicle',
                    cache: false,
                    type: 'DELETE',
                    data: {VehicleID: id},
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
                    url: BASEURL + '/getVehicle',
                    cache: false,
                    type: 'get',
                    data: {VehicleID: id},
                    success: function(datas) {
						$.each(datas, function(i, data) {
							console.log(data);
							$('#txtVehicleID').val(data.v_id);
							$('#txtvehicle').val(data.v_number);
							$('#addVehicle').text('Update');
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