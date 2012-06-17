<!doctype html>

<html <?php language_attributes(); ?>>

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />

<!-- Title dependent on what content is being viewed-->

<title>

	<?php
	
	global $page, $paged;

	wp_title( '-', true, 'right' );

	bloginfo( 'name' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " - $site_description";

	if ( $paged >= 2 || $page >= 2 )
		echo ' - ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?>

</title>

<!-- Meta dependent on what content is being viewed-->

<meta name="description" content="<?php if ( is_single() ) {
        single_post_title('', true); 
    } else {
        bloginfo('name'); echo " - "; bloginfo('description');
    }
    ?>" />


<?php global $post;
if( is_single() || is_page()) :
	$tags = get_the_tags($post->ID);
	if($tags) :
		foreach($tags as $tag) :
			$sep = (empty($keywords)) ? '' : ', ';
			$keywords .= $sep . $tag->name;
		endforeach;
?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php
	endif;
endif;
?>


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

  
