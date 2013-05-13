<?php

//Globals
define( 'TEMPLATE_PATH', get_bloginfo('stylesheet_directory') );
define( 'TEMPLATE_ROOT', parse_url(TEMPLATE_PATH, PHP_URL_PATH) );
define( 'IMAGE_PATH', TEMPLATE_PATH. "/images" );

//Get Global Theme Options
$global_options = (object)get_option('sc_theme_options');

//Helper Functions
include_once('inc/helpers.php');
include_once('inc/wp_helpers.php');

//Custom Classes
include_once('inc/classes/settings_page.php');
new sc_theme_settings_page();

//include_once('inc/classes/template_options.php');
//new sc_page_template_style();

//include_once('inc/classes/product_post_type.php');
//new sc_product_post_type();

//Theme Specific Functions
include_once('inc/functions.php');

//Admin Titdy
include_once('inc/admin_tidy.php');

//Flush Rewrite Rules (Development Only)
add_action('init', function(){
	flush_rewrite_rules(false);
});


?>