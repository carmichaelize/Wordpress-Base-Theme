<?php
//Config Options
define('GOOGLE_ANALYTICS_ID', '123'); // UA-XXXXX-Y

//Globals
define( 'TEMPLATE_PATH', get_bloginfo('stylesheet_directory') );
define( 'TEMPLATE_ROOT', parse_url(TEMPLATE_PATH, PHP_URL_PATH) );
define( 'IMAGE_PATH', TEMPLATE_PATH. "/images");

//Helper Functions
include_once('inc/helpers.php');
include_once('inc/wp_helpers.php');

//Theme Specific Functions
include_once('inc/functions.php');

//Flush Rewrite Rules
add_action('init', function(){
	flush_rewrite_rules(false);
});


?>