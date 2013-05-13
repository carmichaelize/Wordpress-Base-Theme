<?php

class sc_product_post_type {

	public function post_type_options() {
		return array(
			'labels' => array(
				'name' => _x( 'Products', 'post type general name' ),
				'singular_name' => _x( 'Product', 'post type singular name' ),
				'add_new' => _x( 'Add New', 'book' ),
				'add_new_item' => __( 'Add New Product' ),
				'edit_item' => __( 'Edit Product' ),
				'new_item' => __( 'New Product' ),
				'all_items' => __( 'All Products' ),
				'view_item' => __( 'View Product' ),
				'search_items'  => __( 'Search Products' ),
				'not_found' => __( 'No products found' ),
				'not_found_in_trash' => __( 'No products found in the Trash' ), 
				'parent_item_colon' => '',
				'menu_name' => 'Products'
			),
			'description' => 'Holds our products and product specific data',
			'public' => true,
			'menu_position' => 5,
			//'menu_icon' => admin_url().'images/media-button-video.gif',
			'supports' => array( 'title', 'editor', 'thumbnail' ), // title, editor, thumbnail, excerpt, comments
			'has_archive'   => true,
			'rewrite' => array( 'slug' => 'products', 'with_front' => true )
		);
	}

	// public function post_taxonomy_options(){
	// 	return array(
	// 		'hierarchical' => false, // Hierarchical taxonomy (like categories)
	// 		// This array of options controls the labels displayed in the WordPress Admin UI
	// 		'labels' => array(
	// 			'name' => _x( 'Locations', 'taxonomy general name' ),
	// 			'singular_name' => _x( 'Location', 'taxonomy singular name' ),
	// 			'search_items' =>  __( 'Search Locations' ),
	// 			'all_items' => __( 'All Locations' ),
	// 			'parent_item' => __( 'Parent Location' ),
	// 			'parent_item_colon' => __( 'Parent Location:' ),
	// 			'edit_item' => __( 'Edit Location' ),
	// 			'update_item' => __( 'Update Location' ),
	// 			'add_new_item' => __( 'Add New Location' ),
	// 			'new_item_name' => __( 'New Location Name' ),
	// 			'menu_name' => __( 'Locations' ),
	// 		),
	// 		'rewrite' => array( // Control the slugs used for this taxonomy
	// 			'slug' => 'locations', // This controls the base slug that will display before each term
	// 			'with_front' => false, // Don't display the category base before "/locations/"
	// 			'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
	// 		)
	// 	);
	// }

	public function post_type_setup() {
		register_post_type( 'products', $this->post_type_options() );
	}

	// public function post_taxonomy_setup(){
	// 	register_taxonomy( 'location', 'products', $this->post_taxonomy_options() );
	// }

	public function __construct(){
		
		//Add Post Custom Type
		add_action( 'init', array(&$this, 'post_type_setup') );
		
		//Add Taxonomy to Custom Post type
		//add_action( 'init', array(&$this, 'post_taxonomy_setup'), 0 );
		
		//Reset Rewrites
		//flush_rewrite_rules(false);
	}

}

?>