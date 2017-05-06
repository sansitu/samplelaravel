@extends('layout.base')

@section('breadcrum', 'Manage Customer')
@section('customerActive','actives')

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
			<input id="txtCustomerID" type="hidden" class="form-control">
		</div>
		<div class="col-lg-2 content-align-right">
			<button id="addCustomer" type="button" class="btn btn-primary">Add</button>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div id="toolbar">
					<div class="form-inline" role="form">
						<button id="addNewCustomer" type="button" class="btn btn-primary">Add New Customer</button>
					</div>
				</div>
				<table id="customer" data-toggle="table" data-show-refresh="false" data-show-toggle="true" data-show-columns="true" data-search="true" data-pagination="true" data-sort-name="name" data-sort-order="desc" data-toolbar="#toolbar">
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
		
		function clearFields() {
			$("#txtfirstname").val("");
			$("#txtlastname").val("");
			$("#txtprimaryno").val("");
			$("#txtalternateno").val("");
			$("#txtCustomerID").val("");
			$("#ddlstatus").val('1');
		}
		
		function pagereload() {
			clearFields();
			$(".form-row-gap").hide();
		}
		
		$('#addNewCustomer').click(function() {
			clearFields();
			$('#addCustomer').text('Add');
			$(".form-row-gap").show();
		});
				
		window.binddata = function() {
			var data = getALLCustomer();
			$('#customer').bootstrapTable('load', data);
		}
		
		binddata();
		
		function getALLCustomer() {
			
			var rows = "";
			$.ajax({
                    url: BASEURL + '/getALLCustomer',
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
		
		$('#addCustomer').click(function() {
					
			if (validation()) {
				$.ajax({
					url: BASEURL + '/updateCustomer',
					cache: false,
					type: 'POST',
					data: {CustomerID: $('#txtCustomerID').val(), firstname: $('#txtfirstname').val(), lastname: $('#txtlastname').val(), primaryno: $('#txtprimaryno').val(), alternateno: $('#txtalternateno').val(), status: $("#ddlstatus").val()},
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
		
		function validation() 
		{
				var output = true;
				
				if ($("#txtfirstname").val() == "") {
					
					alert('Enter the first name');
					output = false;
				} else {
					
					if (!checkchar_space_dot($("#txtfirstname").val())) {
						
						alert('First name can not contain numbers, special characters except dot and space');
						output = false;
					} else {
					
						if ($("#txtlastname").val() == "") {
							
							alert('Enter the last name');
							output = false;
						} else {
							
							if (!checkchar_space_dot($("#txtlastname").val())) {
							
								alert('Last name can not contain numbers, special characters except dot and space');
								output = false;
							} else {
								
								if ($("#txtprimaryno").val() == "") {
							
									alert('Enter the primary contact no.');
									output = false;
								} else {
									
									if (!checkcontactno($("#txtprimaryno").val())) {
							
										alert('Primary contact no. can contain numbers only and atleast 10 digit length');
										output = false;
									} else {
											
										if (($("#txtalternateno").val() != "") && (!checkcontactno($("#txtalternateno").val())))  {
											
											alert('Alternate contact no. can contain numbers only and atleast 10 digit length');
											output = false;
										} 
									}
								}
							}				
						}
					}
				}
				
				return output;
			}
	});
	
	deletes = function(id) {
		$.ajax({
                    url: BASEURL + '/deleteCustomer',
                    cache: false,
                    type: 'DELETE',
                    data: {CustomerID: id},
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
                    url: BASEURL + '/getCustomer',
                    cache: false,
                    type: 'get',
                    data: {CustomerID: id},
                    success: function(datas) {
						$.each(datas, function(i, data) {
							console.log(data);
							$("#txtfirstname").val(data.cust_firstname);
							$("#txtlastname").val(data.cust_lastname);
							$("#txtprimaryno").val(data.cust_primaryno);
							$("#txtalternateno").val(data.cust_secondaryno);
							$("#txtCustomerID").val(data.cust_id);
							$("#ddlstatus").val(data.cust_status);
							$('#addCustomer').text('Update');
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