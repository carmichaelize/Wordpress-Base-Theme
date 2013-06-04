<?php

/* Page Template Option */
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

?>