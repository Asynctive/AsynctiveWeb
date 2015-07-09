<?php
	// Store checks for less repetitive code
	$is_home = ($page == 'home');
	$is_contact = ($page == 'contact');
	$is_signup = ($page == 'sign_up');
	$is_user_settings = ($page == 'user_settings');
	$is_pwreset = ($page == 'pwreset');
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
		<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
		
		<!-- Fonts -->
		<link href='http://fonts.googleapis.com/css?family=Nunito:700' rel='stylesheet' type='text/css'>
		
		<!-- Bootstrap -->
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
		<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		
		<link rel="stylesheet" type="text/css" href="/css/common.css">
		<?php if($is_contact): ?>
		<link rel="stylesheet" type="text/css" href="/css/contact.css">
		<script type="text/javascript" src="/js/contact.js"></script>
		<?php elseif($is_signup): ?>
		<link rel="stylesheet" type="text/css" href="/css/sign_up.css">
		<script type="text/javascript" src="/js/sign_up.js"></script>
		<?php elseif($is_user_settings): ?>
		<link rel="stylesheet" type="text/css" href="/css/user_settings.css">
		<script type="text/javascript" src="/js/user_settings.js"></script>
		<?php elseif($is_pwreset): ?>
		<link rel="stylesheet" type="text/css" href="/css/pwreset.css">
		<script type="text/javascript" src="/js/pwreset.js"></script>
		<?php endif ?>
	</head>
	
	<?php
		// Don't want to stick a bunch of code into the body tag for event handlers
		$onload = '';
		if ($is_contact)
			$onload = ' onload="setEmailFields()"';
	?>
	<body<?php echo $onload; ?>>
	
		<?php if (!isset($logged_in) && (!$is_signup || isset($registration_successful)) ): ?>
		<div id="top-bar" class="container">
			<?php $login_failed = isset($login_failed) ?>
			<div id="login-box" class="hidden-xs">
				<form role="form" class="form-inline" method="POST">
					<div class="col-sm-11 col-sm-offset-1 col-lg-7 col-lg-offset-5" <?php if($login_failed): ?>id="login-error"<?php endif ?>>
						<?php if($login_failed): ?>
						<p style="text-align: left; padding-left: 10px">Login Failed</p>
						<?php endif ?>
						
						<div class="form-group">
							<label for="login-username">Username:</label>
							<input id="login-username" name="login_username" type="text" class="form-control input-sm">
						</div>
						
						<div class="form-group" style="margin-left: 1em">
							<label for="login-password">Password:</label>
							<input id="login-password" name="login_password" type="password" class="form-control input-sm">
						</div>
						
						<button type="submit" class="btn btn-default" style="margin-left: 5px">Login</button>
						<a href="/sign_up">Sign Up</a>
						
						<p><a href="/pwreset" style="font-size: 0.85em">Forgot Password?</a></p>
					</div>
				</form>
			</div>
			
			<!-- Mobile login -->
			<div id="login-box-mobile" class="visible-xs">
				<form role="form" class="form-horizontal" method="POST" <?php if($login_failed): ?>id="login-error"<?php endif ?>>
					<?php if($login_failed): ?>
						<p>Login Failed</p>
					<?php endif ?>
					<div class="form-group">
						<label for="login-username-mobile" class="col-xs-3 control-label">Username</label>
						<div class="col-xs-9">
							<input id="login-username-mobile" type="text" name="login_username" class="form-control input-sm">
						</div>
					</div>
					
					<div class="form-group">
						<label for="login-password-mobile" class="col-xs-3 control-label">Password</label>
						<div class="col-xs-9">
							<input id="login-password-mobile" type="password" name="login_password" class="form-control input-sm">
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-xs-offset-3 col-xs-9">
							<button type="submit" class="btn btn-default">Login</button>
							<a href="/sign_up" style="margin-left: 5px">Sign Up</a>
						</div>
						
						<div class="col-xs-offset-3 col-xs-9" style="padding-top: 10px">
							<a href="/pwreset">Forgot Password?</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php elseif(!$is_signup): ?>
			
		<!-- User bar -->
		<div id="user-bar" class="container-fluid black-box vertical-align">
			<div class="row-fluid">				
				<div class="col-xs-7 col-sm-4 col-sm-offset-5">
					<div class="dropdown" style="text-align: right">
						<?php if(!$email_verified) echo '<span class="unverified-text">(Unverified)</span>' ?>
						<button class="btn btn-primary dropdown-toggle<?php if(!$email_verified) echo ' unverified' ?>" type="button" data-toggle="dropdown">
							<?php echo $username ?>
							<span class="caret"></span>
						</button>
						<br>
						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="/settings">Settings</a></li>
							<li><a href="#">Order History</a></li>
							<li><a href="logout">Logout</a></li>
						</ul>
					</div>
				</div>
				
				<div class="col-xs-5 col-sm-3">
					Checkout Placeholder
				</div>
			</div>
		</div>
		
		<?php endif ?>

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
					
					<?php if(isset($banned)): ?>
					<div id="ban-message">
						<h4><?php echo $ban['title'] ?></h4>
						<p>
							<?php echo $ban['message'] ?>
							<br>
							<p>Reason: <span style="font-style: italic"><?php echo $ban['reason'] ?></span></p>
						</p>
					</div>
					<?php endif ?>