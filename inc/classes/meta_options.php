<?php

class sc_meta_options {

	public $options = null;

	//Build 'Defaults' Object
	public function build_options() {
		return array(
			'unique_id'	  => 'sc_seo_meta_data', //unique prefix
			'post_types'  => get_post_types(), //post types
			'title'		  => 'SEO / Meta Settings', //meta box title
			'context'     => 'side', //normal, advanced, side
			'priority'    => 'low', //default, core, high, low
			'description' => '', //description text to appear in meta box
		);
	}

	public function custom_meta_add(){

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

		<?php if( $this->options->description ) : ?>
			<p><em><?php echo $this->options->description; ?></em></p>
		<?php endif; ?>

		<p>
			<label>Title</label>
			<input type="text" class="widefat" name="<?php echo $this->options->unique_id; ?>[title]" value="<?php echo $data['title']; ?>" />
		</p>

		<p>
			<label>Description</label>
			<textarea class="widefat" name="<?php echo $this->options->unique_id; ?>[description]"><?php echo $data['description']; ?></textarea>
		</p>

		<p>
			<label>Keywords (seperate each with a comma)</label>
			<input type="text" class="widefat" name="<?php echo $this->options->unique_id; ?>[keywords]" value="<?php echo $data['keywords']; ?>" />
		</p>

	<?php }

	public function custom_meta_save($post_id, $post=false){

		// Verify the nonce before proceeding.
		if ( !isset( $_POST[$this->options->unique_id.'_nonce'] ) || !wp_verify_nonce( $_POST[$this->options->unique_id.'_nonce'], basename( __FILE__ ) ) ){
			return $post_id;
		}

		// Get the posted data and sanitize it for use as an HTML class.
		$new_meta_value = ( isset( $_POST[$this->options->unique_id] ) ? $_POST[$this->options->unique_id] : '' );

		// Get the meta value of the custom field key.
		$meta_value = get_post_meta( $post_id, $this->options->unique_id, true );

		// If a new meta value was added and there was no previous value, add it.
		if ( $new_meta_value && '' == $meta_value ){
			add_post_meta( $post_id, $this->options->unique_id, $new_meta_value, true );
		}

		// If the new meta value does not match the old value, update it.
		elseif ( $new_meta_value && $new_meta_value != $meta_value ){
			update_post_meta( $post_id, $this->options->unique_id, $new_meta_value );
		}

		// If there is no new meta value but an old value exists, delete it.
		elseif ( '' == $new_meta_value && $meta_value ){
			delete_post_meta( $post_id, $this->options->unique_id, $meta_value );
		}

	}

	public function custom_meta_setup() {

		// Add Box
		add_action( 'add_meta_boxes', array(&$this, 'custom_meta_add' ));
		// Save Box
		add_action( 'save_post', array(&$this, 'custom_meta_save'));

	}

	public function __construct($params = array()){

		// Create 'Options' Object
		$this->options = (object)array_merge($this->build_options(), $params);

		add_action( 'init', array(&$this, 'custom_meta_setup'));

	}
}

?>