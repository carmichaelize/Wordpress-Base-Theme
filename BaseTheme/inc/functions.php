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

//return false;

class sc_custom_post_product {

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

		//flush_rewrite_rules(false);
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

//flush_rewrite_rules(false);

$product_type = new sc_custom_post_product();




// function custom_post_product() {
// 	$labels = array(
// 		'name'               => _x( 'Products', 'post type general name' ),
// 		'singular_name'      => _x( 'Product', 'post type singular name' ),
// 		'add_new'            => _x( 'Add New', 'book' ),
// 		'add_new_item'       => __( 'Add New Product' ),
// 		'edit_item'          => __( 'Edit Product' ),
// 		'new_item'           => __( 'New Product' ),
// 		'all_items'          => __( 'All Products' ),
// 		'view_item'          => __( 'View Product' ),
// 		'search_items'       => __( 'Search Products' ),
// 		'not_found'          => __( 'No products found' ),
// 		'not_found_in_trash' => __( 'No products found in the Trash' ), 
// 		'parent_item_colon'  => '',
// 		'menu_name'          => 'Products'
// 	);
// 	$args = array(
// 		'labels'        => $labels,
// 		'description'   => 'Holds our products and product specific data',
// 		'public'        => true,
// 		'menu_position' => 5,
// 		//'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
// 		'supports'      => array( 'title', 'editor', 'thumbnail' ),
// 		'has_archive'   => true,
// 		'rewrite' => array( 'slug' => 'products', 'with_front' => true ),

// 	);
// 	//flush_rewrite_rules(false);
// 	register_post_type( 'products', $args );
// 	//Reset Rewrites
// 	flush_rewrite_rules(false);
// }
// add_action( 'init', 'custom_post_product' );








/**
 * Add custom taxonomies
 *
 * Additional custom taxonomies can be defined here
 * http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
// function add_custom_taxonomies() {
// 	// Add new "Locations" taxonomy to Posts
// 	register_taxonomy('location', 'products', array(
// 		// Hierarchical taxonomy (like categories)
// 		'hierarchical' => false,
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
// 		// Control the slugs used for this taxonomy
// 		'rewrite' => array(
// 			'slug' => 'locations', // This controls the base slug that will display before each term
// 			'with_front' => false, // Don't display the category base before "/locations/"
// 			'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
// 		),
// 	));
// }
// add_action( 'init', 'add_custom_taxonomies', 0 );

// return false;

// function products_rewrite() {
// 	global $wp_rewrite;
// 	$wp_rewrite->add_permastruct('typename', 'typename/ ▶
// 	%year%/%postname%/', true, 1);
// 	add_rewrite_rule('typename/([0-9]{4})/(.+)/?$',
// 	'index.php?typename=$matches[2]', 'top');
// 	$wp_rewrite->flush_rules();
// }
// add_action('init', 'products_rewrite');




/* Custom Meta Boxes */



/* Meta Box Template */
class new_meta {

	public $options = null;

	//Build 'Defaults' Object
	public function build_options() {

		return (object)array(
			'unique_id'=>'personal_details', //unique prefix
			'title'=>'Test Scott', //title
			'post_type'=>'products', //post, page, or a custom post type
			'context'=>'side', //normal, advanced, side
			'priority'=>'default' //default, core, high, low
		);
	}

	public function meta_box_add() {

		add_meta_box(
			$this->options->unique_id, // Unique ID
			esc_html__( $this->options->title, 'example' ), //Title
			array(&$this, 'meta_box_render' ), // Callback (builds html)
			$this->options->post_type,	// Admin page (or post type)
			$this->options->context,	// Context
			$this->options->priority, // Priority
			$callback_args = null
		);

	}

	public function meta_box_render($object, $box){ ?>

		<?php wp_nonce_field( basename( __FILE__ ), $this->options->unique_id.'_nonce' ); 

		//var_dump(get_post_meta($object->ID, $this->options->unique_id, $new_meta_value, true));

		$data = get_post_meta($object->ID, $this->options->unique_id, $new_meta_value, true);

		$data = $data[0];

		?>

		<p>
			<label for="smashing-post-class">Name</label>
			<br />
			<input class="widefat" type="text" name="<?php echo $this->options->unique_id.'[name]'; ?>" id="smashing-post-class" value="<?php echo $data['name']; ?>" size="30" />
		</p>

		<p>
			<label for="smashing-post-class">Age</label>
			<br />
			<input class="widefat" type="text" name="<?php echo $this->options->unique_id.'[age]'; ?>" id="smashing-post-class" value="<?php echo $data['age']; ?>" size="30" />
		</p>

		<p>
			<input class="widefat" type="file" id="wp_custom_attachment" name="wp_custom_attachment" value="" size="25" />
		</p>


	<?php }

