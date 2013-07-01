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

include_once('inc/classes/post_gallery.php');
new sc_page_slider_images();

include_once('inc/classes/template_options.php');
new sc_page_template_style();

// include_once('inc/classes/product_post_type.php');
// new sc_product_post_type();

include_once('inc/classes/multichoice_meta.php');

new sc_multichoice_meta(array(
		'unique_id'=>'sc_multichoice_meta', //unique prefix
		'post_types' => array('post'), //post type to display on
		'post_types_to_display' => array('post', 'page'), //post types to be included in list
		'title'=>'Related Content', //meta box title
		'context'=>'side', //normal, advanced, side
		'priority'=>'high' //default, core, high, low
));

new sc_multichoice_meta(array(
		'post_types' => array('post'), //post type to display on
		'post_types_to_display' => array('page'), //post types to be included in list
		'unique_id'=>'sc_multichoice_meta_2', //unique prefix
		'title'=>'Related Staff', //title
		'context'=>'side', //normal, advanced, side
		'priority'=>'high' //default, core, high, low
));

//Theme Specific Functions
include_once('inc/functions.php');

//Admin Titdy
include_once('inc/admin_tidy.php');

//Flush Rewrite Rules (Development Only)
add_action('init', function(){
	//flush_rewrite_rules(false);
});


//Migration SQL
//UPDATE wp_options SET option_value = replace(option_value, 'http://mcnabs.dev', 'mcnabs.flintriverdev3.co.uk') WHERE option_name = 'home' OR option_name = 'siteurl';
//UPDATE wp_posts SET guid = REPLACE (guid, 'http://mcnabs.devm', 'mcnabs.flintriverdev3.co.uk');
//UPDATE wp_posts SET post_content = REPLACE (post_content, 'mcnabs.flintriverdev3.co.uk');
//UPDATE wp_postmeta SET meta_value = REPLACE (meta_value, 'http://mcnabs.dev','mcnabs.flintriverdev3.co.uk');

?>