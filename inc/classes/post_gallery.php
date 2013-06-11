<?php

/* Page Template Option */
class sc_page_slider_images {

        public $options = null;

        //Build 'Defaults' Object
        public function build_options() {
                return (object)array(
                        'unique_id'=>'sc_page_slider_images', //unique prefix
                        'title'=>'Slider Images', //title
                        'context'=>'normal', //normal, advanced, side
                        'priority'=>'high' //default, core, high, low
                );
        }

        public function page_template_add() {

                $types = array('post');

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

                global $post;

                $image_src = '';

                $images = get_post_meta( $post->ID, $this->options->unique_id, true );

                //$image_src = wp_get_attachment_url( $image_id );

                var_dump($images);

        ?>

        <style>
            #temp_image {
                display: none;
            }
            ul.<?php echo $this->options->unique_id; ?>_container{

            }
            ul.<?php echo $this->options->unique_id; ?>_container li.<?php echo $this->options->unique_id; ?>_item {
                text-align: center;
                float:left;
                width:200px;
                width:20%;
                height:200px;
                margin-right:15px;
                margin-bottom:15px;
                margin:0 1.7% 1.7% 1.7%;
                background: #DFDFDF;
                padding:5px;
                border-radius: 3px;
                cursor:move;
                border:1px solid #ccc;
                background: #ffffff; /* Old browsers */
                background: -moz-linear-gradient(top,  #ffffff 0%, #dfdfdf 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#dfdfdf)); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top,  #ffffff 0%,#dfdfdf 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top,  #ffffff 0%,#dfdfdf 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top,  #ffffff 0%,#dfdfdf 100%); /* IE10+ */
                background: linear-gradient(to bottom,  #ffffff 0%,#dfdfdf 100%); /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#dfdfdf',GradientType=0 ); /* IE6-9 */
            }
            ul.<?php echo $this->options->unique_id; ?>_container li img{
                max-width: 100%
            }

            ul.<?php echo $this->options->unique_id; ?>_container li.clear {
                clear:both;
                display: block;
                float: none;
            }
        </style>

        <span class="add_new_slide button button-primary button-large">Add New Slide</span>

        <ul class="<?php echo $this->options->unique_id; ?>_container"> 
        <?php if(isset($images) && is_array($images) ): ?>

                <?php foreach($images as $image): ?>

                    <?php if($image): ?>

                        <li class="<?php echo $this->options->unique_id; ?>_item">
                        
                            <!-- <div class="<?php echo $this->options->unique_id; ?>_item"> -->
                                <img id="book_image" src="<?php echo wp_get_attachment_url( $image ) ?>" />
                                <input type="hidden" name="<?php echo $this->options->unique_id; ?>[]" class="upload_image_id" value="<?php echo $image; ?>" />
                                <p>
                                    <a title="Set Slider Image" href="#" class="set-book-image">Set Slider Image</a>
                                    <a title="Remove Slider Image" href="#" class="remove-book-image" style="<?php echo ( ! $image ? 'display:none;' : '' ); ?>">Remove Slider Image</a>
                                </p>
                            <!-- </div> -->

                        </li>

                    <?php endif; ?>

                <?php endforeach; ?>

                <li class="clear"></li>

        <?php endif; ?>

        </ul>

        <li class="new_image" style="display:none;">

            <img id="book_image" src="" />
            <input type="hidden" name="" class="upload_image_id" value="" />
            <p>
                <a title="Set Slider Image" href="#" class="set-book-image">Set Slider Image</a>
                <a title="Remove Slider Image" href="#" class="remove-book-image" style="display:none;">Remove Slider Image</a>
            </p>

        </li>
                
                <script type="text/javascript">
                jQuery(document).ready(function($) {
                        
                        // save the send_to_editor handler function
                        window.send_to_editor_default = window.send_to_editor;

                        //Image Container being created/updated.
                        var currentItem = null,
                            itemContainer = $('.<?php echo $this->options->unique_id; ?>_container');

                        $('ul.<?php echo $this->options->unique_id; ?>_container').on('click', '.set-book-image', function(){
                            currentItem = $(this).closest('li.<?php echo $this->options->unique_id; ?>_item');
                            // replace the default send_to_editor handler function with our own
                            window.send_to_editor = window.attach_image;
                            tb_show('', 'media-upload.php?post_id=<?php echo $post->ID ?>&amp;type=image&amp;TB_iframe=true');
                            return false;
                        });

                        $('ul.<?php echo $this->options->unique_id; ?>_container').on('click', '.remove-book-image', function(){
                            var container = $(this).closest('li.<?php echo $this->options->unique_id; ?>_item');
                            //container.find('.upload_image_id').val('');
                            //container.find('img').attr('src', '');
                            container.fadeOut(600, function(){
                                container.remove();
                            });
                            return false;
                        });
                        
                        // handler function which is invoked after the user selects an image from the gallery popup.
                        // this function displays the image and sets the id so it can be persisted to the post meta
                        window.attach_image = function(html) {

                            //console.log(html);
                            console.log(currentItem);
                                
                            // turn the returned image html into a hidden image element so we can easily pull the relevant attributes we need
                            $('body').append('<div id="temp_image">' + html + '</div>');
                                    
                            var img = $('#temp_image').find('img');
                            
                            imgurl   = img.attr('src');
                            imgclass = img.attr('class');
                            imgid    = parseInt(imgclass.replace(/\D/g, ''), 10);
    
                            currentItem.find('.upload_image_id').val(imgid);
                            currentItem.find('.remove-book-image').show();
    
                            currentItem.find('img#book_image').attr('src', imgurl);
                            try{tb_remove();}catch(e){};
                            currentItem.find('#temp_image').remove();
                            
                            // restore the send_to_editor handler function
                            window.send_to_editor = window.send_to_editor_default;
                                
                        }

                        //Add New Image
                        //$('.add_new_slide').on('click', function(){
                        $('div#<?php echo $this->options->unique_id; ?>').on('click', '.add_new_slide', function(){

                            console.log($('.<?php echo $this->options->unique_id; ?>_container').children('li').eq(-2).find('input.upload_image_id').val());

                            //.find('input.upload_image_id').val());
                            //if( itemContainer.eq(-1).find('input').val() ){
                                var new_image = $('li.new_image').clone();
                                new_image.find('input.upload_image_id').attr({
                                    'name': '<?php echo $this->options->unique_id; ?>[]'
                                });
                                itemContainer.children('li.clear').remove();
                                itemContainer.append(new_image.show().attr('class', '<?php echo $this->options->unique_id; ?>_item')).append('<li class="clear"></li>');
                            //}   
                        });

                        //jQuery Sortable / Change Image Order
                        $("ul.<?php echo $this->options->unique_id; ?>_container" ).sortable({ appendTo: document.body });
        
                });
                </script>

        <?php }

        public function page_template_save($post_id, $post=false){

                /* Verify the nonce before proceeding. */
                if ( !isset( $_POST[$this->options->unique_id.'_nonce'] ) || !wp_verify_nonce( $_POST[$this->options->unique_id.'_nonce'], basename( __FILE__ ) ) ){
                        return $post_id;
                }
                        
                /* Get the post type object. */
                $post_type = get_post_type_object( $post->post_type );

                /* Check if the current user has permission to edit the post. */
                // if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ){
                //      return $post_id;
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

        /**
         * Function for processing and storing all book data.
         */
        private function process_book_meta( $post_id, $post ) {
                update_post_meta( $post_id, '_image_id', $_POST['upload_image_id'] );
        }
        
        
        /**
         * Set a more appropriate placeholder text for the New Book title field
         */
        public function enter_title_here( $text, $post ) {
                if ( $post->post_type == 'book' ) return __( 'Book Title' );
                return $text;
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