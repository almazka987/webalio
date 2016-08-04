<?php
	$detect = new Mobile_Detect;
	$mobile = ( $detect->isMobile() && ! $detect->isTablet() ) ? true : false;
	$mob_class = ( $mobile ) ? ' mobile' : '';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" /> 
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'alio' . $mob_class ); ?>>

<!-- begin main-container -->
<?php
	$hdr_class = ( is_front_page() ) ? '' : ' middle';
?>
<section id="main-container">
		<!-- begin Header -->
		<header class="header<?php echo $hdr_class; ?>">
			<div class="top">
			<div class="container">
			<div class="row contacts-holder">
				<div class="col-md-6 col-sm-6 col-xs-12 contacts-top">
					<span class="skype"><i></i><a href="skype:almazka987?chat">almazka987</a></span>
					<span class="github"><i></i><a href="https://github.com/aliomaster">aliomaster</a></span>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12 right contacts-bottom">
					<span class="mail"><i></i><a href="mailto:aliowebdeveloper@gmail.com">aliowebdeveloper@gmail.com</a></span>
				</div>
			</div>
			</div>
			</div>
				<!-- begin Nav -->
				<nav class="navbar">
					<div class="container">
						<div class="row nav-holder">
							<div class="col-md-3">
								<a href="#" class="hmbrgr"></a>
								<a class="alio-logo" href="/"><img src="<?php echo get_template_directory_uri() . '/img/logo.png' ?>" alt="Logo" /></a>
							</div>
							<?php if ( $mobile ): ?>
								<div class="search-holder col-xs-9">
									<?php get_search_form(); ?>
								</div>
								<div class="col-xs-12">
								<?php 
									wp_nav_menu(
										array(
											'menu'              => 'primary',
											'theme_location'    => 'primary',
											'depth'             => 2,
											'container'         => 'div',
											'container_class'   => 'collapse navbar-collapse',
											'container_id'      => 'primary-navbar-collapse',
											'menu_class'        => 'alio-navbar',
											'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
											'walker' => new wp_bootstrap_navwalker(),
										)
									);
								?>
							</div>
							<?php else: ?>
								<div class="col-md-7">
									<?php 
										wp_nav_menu(
											array(
												'menu'              => 'primary',
												'theme_location'    => 'primary',
												'depth'             => 2,
												'container'         => 'div',
												'container_class'   => 'collapse navbar-collapse',
												'container_id'      => 'primary-navbar-collapse',
												'menu_class'        => 'alio-navbar',
												'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
												'walker' => new wp_bootstrap_navwalker(),
											)
										);
									?>
								</div>
								<div class="col-md-2">
									<?php get_search_form(); ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="bg-navbar"><div></div></div>
					</div>
				</nav>
				<!-- end Nav -->
				<?php if ( is_front_page() ): ?>
					<div class="bottom">
						<div class="container">
							<div class="description">
									<small>Нужен сайт?</small>
									<span class="address">Вы по адресу</span>
									<a href="#lnk_order-form" class="alio-btn">
									<i class="fa fa-lightbulb-o" aria-hidden="true"></i>
									<span class="in-button"> Заказать сайт</span></a>
							</div>
						</div>
					</div>
				<?php else: ?>
					<div class="heading-page container">
						<div class="row">
							<div class="col-md-6">
								<h1 class="page-title"><?php the_title(); ?></h1>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</header>
		<!-- end Header -->