<!doctype html>

<html <?php language_attributes(); ?>>

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />

<!-- Page Meta Class ('inc/wp_helpers.php') -->
<title><?php echo page_meta::title(); ?></title>
<meta name="description" content="<?php echo page_meta::description(); ?>" />
<meta name="keywords" content="<?php echo page_meta::keywords(); ?>" />

<link rel="profile" href="http://gmpg.org/xfn/11" />

<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />


<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" /><!--favicon-->
<?php
	
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	wp_head();
?>
</head>

<body>

<div id="wrapper">
	
	<div id="header">
		
		<h1><a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a></h1>

		<?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'menu_class' => 'topNav', 'theme_location' => 'primary-menu' ) ); ?>

		<div class="clear"></div>

	</div>

<div id="mainContent">

	<?php 

// echo SC_Input::get('test', 'scott');

// echo SC_PageMeta::get_title();

	//var_dump( get_bloginfo('all') );

var_dump(page_meta::description());

?>

  
