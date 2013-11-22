<?php

//Globals
define( 'TEMPLATE_PATH', get_bloginfo('stylesheet_directory') );
define( 'TEMPLATE_ROOT', parse_url(TEMPLATE_PATH, PHP_URL_PATH) );
define( 'IMAGE_PATH', TEMPLATE_PATH. "/images" );
// WP_CONTENT_URL, WP_CONTENT_DIR

//Get Global Theme Options
$global_options = (object)get_option('sc_theme_options');

//Helper Functions
if ( !class_exists('Str') ) {
	include_once('inc/helpers.php');
}
include_once('inc/wp_helpers.php');

//Custom Classes
include_once('inc/classes/settings_page.php');
include_once('inc/classes/meta_options.php');
//include_once('inc/classes/product_post_type.php');
//include_once('inc/classes/template_options.php');
include_once('inc/classes/mockingbird/index.php');
include_once('inc/classes/page_editors.php');
include_once('inc/classes/post_gallery.php');
include_once('inc/classes/icon_meta.php');

//Page Template Select page-{template_name}.php && // Template Name: My Custom Page //
//get_page_template() is_page_template()

new sc_theme_settings_page();
new sc_meta_options(array('post_types'=>array('post', 'page')));
// new sc_post_type_template_select(array('unique_id'=>'template_select'));
// new sc_product_post_type();
// new sc_icon_meta(array('unique_id'=>'icon_test'));
// new sc_post_type_text_editors(array('unique_id'=>'test'));
if( is_admin() ){
	new Mockingbird_admin( 'sc_related_pages' );
	//get_mockingbird(get_the_id(), false, 'sc_related_pages')
}

new sc_post_gallery(array('unique_id'=>'gallery_1'));
// new sc_post_gallery(array('unique_id'=>'gallery_2', 'single'=>true));

//Theme Specific Functions
include_once('inc/functions.php');

//Admin Titdy
include_once('inc/admin_tidy.php');

//Flush Rewrite Rules (Development Only)
//add_action('init', function(){
	//flush_rewrite_rules(false);
//});

/** Turn Off Revisions (Paste in wp-config.php) */
//define('WP_POST_REVISIONS', false );

?>