	public function meta_box_save($post_id, $post=false){

		/* Verify the nonce before proceeding. */
		if ( !isset( $_POST[$this->options->unique_id.'_nonce'] ) || !wp_verify_nonce( $_POST[$this->options->unique_id.'_nonce'], basename( __FILE__ ) ) ){
			return $post_id;
		}
			
		/* Get the post type object. */
		$post_type = get_post_type_object( $post->post_type );

		/* Check if the current user has permission to edit the post. */
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ){
			return $post_id;
		}
			
		/* Get the posted data and sanitize it for use as an HTML class. */
		$new_meta_value = ( isset( $_POST[$this->options->unique_id] ) ? sanitize_html_class( $_POST[$this->options->unique_id] ) : '' );

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

	public function meta_box_setup() {

		//Add Box
		add_action( 'add_meta_boxes', array(&$this, 'meta_box_add' ));

		/* Save Box */
		add_action( 'save_post', array(&$this, 'meta_box_save'));
		
	}

	public function __construct(){

		//Create 'Options' Object
		$this->options = $this->build_options();

		add_action( 'init', array(&$this, 'meta_box_setup'));

	}
}

$new = new new_meta();








/* Meta Box Template */
class sc_page_template_style {

	public $options = null;

	//Build 'Defaults' Object
	public function build_options() {
		return (object)array(
			'unique_id'=>'sc_page_template_style', //unique prefix
			'title'=>'Page Template', //title
			'context'=>'side', //normal, advanced, side
			'priority'=>'default' //default, core, high, low
		);
	}

	public function page_template_add() {

		$types = array('post', 'page');

		foreach($types as $post_type){
			add_meta_box(
				$this->options->unique_id, // Unique ID
				esc_html__( $this->options->title, 'example' ), //Title
				array(&$this, 'page_template_render' ), // Callback (builds html)
				$post_type, // Admin page (or post type)
				$this->options->context, // Context
				$this->options->priority, // Priority
				$callback_args = null
			);
		}

	}

	public function page_template_render($object, $box){

		wp_nonce_field( basename( __FILE__ ), $this->options->unique_id.'_nonce' ); 

		$data = get_post_meta($object->ID, $this->options->unique_id, $new_meta_value, true);

		$data = $data[0];

		$selected1 = '';
		$selected2 = '';
		if($data == 'one_column'){
			$selected1 = 'selected';
		} elseif($data == 'two_column'){
			$selected2 = 'selected';
		}

		?>

		<p>
			<select class="widefat" name="<?php echo $this->options->unique_id; ?>">
				<option <?php echo $selected1; ?> value="one_column">One Column</option>
				<option <?php echo $selected2; ?> value="two_column">Two Column</option>
			</select>
		</p>

		<!--<p>
			<select class="widefat" name="<?php echo $this->options->unique_id.'[template]'; ?>">
				<option <?php echo $selected1; ?> value="one_column">One Column</option>
				<option <?php echo $selected2; ?> value="two_column">Two Column</option>
			</select>
		</p> -->

		<?php 
		}

	public function page_template_save($post_id, $post=false){

		/* Verify the nonce before proceeding. */
		if ( !isset( $_POST[$this->options->unique_id.'_nonce'] ) || !wp_verify_nonce( $_POST[$this->options->unique_id.'_nonce'], basename( __FILE__ ) ) ){
			return $post_id;
		}
			
		/* Get the post type object. */
		$post_type = get_post_type_object( $post->post_type );

		/* Check if the current user has permission to edit the post. */
		// if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ){
		// 	return $post_id;
		// }
			
		/* Get the posted data and sanitize it for use as an HTML class. */
		$new_meta_value = ( isset( $_POST[$this->options->unique_id] ) ? sanitize_html_class( $_POST[$this->options->unique_id] ) : '' );

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
		// elseif ( '' == $new_meta_value && $meta_value ){
		// 	delete_post_meta( $post_id, $this->options->unique_id, $meta_value );
		// }
			

	}

	public function page_template_setup() {

		//Add Box
		add_action( 'add_meta_boxes', array(&$this, 'page_template_add' ));

		/* Save Box */
		add_action( 'save_post', array(&$this, 'page_template_save'));
		
	}

	public function __construct(){

		//Create 'Options' Object
		$this->options = $this->build_options();

		add_action( 'init', array(&$this, 'page_template_setup'));

	}
}

$new = new sc_page_template_style();

?>