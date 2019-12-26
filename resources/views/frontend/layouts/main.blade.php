<!doctype html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Title Of Site -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	<!-- Fav and Touch Icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/frontend/images/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/frontend/images/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/frontend/images/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="/frontend/images/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="/favicon.png">

	<!-- CSS Plugins -->
	<link rel="stylesheet" type="text/css" href="/frontend/bootstrap/css/bootstrap.min.css" media="screen">
	<link href="/frontend/css/animate.css" rel="stylesheet">
	<link href="/frontend/css/main.css" rel="stylesheet">
	<link href="/frontend/css/component.css" rel="stylesheet">
	
	<!-- CSS Font Icons -->
	<link rel="stylesheet" href="/frontend/icons/open-iconic/font/css/open-iconic-bootstrap.css">
	<link rel="stylesheet" href="/frontend/icons/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="/frontend/icons/pe-icon-7-stroke/css/pe-icon-7-stroke.css">
	<link rel="stylesheet" href="/frontend/icons/ionicons/css/ionicons.css">
	<link rel="stylesheet" href="/frontend/icons/rivolicons/style.css">
	<link rel="stylesheet" href="/frontend/icons/streamline-outline/flaticon-streamline-outline.css">
	<link rel="stylesheet" href="/frontend/icons/around-the-world-icons/around-the-world-icons.css">
	<link rel="stylesheet" href="/frontend/icons/et-line-font/style.css">

	<!-- Google Fonts -->
	<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,300italic,400italic,700italic' rel='stylesheet' type='text/css'>

	<!-- CSS Custom -->
	<link href="/frontend/css/style.css" rel="stylesheet">
	
	<!-- Add your style -->
	<link href="/frontend/css/your-style.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	@yield('head-component')

	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
					new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
				j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
				'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-MPRQF46');</script>
	<!-- End Google Tag Manager -->

	
</head>


<body class="not-home">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MPRQF46"
				  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

	<!-- start Container Wrapper -->
	<div class="container-wrapper colored-navbar-brand">
		
		<!-- start Header -->
		@include('frontend.layouts.headerNavbar')
		<!-- end Header -->
		
		<div class="clear"></div>
		
		<!-- start Main Wrapper -->
		<div class="main-wrapper">
			
			@include('frontend.layouts.breadcrumbs')

			<div class="clear"></div>

			@yield('main-content')

			@include('frontend.layouts.footer')
			
		</div>

	</div> <!-- / .wrapper -->
	<!-- end Container Wrapper -->

 <!-- start Back To Top -->
<div id="back-to-top">
   <a href="#"><i class="ion-ios-arrow-up"></i></a>
</div>
<!-- end Back To Top -->

	<!-- jQuery Cores -->
	<script type="text/javascript" src="/frontend/js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="/frontend/js/jquery-migrate-1.2.1.min.js"></script>

	<!-- Bootstrap Js -->
	<script type="text/javascript" src="/frontend/bootstrap/js/bootstrap.min.js"></script>

	<!-- Plugins - serveral jquery plugins that use in this template -->
	<script type="text/javascript" src="/frontend/js/plugins.js"></script>

	<!-- Custom js codes for plugins -->
	<script type="text/javascript" src="/frontend/js/customs.js"></script>

	<!-- Date Piacker -->
	<script type="text/javascript" src="/frontend/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="/frontend/js/customs-datepicker.js"></script>

    <!-- User components -->
	@yield('js-component')

</body>


</html>