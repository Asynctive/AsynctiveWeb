<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Asynctive Admin | <?php echo $title ?></title>
		<meta name="robots" content="noindex, nofollow">
		
		<!-- jQuery -->
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<link rel="stylesheet" href="/resources/demos/style.css">
		
		<!-- Bootstrap -->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		
		<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
		
		<link rel="stylesheet" type="text/css" href="/css/admin.css">
		
		<?php if ($page == 'create_user'): ?>
		<script type="text/javascript" src="/js/admin/create_user.js"></script>
		<?php elseif ($page == 'admin_pwreset'): ?>
		<script type="text/javascript" src="/js/admin/pwreset.js"></script>
		<?php elseif ($page == 'admin_view_articles'): ?>
		<script type="text/javascript" src="/js/admin/view_articles.js"></script>
		<?php elseif ($page == 'admin_create_article' || $page == 'admin_edit_article'): ?>
		<script type="text/javascript" src="/js/admin/article_form.js"></script>
		<?php elseif ($page == 'admin_view_categories'): ?>
		<script type="text/javascript" src="/js/admin/view_news_categories.js"></script>
		<?php elseif ($page == 'admin_create_category'): ?>
		<script type="text/javascript" src="/js/admin/categories_form.js"></script>
		<?php elseif ($page == 'admin_view_users'): ?>
		<script type="text/javascript" src="/js/admin/view_users.js"></script>
		<?php endif ?>
	</head>
	
	<body>
		<div class="container">
			<header role="banner">
				<a href="/"><img class="img-responsive" src="/images/header_logo.png" style="border: 0" alt=""></a>
				
				<div class="row" style="width: 100%; height: 20px; background-color: #000000; border-radius: 25px; margin-left: 0">
				</div>
			</header>

			<?php if(array_key_exists('user_id', $_SESSION)): ?>
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<ul class="nav navbar-nav">
						<li><a href="/admin">Main</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">News <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="/admin/news/articles">Articles</a></li>
								<li><a href="/admin/news/categories">Categories</a></li>
							</ul>
						</li>
						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">Software <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="/admin/software/commercial">Commercial</a></li>
								<li><a href="/admin/software/opensource">Open Source</a></li>
								<li><a href="/admin/software/free">Free</a></li>
								<li><a href="/admin/software/categories">Categories</a></li>
							</ul>
						</li>
						<li><a href="/admin/users">Users</a></li>
						<li><a href="/admin/logout">Logout</a></li>
					</ul>
				</div>
			</nav>
			<?php endif ?>

			<main>
