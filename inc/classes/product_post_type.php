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
			'supports' => array( 'title', 'editor', 'thumbnail' ), // title, editor, thumbnail, excerpt, comments, page-attributes
			'has_archive'   => true,
			'rewrite' => array( 'slug' => 'products', 'with_front' => true ),
			//'hierarchical' => true
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

	public function post_type_menu_image(){ 
		//Menu Sprite Positions (remeber to change CSS selector below!)
			//Page -149px -33px, -149px -1px
			//Speech Buble -29px -33px, -29px -1px
			//Media -119px -33px, -119px -1px
			//Users -300px -33px, -300px -1px
			//Apperance 1px -33px, 1px -1px
			//Tools -209px -33px, -209px -1px
			//Settings -239px -33px, -239px -1px ?>

		<style>
		    #menu-posts-products .wp-menu-image {
		        background-position: -149px -33px !important;
		    }
		    #menu-posts-products:hover .wp-menu-image {
		        background-position: -149px -1px !important;
		    }
		</style>
	
	<?php }

	public function __construct(){
		
		//Add Post Custom Type
		add_action( 'init', array(&$this, 'post_type_setup') );
		
		//Add Taxonomy to Custom Post type
		//add_action( 'init', array(&$this, 'post_taxonomy_setup'), 0 );

		//Set Menu Image From Admin Sprite
		add_action( 'admin_head', array(&$this, 'post_type_menu_image') );
		
		//Reset Rewrites
		//flush_rewrite_rules(false);
	}

}

?>