@extends('layout.base')

@section('breadcrum', 'Dashboard')
@section('dashboardActive','actives')

@section('content')

<div class="row">
	<div class="col-xs-12 col-md-6 col-lg-3">
		<div class="panel panel-blue panel-widget ">
			<div class="row no-padding">
				<div class="col-sm-3 col-lg-5 widget-left">
					<i class="fa fa-users fa-3x"></i>
				</div>
				<div class="col-sm-9 col-lg-7 widget-right">
					<div class="large" id="statEmp">0</div>
					<div class="text-muted">Employees</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-md-6 col-lg-3">
		<div class="panel panel-orange panel-widget">
			<div class="row no-padding">
				<div class="col-sm-3 col-lg-5 widget-left">
					<i class="fa fa-users fa-3x"></i>
				</div>
				<div class="col-sm-9 col-lg-7 widget-right">
					<div class="large" id="statCust">0</div>
					<div class="text-muted">Customers</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-md-6 col-lg-3">
		<div class="panel panel-teal panel-widget">
			<div class="row no-padding">
				<div class="col-sm-3 col-lg-5 widget-left">
					<i class="fa fa-product-hunt fa-3x"></i>
				</div>
				<div class="col-sm-9 col-lg-7 widget-right">
					<div class="large" id="statProd">0</div>
					<div class="text-muted">Products</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-md-6 col-lg-3">
		<div class="panel panel-red panel-widget">
			<div class="row no-padding">
				<div class="col-sm-3 col-lg-5 widget-left">
					
				</div>
				<div class="col-sm-9 col-lg-7 widget-right">
					<div class="large"></div>
					<div class="text-muted"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

$(document).ready(function() {
	
	var wk;

	startWorker();

	function startWorker() {
		
		if(typeof(Worker) !== "undefined") {
			if(typeof(wk) == "undefined") {
				var stat = BASEURL+"/js/updateStat.js";
				wk = new Worker(stat);
			}
			wk.addEventListener('message', function(event) {
				//console.log(event.data);
				stat = JSON.parse(event.data);
				$('#statEmp').html(stat[0]);
				$('#statCust').html(stat[1]);
				$('#statProd').html(stat[2]);
			}, false);
			
			var postData = { "BASEURL": BASEURL };
			wk.postMessage(postData); // Send data to our worker.
		} else {
			alert("Sorry! No Web Worker support.");
		}
	}
});

</script>

@endsection