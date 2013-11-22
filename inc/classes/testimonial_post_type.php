<?php

class sc_testimonial_post_type {

	public function post_type_options() {
		return array(
			'labels' => array(
				'name' => _x( 'Testimonials', 'post type general name' ),
				'singular_name' => _x( 'Testimonial', 'post type singular name' ),
				'add_new' => _x( 'Add New', 'book' ),
				'add_new_item' => __( 'Add New Testimonial' ),
				'edit_item' => __( 'Edit Testimonial' ),
				'new_item' => __( 'New Testimonial' ),
				'all_items' => __( 'All Testimonials' ),
				'view_item' => __( 'View Testimonial' ),
				'search_items'  => __( 'Search Testimonials' ),
				'not_found' => __( 'No testimonials found.' ),
				'not_found_in_trash' => __( 'No testimonials found in the trash.' ),
				'parent_item_colon' => '',
				'menu_name' => 'Testimonials'
			),
			'description' => 'Holds our testimonials and testimonial specific data',
			'public' => true,
			'menu_position' => 20,
			//'menu_icon' => admin_url().'images/press-this.png',
			'supports' => array( 'title', 'editor' ), // title, editor, thumbnail, excerpt, comments
			'has_archive'   => true,
			'rewrite' => array( 'slug' => 'testimonials', 'with_front' => true )
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
		register_post_type( 'testimonials', $this->post_type_options() );
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
		    #menu-posts-testimonials .wp-menu-image {
		        background-position: -29px -33px !important;
		    }
		    #menu-posts-testimonials:hover .wp-menu-image {
		        background-position: -29px -1px !important;
		    }
		</style>

	<?php }

//Custom Meta Boxes

	public $options = null;

	//Build 'Defaults' Object
	public function build_options() {
		return (object)array(
			'post_types' => array('testimonials'),
			'unique_id'  => 'sc_testimonial_details', //unique prefix
			'title'		 => 'Testimonial Details', //title
			'context'	 => 'side', //normal, advanced, side
			'priority'	 => 'default' //default, core, high, low
		);
	}

	public function custom_meta_add() {

		foreach($this->options->post_types as $post_type){
			add_meta_box(
				$this->options->unique_id, // Unique ID
				esc_html__( $this->options->title, 'example' ), //Title
				array(&$this, 'custom_meta_render' ), // Callback (builds html)
				$post_type, // Admin page (or post type)
				$this->options->context, // Context
				$this->options->priority, // Priority
				$callback_args = null
			);
		}

	}

	public function custom_meta_render($object, $box){

		wp_nonce_field( basename( __FILE__ ), $this->options->unique_id.'_nonce' );

		$data = get_post_meta($object->ID, $this->options->unique_id, true);

		?>
			<p>
				<label for="sc_job_name">Name:</label>
				<br />
				<input type="text" id="sc_job_name" class="widefat" name="<?php echo $this->options->unique_id; ?>[name]" value="<?php echo $data['name'] ?>" />
			</p>

			<p>
				<label for="sc_job_comapny">Company:</label>
				<br />
				<input type="text" id="sc_job_comapny" class="widefat" name="<?php echo $this->options->unique_id; ?>[company]" value="<?php echo $data['company'] ?>" />
			</p>

			<p>
				<label for="sc_job_position">Position:</label>
				<br />
				<input type="text" id="sc_job_position" class="widefat" name="<?php echo $this->options->unique_id; ?>[position]" value="<?php echo $data['position'] ?>" />
			</p>

		<?php }

	public function custom_meta_save($post_id, $post=false){

		/* Verify the nonce before proceeding. */
		if ( !isset( $_POST[$this->options->unique_id.'_nonce'] ) || !wp_verify_nonce( $_POST[$this->options->unique_id.'_nonce'], basename( __FILE__ ) ) ){
			return $post_id;
		}

		/* Get the posted data and sanitize it for use as an HTML class. */
		$new_meta_value = ( isset( $_POST[$this->options->unique_id] ) ? $_POST[$this->options->unique_id] : '' );

		/* Get the meta value of the custom field key. */
		$meta_value = get_post_meta( $post_id, $this->options->unique_id, true );

		/* If a new meta value was added and there was no previous value, add it. */
		if ( $new_meta_value && '' == $meta_value ){
			add_post_meta( $post_id, $this->options->unique_id, $new_meta_value, true );
		}

		/* If the new meta value does not match the old value, update it. */
		elseif ( $new_meta_value && $new_meta_value != $meta_value ){
			update_post_meta( $post_id, $this->options->unique_id, $new_meta_value );
		}

		/* If there is no new meta value but an old value exists, delete it. */
		elseif ( '' == $new_meta_value && $meta_value ){
			delete_post_meta( $post_id, $this->options->unique_id, $meta_value );
		}

	}

	public function custom_meta_setup() {

		//Add Box
		add_action( 'add_meta_boxes', array(&$this, 'custom_meta_add' ));
		//Save Box
		add_action( 'save_post', array(&$this, 'custom_meta_save'));

	}

	public function __construct(){

		//Add Post Custom Type
		add_action( 'init', array(&$this, 'post_type_setup') );

		//Add Taxonomy to Custom Post type
		//add_action( 'init', array(&$this, 'post_taxonomy_setup'), 0 );

		//Set Menu Image From Admin Sprite
		add_action( 'admin_head', array(&$this, 'post_type_menu_image') );

		//Create 'Options' Object
		$this->options = $this->build_options();
		//Add Custom Meta
		add_action( 'init', array(&$this, 'custom_meta_setup'));

	}

}

?>