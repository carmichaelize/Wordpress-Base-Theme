<?php

class sc_post_type_text_editors {

	public $options = null;

	//Build 'Defaults' Object
	public function build_options(){
		return array(
			'unique_id'  => 'sc_post_type_text_editors', //unique prefix
			'post_types' => array('page'), //post types
			'title'		 => 'Page Content', //title
			'context'	 => 'normal', //normal, advanced, side
			'priority'	 => 'default', //default, core, high, low
			'editors' 	 => array('first_editor' => 'First Editor') //editors (array in input_id => label format)
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

		//Load CSS
        add_action('admin_footer', array(&$this, 'load_css'), 998);
        //Load JS
        add_action('admin_footer', array(&$this, 'load_js'), 999);

		wp_nonce_field( basename( __FILE__ ), $this->options->unique_id.'_nonce' ); 

		$data = get_post_meta($object->ID, $this->options->unique_id, $new_meta_value, true);

		$data = $data[0];
		$count = 0;

		?>

		<?php foreach($this->options->editors as $item => $label) : $count++; ?>

			<div class="editor_container <?php echo $count == 1 ? 'first-editor' : '' ; ?>">

				<p>
					<label for="<?php echo $item; ?>_title"><?php echo $label; ?>:</label>
				</p>

				<p>
					<input id="<?php echo $item; ?>_title" type="text" class="regular-text" name="<?php echo $this->options->unique_id; ?>[<?php echo $item; ?>_title]" value="<?php echo $data[$item.'_title']; ?>" />
				</p>
				
				<textarea class="wp_themeSkin" id="tinymce_<?php echo  $count; ?>" class="mceEditor" name="<?php echo $this->options->unique_id?>[<?php echo $item; ?>_text]"><?php echo $data[$item.'_text']; ?></textarea>

			</div>

		<?php endforeach; ?>

		<br />

		<?php 
	}

	public function load_css(){ ?>

		<style>

			/* Hide/Reset Default Editor */
			.postarea {
				display: none;
			}

			#post-body-content {
				margin-bottom: 0;
			}

			#<?php echo $this->options->unique_id; ?> .editor_container {
				margin-top:20px;
				border-top:1px solid #DFDFDF;
			}

			#<?php echo $this->options->unique_id; ?> label {
				padding:0 0 0 5px;
			}

			#<?php echo $this->options->unique_id; ?> .editor_container.first-editor {
				margin-top:0;
				border-top:none;
			}

			#<?php echo $this->options->unique_id; ?> .defaultSkin > table {
				border: 1px solid #D1D1D1;
				border-radius: 5px;
				overflow: hidden;
			}

			/* Editor Styles */

			#<?php echo $this->options->unique_id; ?> .defaultSkin td.mceToolbar, .defaultSkin .mceStatusbar {
				background: #E5E5E5;
                background: -moz-linear-gradient(top,  #E5E5E5 0%, #F4F4F4 100%);
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#E5E5E5), color-stop(100%,#F4F4F4));
                background: -webkit-linear-gradient(top,  #E5E5E5 0%,#F4F4F4 100%);
                background: -o-linear-gradient(top,  #E5E5E5 0%,#F4F4F4 100%);
                background: -ms-linear-gradient(top,  #E5E5E5 0%,#F4F4F4 100%);
                background: linear-gradient(to bottom,  #E5E5E5 0%,#F4F4F4 100%);
				padding:5px;
				border-top: none;
				border-radius: 5px 5px 0 0;
			}

			#<?php echo $this->options->unique_id; ?> .mceToolbar {
				margin-bottom:0;
			}

			#<?php echo $this->options->unique_id; ?> .defaultSkin .mceIframeContainer{
				border:none;
			}

			#<?php echo $this->options->unique_id; ?> .defaultSkin table.mceLayout tr.mceLast td {
				border-top: 1px solid #D1D1D1;
				border-bottom:none;
				border-radius:0 0 5px 5px;
			}

		</style>

	<?php
	}

	public function load_js(){ 

		$count = 0;

		?>

		<script>
			jQuery(document).ready(function($){
			    //jQuery("#tinymce").addClass("mceEditor");
			    if ( typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function" ) {
			    	tinyMCE.settings = {
				        theme : "advanced",
				        mode : "",
				        language : "en",
				        height:"300",
				        width:"100%",
				        //theme_advanced_layout_manager : "SimpleLayout",
				        theme_advanced_toolbar_location : "top",
				        theme_advanced_toolbar_align : "left",
				        theme_advanced_buttons1 : "bold, italic, underline, strikethrough, blockquote, bullist, numlist, justifyleft, justifycenter, justifyright, link, unlink, code",
				        theme_advanced_buttons2 : "",
				        theme_advanced_buttons3 : "",
					    //content_css : "<?php echo TEMPLATE_PATH; ?>/css/custom_editor_styles.css",
					    setup : function(ed) {
						    ed.onNodeChange.add(function(ed, evt) {
						        //console.log(ed);
						        $('#'+ed.editorContainer).addClass('wp_themeSkin');
						  		//Reset Internal Editor Styles (stupid i know)
						        tinyMCE.activeEditor.dom.setStyle(tinyMCE.activeEditor.dom.select('body#tinymce, body#tinymce pre'), 'font-size', '13px');
						        tinyMCE.activeEditor.dom.setStyle(tinyMCE.activeEditor.dom.select('body#tinymce, body#tinymce pre'), 'font-family', 'Georgia, "Times New Roman", "Bitstream Charter", Times, serif');
						        tinyMCE.activeEditor.dom.setStyle(tinyMCE.activeEditor.dom.select('body#tinymce, body#tinymce pre'), 'line-height', '19px');
						        tinyMCE.activeEditor.dom.setStyle(tinyMCE.activeEditor.dom.select('body#tinymce, body#tinymce pre'), 'color', 'Georgia, "#333');
						    });
						}
					};

			        <?php foreach($this->options->editors as $item => $label) : $count++; ?>
			        	tinyMCE.execCommand("mceAddControl", false, "tinymce_<?php echo $count; ?>");
			        <?php endforeach; ?>

			    }

			});

		</script>

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