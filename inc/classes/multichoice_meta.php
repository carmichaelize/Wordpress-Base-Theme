<?php

/* Page Template Option */
class sc_multichoice_meta {

	public $options = null;

	//Build 'Defaults' Object
	public function build_options() {
		return array(
			'unique_id'				=> 'sc_multichoice_meta', //unique prefix
			'post_types' 			=> array('post'), //post types to appear
			'post_types_to_display' => array('post'), //post types to list
			'title'					=> 'Related Content', //title
			'context'				=> 'side', //normal, advanced, side
			'priority'				=> 'default', //default, core, high, low
			'description'			=> 'Choose the items to be included.', //description text to appear in meta box
			'show_on'				=> false //show only on specified pages (array of post ids)
		);
	}

	public function custom_meta_add() {

		//Show Only On Specific Pages
		if( $this->options->show_on && !in_array(get_the_id(), $this->options->show_on) ){
			return false;
		}

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

		//Load CSS
        add_action('admin_footer', array(&$this, 'load_css'), 998);
        //Load JS
        add_action('admin_footer', array(&$this, 'load_js'), 999);

		wp_nonce_field( basename( __FILE__ ), $this->options->unique_id.'_nonce' ); 

		//Get Preset Data
		$list = is_array( $list = get_post_meta($object->ID, $this->options->unique_id, true) ) ? $list : array() ;

		//Get Posts
		$args = array(
			'post_type' => $this->options->post_types_to_display,
			'order' => 'ASC',
			'orderby' => 'title',
			'posts_per_page'=>-1
			);
		$post_query = new WP_Query( $args );
		$posts = $post_query->posts;

	?>		

		<p><em><?php echo $this->options->description; ?></em></p>

		<select class="widefat" id="<?php echo $this->options->unique_id; ?>_select">

			<option value="">-- Select --</option>

			<?php if($posts) : ?>

				<?php foreach($posts as $post): ?>

					<option <?php echo in_array($post->ID, $list) ? 'style="display:none;"' : '' ; ?> value="<?php echo $post->ID ?>"><?php echo $post->post_title; ?></option>

				<?php endforeach; ?>

			<?php endif; ?>

		</select>

		<!-- Output List -->
		<ul id="<?php echo $this->options->unique_id; ?>_container">

			<li class="button temp">
				<input type="hidden" name="" value="" />
				<span class="remove"></span>
			</li>

			<?php if($list) : ?>

				<?php foreach($list as $item): ?>

					<?php foreach($posts as $post): ?>

						<?php if($post->ID == $item) : ?>

							<li class="button">
								<?php echo $post->post_title; ?>
								<input type="hidden" name="<?php echo $this->options->unique_id; ?>[]" value="<?php echo $post->ID; ?>" />
								<span class="remove"></span>
							</li>

						<?php break; endif; ?>

					<?php endforeach; ?>
				
				<?php endforeach; ?>

			<?php endif; ?>

		</ul>

	<?php }

	public function load_js(){ ?>

		<script>

			jQuery(document).ready(function($){

				var select_box = $('#<?php echo $this->options->unique_id ?>_select'),
					selection_list = $('#<?php echo $this->options->unique_id ?>_container');

				//Add Item
				select_box.on('change', function(){

					var value = $(this).val(),
						label = $(this).children('option[value='+value+']').text();

					if(value){
						
						//Prepare and Add New Item to List
						var new_item = selection_list.children('.button.temp').clone();
						new_item.removeClass('temp').prepend(label).children('input').attr({
							name : '<?php echo $this->options->unique_id ?>[]',
							value : value
						});
						selection_list.append(new_item);

						//Hide Selected Option
						select_box.children('option[value='+value+']').hide();

						//Reset Select Box
						select_box.children('option:first-child').attr('selected', true);

					}

				});

				//Remove Item
				selection_list.on('click', 'span.remove', function(){
					
					//Fade Out and Remove Item From List
					$(this).parent('li').fadeOut(300, function(){
						$(this).remove();
					});
					
					//Readd Option to Select Box
					select_box.children('option[value='+$(this).siblings('input').val()+']').show();
				});

				//jQuery Sortable / Change Item Order
                selection_list.sortable({ appendTo: document.body });

			});

		</script>


	<?php }

	public function load_css(){ ?>

		<style>

			ul#<?php echo $this->options->unique_id ?>_container {
				border-top:1px solid #DFDFDF;
				padding-top:12px;
			}

			#<?php echo $this->options->unique_id ?>_container .button{
				display: block;
				margin-bottom: 4px;
				position: relative;
				cursor: move;
				background: linear-gradient(to top, #ECECEC, #F9F9F9) repeat scroll 0 0 #F1F1F1;		
			}

			#<?php echo $this->options->unique_id ?>_container .button span.remove{
				position: absolute;
				top:0;
				right:0;
				background: transparent url('/wp-admin/images/xit.gif') center left no-repeat;
				width:10px;
				height: 100%;
				right:8px;
				display: inline-block;
				cursor: pointer;
			}

			#<?php echo $this->options->unique_id ?>_container li.temp {
				display: none;
			}

		</style>


	<?php }

	public function custom_meta_save($post_id, $post=false){

		//Show Only On Specific Pages
		if( $this->options->show_on && !in_array(get_the_id(), $this->options->show_on) ){
			return false;
		}

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
		//Save Box
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