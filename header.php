<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />

		<!-- Page Meta Class ('inc/wp_helpers.php') -->
		<title><?php echo page_meta::title(); ?></title>
		<meta name="description" content="<?php echo page_meta::description(); ?>" />
		<meta name="keywords" content="<?php echo page_meta::keywords(); ?>" />

		<!-- Enable Responsive Techniques -->
	  	<!--<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport" />-->

	  	<!-- Favicon -->
	  	<link rel="shortcut icon" href="<?php echo TEMPLATE_PATH ?>/images/favicon.ico" />

	  	<!-- Stylesheets-->
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<!--[if lt IE 9]>
			<link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>/css/ie8.css" />
	  	<![endif]-->
		<!--[if lt IE 8]>
	    	<link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>/css/font-awesome-ie7.min.css" />
	    	<link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>/css/ie7.css" />
	  	<![endif]-->

		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

		<?php wp_head(); ?>
		
	</head>

	<body>

		<div class="wrapper">

			<?php get_search_form(); ?> 
			
			<header id="header">

				<a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a>

				<?php
					if( has_nav_menu('navigation-menu')){
						wp_nav_menu(array(
							'theme_location' => 'navigation-menu',
							'container'=> 'nav',
							'container_class' => 'top-nav',							
							'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s<div class="clear"></div></ul>',
							'sort_column' => 'menu_order'
						));
					}
				?>

				<div class="clear"></div>

			</header><!-- /#header -->

			<section class="inner-wrapper">