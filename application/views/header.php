<?php
	// Store checks for less repetitive code
	$isHome = ($page == 'home');
	$isContact = ($page == 'contact');
	$isSignup = ($page == 'sign_up');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title><?php echo $title ?></title>
		<meta name="description" content="An upcoming software development organization">
		
		<!-- jQuery -->
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<?php if($isSignup): ?>
		<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
		<?php endif; ?>
		
		<!-- Fonts -->
		<link href='http://fonts.googleapis.com/css?family=Nunito:700' rel='stylesheet' type='text/css'>
		
		<!-- Bootstrap -->
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
		<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		
		<link rel="stylesheet" type="text/css" href="/css/common.css">
		<?php if($isContact): ?>
		<link rel="stylesheet" type="text/css" href="/css/contact.css">
		<script type="text/javascript" src="/js/contact.js"></script>
		<?php elseif($isSignup): ?>
		<link rel="stylesheet" type="text/css" href="/css/sign_up.css">
		<script type="text/javascript" src="/js/sign_up.js"></script>
		<?php endif; ?>
	</head>
	
	<?php
		// Don't want to stick a bunch of code into the body tag for event handlers
		$onload = '';
		if ($isContact)
			$onload = ' onload="setEmailFields()"';
	?>
	<body<?php echo $onload; ?>>
		
		<div id="top-bar" class="container">
		<?php if (!isset($logged_in) && !$isSignup): ?>
			<div id="login-box" class="hidden-xs">
				<form role="form" class="form-inline" method="POST">
					<div class="form-group">
						<label for="login-username">Username:</label>
						<input id="login-username" name="login-username" type="text" class="form-control input-sm">
					</div>
					
					<div class="form-group" style="margin-left: 1em">
						<label for="login-password">Password:</label>
						<input id="login-password" name="login-password" type="password" class="form-control input-sm">
					</div>
					
					<button type="submit" class="btn btn-default" style="margin-left: 5px">Login</button>
					<a href="/sign_up">Sign Up</a>
				</form>
			</div>
			
			<!-- Mobile login -->
			<div id="login-box-mobile" class="visible-xs">
				<form role="form" class="form-horizontal" method="POST">
					<div class="form-group">
						<label for="login-username-mobile" class="col-xs-3 control-label">Username</label>
						<div class="col-xs-9">
							<input id="login-username-mobile" type="text" name="login-username" class="form-control input-sm">
						</div>
					</div>
					
					<div class="form-group">
						<label for="login-password-mobile" class="col-xs-3 control-label">Password</label>
						<div class="col-xs-9">
							<input id="login-password-mobile" type="password" name="login-password" class="form-control input-sm">
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-xs-offset-3 col-xs-9">
							<button type="submit" class="btn btn-default">Login</button>
							<a href="/signup" style="margin-left: 5px">Sign Up</a>
						</div>
					</div>
				</form>
			</div>
			
		<?php else: ?>
			<!-- TODO: User bar -->
		<?php endif; ?>
		</div>

		<div id="main-wrapper" class="container">
			<div class="row">
				<header role="banner">
					<div class="col-xs-12 col-sm-5 col-md-5 col-lg-6">
						<img id="header-logo" class="img-responsive" src="/images/header_logo.png" alt="">
					</div>
					
					<div class="col-sm-2 hidden-xs" style="padding-right: 0">
						<img src="/images/header_curve.png" alt="" style="float: right">
					</div>
				</header>
				
				<nav id="main-nav" class="col-xs-12 col-sm-5 col-md-5 col-lg-4 black-box">
					<ul class="list-inline">
						<li><a class="nav-link" href="/">Home</a></li>
						<li><a class="nav-link" href="/software">Software</a></li>
						<li><a class="nav-link" href="/code">Code</a></li>
						<li><a class="nav-link" href="/support">Support</a></li>
					</ul>
				</nav>
				
			</div>
			
			<div class="row">
				<div id="nav-bottom-bar" class="col-sm-12 black-box hidden-xs"></div>
			</div>
			
			<div class="row">
				<div id="content-box" class="col-xs-12 black-box">
					<main role="main">
					
