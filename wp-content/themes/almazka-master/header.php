<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1" />
	<meta name="viewport" content="minimal-ui">
	<meta name="format-detection" content="telephone=no">
	<meta name="description" content="Cайт портфолио веб-верстальщика Алены Яковленко">
	<link rel="icon" href="<?php bloginfo('template_url') ?>/favicon.ico">
	<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" /> 
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats please -->
	<link rel="stylesheet" href="<?php bloginfo('template_url') ?>/css/bootstrap.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php wp_get_archives('type=monthly&format=link'); ?>
	<?php //comments_popup_script(); // off by default ?>
	<?php wp_head(); ?>
</head>
<body>
<!-- begin main-container -->
<section id="main-container">
		<!-- begin Header -->
		<header class="header">
			<div class="top">
			<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<span class="skype"><i></i><a href="skype:almazka987?chat">almazka987</a></span>
					<span class="github"><i></i><a href="https://github.com/almazka">almazka</a></span>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12 right">
					<span class="mail"><i></i><a href="mailto:almazka@flylady.su">almazka@flylady.su</a></span>
				</div>
			</div>
			</div>
			</div>
				<!-- begin Nav -->
				<nav class="navbar" role="navigation">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="/"><img src="<?php bloginfo('template_url') ?>/img/logo2.png" alt="Logo" /></a>
					</div>
					
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav">
							<li class="active"><a href="/">Главная</a><i></i></li>
							<li ><a href="#about">Обо мне</a><i></i></li>
							<li ><a href="#works">Мои работы</a><i></i></li>
							<li ><a href="#order">Как заказать верстку</a><i></i></li>
							<li ><a href="#contacts">Контакты</a></li>
						</ul>
					</div><!--/.nav-collapse -->
					<div class="bg-navbar"><div></div></div>
				</div>
				</nav>
				<!-- end Nav -->
				<div class="bottom">
					<div class="container">
						<div class="description">
						<span class="astronavt"></span>
								<small>Нужна верстка?</small>
								<span>Вы по адресу</span>
								<a href="#order" class="btn">Заказать верстку</a>
						</div>
					</div>
				</div>
			</div>
		</header>
		<!-- end Header -->