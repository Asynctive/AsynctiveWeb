<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Asynctive | <?php echo ucfirst($page); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		
		<link rel="stylesheet" href="/css/main.css">
		
		<!-- Fonts -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:700' rel='stylesheet' type='text/css'>
		
		<!-- Bootstrap -->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	</head>
	
	<body>

		<header>
			<div class="container" style="margin-top: 5px">
				<div class="row">
					<div class="col-xs-12 col-sm-4 col-md-5 col-lg-6">
						<img id="header-image" class="img-responsive" src="/images/header_logo.png" alt="Asynctive">
					</div>
					
					<!-- Hidden on mobile -->
					<div class="hidden-xs">
						<div class="col-sm-2 col-md-2" style="padding-right: 0">
							<img src="/images/header_curve.png" alt="" style="float: right">
						</div>
						
						<nav id="header-side" class="col-sm-6 col-md-5 col-lg-4 black-box">
							<ul id="header-nav">
								<li><a href="/">Home</a></li>
								<li><a href="/products">Products</a></li>
								<li><a href="/support">Support</a></li>
								<li><a href="/login">Login</a></li>
							</ul>
						</nav>
					</div>
				</div>
				
				<div class="row">
					<div id="header-bottom" class="col-xs-12 black-box hidden-xs">
					</div>
				</div>
				
			</div>
		</header>
		
		<!-- Mobile nav -->
		<nav id="mobile-nav-box" class="navbar navbar-default navbar-toggle">
			<div class="container">
				<ul class="nav mobile-nav">
					<li><a href="/" style="border-top: 0">Home</a></li>
					<li><a href="/products">Products</a></li>
					<li><a href="/support">Support</a></li>
					<li><a href="/login">Login</a></li>
				</ul>
			</div>
		</nav>
		
		<!-- Empty container so the content-box doesn't overlap in mobile -->
		<div class="container"></div>
		
		<div id="content-box" class="container black-box">
			<main role="main">
				