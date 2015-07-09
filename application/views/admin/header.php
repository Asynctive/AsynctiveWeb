<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Asynctive Admin | <?php echo $title ?></title>
		<meta name="robots" content="noindex, nofollow">
		
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
		<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		
		<link rel="stylesheet" type="text/css" href="/css/admin.css">
		
		<?php if ($page == 'create_user'): ?>
		<script type="text/javascript" src="/js/admin/create_user.js"></script>
		<?php elseif ($page == 'admin_pwreset'): ?>
		<script type="text/javascript" src="/js/admin/pwreset.js"></script>
		<?php endif ?>
	</head>
	
	<body>
		<div class="container">
			<img class="img-responsive" src="/images/header_logo.png" alt="">
			
			<div class="row" style="width: 100%; height: 20px; background-color: #000000; border-radius: 25px">
			</div>