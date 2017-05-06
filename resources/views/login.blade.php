<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('custom.title') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
		
		    <!-- Bootstrap Core CSS -->
		<link href="{{ url('/') }}/css/bootstrap.min.css" rel="stylesheet">

		<!-- MetisMenu CSS -->
		<link href="{{ url('/') }}/css/metisMenu.min.css" rel="stylesheet">

		<!-- Timeline CSS -->
		<link href="{{ url('/') }}/css/timeline.css" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="{{ url('/') }}/css/startmin.css" rel="stylesheet">

		<!-- Morris Charts CSS -->
		<link href="{{ url('/') }}/css/morris.css" rel="stylesheet">
		
		<link href="{{ url('/') }}/css/bootstrap-table.css" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="{{ url('/') }}/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		<link href="{{ url('/') }}/css/common.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="{{ url('/') }}/js/html5shiv.js"></script>
		<script src="{{ url('/') }}/js/respond.min.js"></script>
		<![endif]-->
		
		<style>
		 .navbar {
			background-color: #23527c !important;
		 }
		 
		 .navbar-brand, .navbar-dropdown {
			color: #fff !important;
		 }
		 
		 .navbar-dropdown:hover {
			background-color: #e62e00 !important; 
		 }
		 
		 .actives {
			background-color: #66ccff !important;
			color: #fff !important;
		 }
		 
		 .dropdown-toggle {
			 color: #000 !important;
		 }
		 
		 .form-row-gap {
		  padding-bottom: 10px;
		}

		.form-row-gap-internal {
		  padding-bottom: 2px;
		}
		
		.content-align-right {
			text-align: right;
			padding-left: 1px;
		}
		
		.wrapper {    
	margin-top: 80px;
	margin-bottom: 20px;
}

.form-signin {
  max-width: 420px;
  padding: 30px 38px 66px;
  margin: 0 auto;
  background-color: #eee;
  border: 3px dotted rgba(0,0,0,0.1);  
  }

.form-signin-heading {
  text-align:center;
  margin-bottom: 30px;
}

.form-control {
  position: relative;
  font-size: 16px;
  height: auto;
  padding: 10px;
}

input[type="text"] {
  margin-bottom: 0px;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}

input[type="password"] {
  margin-top: 5px;
  margin-bottom: 0px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

button[type="Submit"] {
	margin-top: 20px;
}

.colorgraph {
  height: 7px;
  border-top: 0;
  background: #c4e17f;
  border-radius: 5px;
  background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
}
		</style>
		
		<script>
			var BASEURL = '<?php echo url('/'); ?>';
		</script>
				
		<!-- jQuery -->
		<script src="{{ url('/') }}/js/jquery.min.js"></script>
		<script src="{{ url('/') }}/js/jquery.validate.min.js"></script>

		<!-- Bootstrap Core JavaScript -->
		<script src="{{ url('/') }}/js/bootstrap.min.js"></script>

		<!-- Metis Menu Plugin JavaScript -->
		<script src="{{ url('/') }}/js/metisMenu.min.js"></script>

		<!-- Custom Theme JavaScript -->
		<script src="{{ url('/') }}/js/startmin.js"></script>
		
		<script src="{{ url('/') }}/js/bootstrap-table.js"></script>
		
		<script src="{{ url('/') }}/js/common.js"></script>
		
		<script>
                history.pushState(null, null, '');
                window.addEventListener('popstate', function () {
                    history.pushState(null, null, '');
                });
        </script>
    </head>
    <body>
		<div class = "container">
			<div class="wrapper">
				<form action="login" method="post" name="Login_Form" class="form-signin">
					<h3 class="form-signin-heading">Welcome Back! Please Sign In</h3>
					  <hr class="colorgraph"><br>
					  @if (session('status'))
							<div class="alert alert-danger">
								<strong>{{ session('status') }}</strong>
							</div>
						@endif
					  <input type="text" class="form-control" name="Mobileno" id="Mobileno" placeholder="Mobile No."/>
					  <input type="password" class="form-control" name="Password" id="Password" placeholder="Password"/>    
					  
					  <button class="btn btn-lg btn-primary btn-block"  name="Submit" value="Login" type="Submit">Login</button>  			
				</form>			
			</div>
		</div>
    </body>

	<script>
		$(function(){
			
			$.validator.addMethod("mobilenoCheck", function (value, element) {
				if (checkcontactno(value)) {
					return true;
				};
			});
    
			$("form[name='Login_Form']").validate({
				debug: false,
				rules: {
					Mobileno: {
							required: true,
							mobilenoCheck: true
						},
					Password: "required"
						},
				messages: {
					Mobileno: {
							required: "Enter the mobile number",
							mobilenoCheck: "Mobile no. can contain numbers only and atleast 10 digit length"
					},
					Password: "Enter the password",
				}
			});
	
		});
	</script>
</html>
