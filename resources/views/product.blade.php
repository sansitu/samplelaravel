@extends('layout.base')

@section('breadcrum', 'Manage Product')
@section('productActive','actives')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div id="toolbar">
					<div class="form-inline" role="form">
						<button id="addProduct" type="button" class="btn btn-primary">Add Product</button>
					</div>
				</div>
				<table id="product" data-toggle="table" data-show-refresh="false" data-show-toggle="true" data-show-columns="true" data-search="true" data-pagination="true" data-sort-name="name" data-sort-order="desc" data-toolbar="#toolbar">
					<thead>
					<tr>
						<th data-field="sl_no" data-sortable="false">Sl. No.</th>
						<th data-field="prod_name"  data-sortable="true">Product Name</th>
						<th data-field="operation" data-sortable="false"></th>
					</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>


@endsection