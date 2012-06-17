<?php
//Some simple code for our widget-enabled sidebar
if ( function_exists('register_sidebar') )
    register_sidebar();

//Add support for Widget Areas
add_action( 'init', 'register_my_menu' );
add_action( 'init', 'footer_widgets' );

//Create Primary Navigation
function register_my_menu() {
	register_nav_menu( 'primary-menu', __( 'Primary Menu' ) );
}

//Create Footer Widgets
function footer_widgets() {
	
	register_sidebar( array(
		'name' => __( 'Footer Widget Area'),
		'id' => 'footer-widget-area',
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );

}

//Code for custom background support
add_custom_background();

//Enable post and comments RSS feed links to head
add_theme_support( 'automatic-feed-links' );

// Enable post thumbnails
add_theme_support('post-thumbnails');
set_post_thumbnail_size(520, 250, true);




?>