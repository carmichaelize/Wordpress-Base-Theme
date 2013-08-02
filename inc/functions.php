<?php

/*
|--------------------------------------------------------------------------
| Load JS Scripts
|--------------------------------------------------------------------------
*/

function load_the_scripts_first(){
	//Register JS Scripts
	wp_register_script('modernizr', TEMPLATE_PATH.'/js/modernizr-2.6.2.min.js', false, null, false);
	wp_register_script('jQuery', TEMPLATE_PATH.'/js/jquery-1.9.1.min.js', false, null, true);
	wp_register_script('utilities', TEMPLATE_PATH.'/js/utilities.js', false, null, true);
	//wp_register_script('bootstrap', TEMPLATE_PATH.'/js/bootstrap.min.js', false, null, true);
	
	//Activate JS Scripts
	wp_enqueue_script('modernizr');
	wp_enqueue_script('jQuery');
	wp_enqueue_script('utilities');
	//wp_enqueue_script('bootstrap');
}

function load_the_scripts_last(){
	wp_register_script('script', TEMPLATE_PATH.'/js/script.js', false, null, true);
	wp_enqueue_script('script');
}

add_action('wp_enqueue_scripts_first', 'load_the_scripts', 0);
add_action('wp_enqueue_scripts_last', 'load_the_scripts');

//Add Google Analytics 
if ( isset($global_options->google_analytics_key) && $global_options->google_analytics_key != "" ) {
	function add_google_analytics() {
		global $global_options;
		echo "<script type='text/javascript'>var _gaq=[['_setAccount','".$global_options->google_analytics_key."'],['_trackPageview']];(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';s.parentNode.insertBefore(g,s)}(document,'script'));</script>";
	}
    add_action('wp_footer', 'add_google_analytics', 20);
}


/*
|--------------------------------------------------------------------------
| Sidebar and Other Widget Areas
|--------------------------------------------------------------------------
*/

//Some simple code for our widget-enabled sidebar
if( function_exists('register_sidebar') ){
	register_sidebar();
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
add_action( 'init', 'footer_widgets' );

/*
|--------------------------------------------------------------------------
| Custom Menus
|--------------------------------------------------------------------------
*/
    
//Create Primary Navigation
function activate_menus() {
	register_nav_menu( 'navigation-menu', 'Main Menu');
	//register_nav_menu( 'footer-menu', 'Footer Menu');
}
add_action( 'init', 'activate_menus' );


/*
|--------------------------------------------------------------------------
| Other
|--------------------------------------------------------------------------
*/

//Custom background support
//add_custom_background();

//Enable post and comments RSS feed links to head
add_theme_support( 'automatic-feed-links' );

// Enable post thumbnails
//add_theme_support('post-thumbnails');
//set_post_thumbnail_size(520, 250, true);

?>