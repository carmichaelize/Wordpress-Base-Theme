<?php

class sc_post_type_template_select {

	public $options = null;

	//Build 'Defaults' Object
	public function build_options() {
		return array(
			'unique_id'=>'sc_page_template_style', //unique prefix
			'post_types' => array('page'), //post types
			'title'=>'Page Template', //title
			'context'=>'side', //normal, advanced, side
			'priority'=>'default', //default, core, high, low
			'options'=> array('template_one' => 'Template One')
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

		$data = get_post_meta($object->ID, $this->options->unique_id, $new_meta_value, true);

		$data = $data[0];

		?>

		<p>
			<select class="widefat" name="<?php echo $this->options->unique_id; ?>[template]">

				<?php foreach($this->options->options as $option_value => $option_label) : ?>

					<option <?php echo $data['template'] == $option_value ? 'selected' : '' ; ?> value="<?php echo $option_value; ?>"><?php echo $option_label; ?></option>

				<?php endforeach; ?>

			</select>
		</p>

		<!-- <p>
			<label for="sc_include_testimonial">
				<input id="sc_include_testimonial" type="checkbox" name="<?php echo $this->options->unique_id; ?>[testimonial]" <?php echo $data['testimonial'] ? 'checked' : '' ; ?> > 
				Include Testimonial?
			</label>
		</p> -->

		<?php 
	}

	public function custom_meta_save($post_id, $post=false){

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
		elseif ( '' == $new_meta_value && $meta_value ){
			delete_post_meta( $post_id, $this->options->unique_id, $meta_value );
		}
			

	}

	public function custom_meta_setup() {

		//Add Box
		add_action( 'add_meta_boxes', array(&$this, 'custom_meta_add' ));
		// Save Box
		add_action( 'save_post', array(&$this, 'custom_meta_save'));
		
	}

	public function __construct($params = array()){

		//Check Unique ID Isset
		if( !isset($params['unique_id']) ){
			return false;
		}

		//Create 'Options' Object
		$this->options = (object)array_merge($this->build_options(), $params);

		add_action( 'init', array(&$this, 'custom_meta_setup'));

	}
}

?>