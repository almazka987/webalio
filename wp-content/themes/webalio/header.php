<?php
	$detect = new Mobile_Detect;
	$mobile = ( $detect->isMobile() && ! $detect->isTablet() ) || ( $detect->isMobile() && $detect->isTablet() );
	$mob_class = ( $mobile ) ? ' mobile' : '';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>" charset="<?php bloginfo('charset'); ?>" />
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
<div class="site-wrapper">
    <!-- begin Header -->
    <header class="header<?php echo $hdr_class; ?>">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-xs-4">
                        <div class="lang-switcher">
                            <?php echo qtranxf_generateLanguageSelectCode('both'); ?>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-8 pull-right">
                        <div class="header-contacts-box">
                            <span class="header-contact-item skype"><a href="skype:almazka987?chat"><i class="fab fa-skype fa-fw" aria-hidden="true"></i>@almazka987</a></span>
                            <span class="header-contact-item paper-plane"><a href="https://t.me/almazka987" target="blank"><i class="fa fa-paper-plane fa-fw" aria-hidden="true"></i>@almazka987</a></span>
                        </div>
                        <div class="header-contacts-box">
                            <span class="header-contact-item github"><a href="https://github.com/almazka987" target="blank"><i class="fab fa-github-alt fa-fw" aria-hidden="true"></i>almazka987</a></span>
                            <span class="header-contact-item mail"><a href="mailto:aliowebdeveloper@gmail.com"><i class="fa fa-envelope fa-fw" aria-hidden="true"></i>aliowebdeveloper@gmail.com</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- begin Nav -->
        <div class="navbar-fluid"></div>
        <nav class="navbar">
            <div class="container">
                <div class="nav-design">
                    <div class="nav-holder">
                        <div class="row">
                            <div class="col-sm-3">
                                <button class="hamburger hamburger--squeeze" type="button">
                              <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                              </span>
                                </button>
                                <a class="alio-logo" href="/"><img src="<?php echo get_template_directory_uri() . '/img/logo.png' ?>" alt="Logo" /></a>
                                <div class="clearfix"></div>
                            </div>

                            <div class="search-holder col-xs-9 col-sm-9 pull-right">
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
                        </div><!-- /row -->
                    </div>
                    <div class="bg-navbar"><div></div></div>
                </div><!-- /nav-holder -->
            </div><!-- /container -->
            <div class="bg-navbar full"><div></div></div>
        </nav>
        <!-- end Nav -->
        <?php if ( is_front_page() ): ?>
            <div class="header-bottom">
                <div class="container">
                    <div class="header-action">
                        <span class="header-action-heading"><?php _e("Нужен сайт?", "webalio"); ?></span>
                        <span class="header-action-answer"><?php _e("Вы по адресу", "webalio"); ?></span>
                        <a href="#lnk_order-form" class="alio-btn">
                            <i class="fa fa-lightbulb" aria-hidden="true"></i>
                            <span class="in-button"><?php _e("Заказать разработку", "webalio"); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="page-title"><?php the_title(); ?></h1>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="bg-bottom"></div>
    </header>
    <!-- end Header -->

    <section id="main-container">
