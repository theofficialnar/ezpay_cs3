<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<link rel="shortcut icon" href="{{ url('favicon.ico') }}" type="image/x-icon">
	<link rel="icon" href="{{ url('favicon.ico') }}" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles.css') }}">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.0/css/iziModal.min.css">
</head>
<body style="position: relative">
	@include('../includes/fork')
	<div id="login_body"></div>
	<div id="logo_wrapper" class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
    	<img src="{{url('assets/images/payit4ward.png')}}" class="img-responsive hcenter">
    	@yield('main_section')
	</div>
	<canvas class="canvas"></canvas>
	


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="{{ URL::asset('js/dist/jquery.particles.js') }}"></script>
<script src="{{ URL::asset('js/scripts.js') }}"></script>

</body>
</html>