@extends('layout.base')

@section('breadcrum', 'Manage Product Types')
@section('productTypeActive','actives')

@section('content')

<div class="row form-row-gap">
	<div class="col-lg-2">
		<b>Product Type :</b>
	</div>
	<div class="col-lg-4">
		<input id="txtProductType" type="text" class="form-control">
	</div>
	<div class="col-lg-2">
		<button id="addType" type="button" class="btn btn-primary">Add Type</button>
	</div>
	<div class="col-lg-1">
		<input id="txtProductTypeID" type="hidden" class="form-control">
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div id="toolbar">
					<div class="form-inline" role="form">
						<button id="addProductType" type="button" class="btn btn-primary">Add Product Type</button>
					</div>
				</div>
				<table id="productType" data-toggle="table" data-show-refresh="false" data-show-toggle="true" data-show-columns="true" data-search="true" data-pagination="true" data-sort-name="name" data-sort-order="desc" data-toolbar="#toolbar">
					<thead>
					<tr>
						<th data-field="sl_no" data-sortable="false">Sl. No.</th>
						<th data-field="pty_name"  data-sortable="true">Product Type Name</th>
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
			$("#txtProductType").val("");
			$(".form-row-gap").hide();
		}
		
		$('#addProductType').click(function() {
			$('#addType').text('Add Type');
			$("#txtProductType").val("");
			$("#txtProductTypeID").val("");
			$(".form-row-gap").show();
		});
				
		window.binddata = function() {
			var data = getALLProductType();
			$('#productType').bootstrapTable('load', data);
		}
		
		binddata();
		
		function getALLProductType() {
			
			var rows = "";
			$.ajax({
                    url: BASEURL + '/getALLProductType',
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
		
		$('#addType').click(function() {
			if ($("#txtProductType").val() == "") {
                alert("Enter the product type");                  
            } else {
				$.ajax({
                    url: BASEURL + '/updateProductType',
                    cache: false,
                    type: 'POST',
                    data: {ProductTypeID: $('#txtProductTypeID').val(), ProductType: $('#txtProductType').val()},
                    success: function(data) {
						$("#txtProductType").val("");
						$('#txtProductTypeID').val("");
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
                    url: BASEURL + '/deleteProductType',
                    cache: false,
                    type: 'DELETE',
                    data: {ProductTypeID: id},
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
                    url: BASEURL + '/getProductType',
                    cache: false,
                    type: 'get',
                    data: {ProductTypeID: id},
                    success: function(datas) {
						$.each(datas, function(i, data) {
							$('#txtProductTypeID').val(data.pty_id);
							$('#txtProductType').val(data.pty_name);
							$('#addType').text('Update Type');
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