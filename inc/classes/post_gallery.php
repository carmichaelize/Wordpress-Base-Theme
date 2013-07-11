<?php

/* Page Template Option */
class sc_page_slider_images {

        public $options = null;

        //Build 'Defaults' Object
        public function build_options() {
            return array(
                'unique_id'=>'sc_page_slider_images', //unique prefix
                'post_types' => array('post', 'page'), //post types
                'title'=>'Slider Images', //title
                'context'=>'normal', //normal, advanced, side
                'priority'=>'high', //default, core, high, low
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

            global $post;

            $image_src = '';

            $images = get_post_meta( $post->ID, $this->options->unique_id, true );

            //$image_src = wp_get_attachment_url( $image_id );

            //var_dump($images);

            //Load CSS
            add_action('admin_footer', array(&$this, 'load_css'), 998);
            //Load JS
            add_action('admin_footer', array(&$this, 'load_js'), 999);

        ?>

        <span class="add_new_slide button button-primary button-large">Add New Slide</span>

        <div class="clear"></div>

        <ul class="<?php echo $this->options->unique_id; ?>_container"> 
        <?php if(isset($images) && is_array($images) ): ?>

                <?php foreach($images as $image): ?>

                    <?php if( $image && wp_get_attachment_url( $image ) ) : ?>

                        <li class="sc_gallery_item">
                            <div class="image-mask" style="background-image:url('<?php echo wp_get_attachment_url( $image ) ?>');"></div>
                            <input type="hidden" name="<?php echo $this->options->unique_id; ?>[]" class="upload_image_id" value="<?php echo $image; ?>" />
                            <p>
                                <a title="Set Slider Image" href="#" class="set-image">Set Image</a>
                                <a title="Remove Slider Image" href="#" class="remove-image">Remove Image</a>
                            </p>
                        </li>

                    <?php endif; ?>

                <?php endforeach; ?>

                <li class="clear"></li>

        <?php endif; ?>

        </ul>

        <!-- template -->
        <li class="new_image" style="display:none;">
            <div class="image-mask"></div>
            <input type="hidden" name="" class="upload_image_id" value="" />
            <p>
                <a title="Set Slider Image" href="#" class="set-image">Set Image</a>
                <a title="Remove Slider Image" href="#" class="remove-image" style="display:none;">Remove Image</a>
            </p>
        </li>
        <!-- /template -->

        <?php }

        public function load_js(){ ?>

            <script type="text/javascript">

                (function(){

                    jQuery(document).ready(function($){

                        function sc_wp_gallery_images(unique_id, post_id){

                            function init(){

                                //save the send_to_editor handler function
                                window.send_to_editor_default = window.send_to_editor;

                                //Meta Containers
                                this.currentItem = null,
                                this.itemContainer = $('ul.'+unique_id+'_container');

                                this.actions();
                            }

                            init.prototype.actions = function(){

                                // handler function which is invoked after the user selects an image from the gallery popup.
                                // this function displays the image and sets the id so it can be persisted to the post meta
                                this.attach_image = function(html) {
                                            
                                    // store returned image html into a hidden image element
                                    if( $('#temp_image').length > 0 ){
                                        $('#temp_image').html(html);
                                    } else {
                                        $('body').append('<div id="temp_image">' + html + '</div>');
                                    }

                                    currentItem = self.currentItem;

                                    var img = $('#temp_image').find('img');
                                    
                                    imgurl   = img.attr('src');
                                    imgclass = img.attr('class');
                                    imgid    = parseInt(imgclass.replace(/\D/g, ''), 10);
                                    
                                    currentItem.find('.upload_image_id').val(imgid);
                                    currentItem.find('.remove-image').show();

                                    //currentItem.find('img').attr('src', imgurl);
                                    currentItem.find('.image-mask').attr('style','background-image: url("'+imgurl+'");'); 
                                    try{tb_remove();}catch(e){};
                                    currentItem.find('#temp_image').remove();
                                    
                                    // restore the send_to_editor handler function
                                    window.send_to_editor = window.send_to_editor_default;

                                }

                                //Set/Change Image After DOM Creation
                                this.itemContainer.on('click', '.set-image', function(){
                                    self.currentItem = $(this).closest('li');
                                    // replace the default send_to_editor handler function with our own
                                    window.send_to_editor = self.attach_image;
                                    tb_show('', 'media-upload.php?post_id=<?php echo $post->ID ?>&amp;type=image&amp;TB_iframe=true');
                                    return false;
                                });

                                //Remove Image From Container/DOM
                                this.itemContainer.on('click', '.remove-image', function(){
                                    var container = $(this).closest('li');
                                    container.fadeOut(600, function(){
                                        container.remove();
                                    });
                                    return false;
                                });                                

                                //Add New Image
                                this.itemContainer.siblings('.button.add_new_slide').on('click', function(){

                                    var imageList = self.itemContainer.children('li.sc_gallery_item'),
                                        previousSet = true;

                                    //Check No Empty Container Are Listed
                                    imageList.each(function(){
                                        if( !$(this).children('.image-mask').attr('style') ){
                                            previousSet = false;
                                        }
                                    });

                                    if( imageList.length == 0 || previousSet ){
                                        
                                        var container = self.itemContainer,
                                            newImage = container.parent().find('li.new_image').clone();
                                        
                                        newImage.find('input.upload_image_id').attr({
                                            'name': unique_id + '[]'
                                        });

                                        self.currentItem = newImage;

                                        container.children('li.clear').remove();
                                        container.append(newImage.show().attr('class', 'sc_gallery_item')).append('<li class="clear"></li>');

                                        // replace the default send_to_editor handler function with our own
                                        window.send_to_editor = self.attach_image;
                                        tb_show('', 'media-upload.php?post_id=' + post_id + '&amp;type=image&amp;TB_iframe=true');
                                        return false;

                                    } else {
                                        alert('Please Select An Image');
                                    }

                                });

                                //jQuery Sortable / Change Image Order
                                this.itemContainer.sortable({appendTo: document.body});

                            }

                            var self = new init();
                            return self;

                        }

                        new sc_wp_gallery_images('<?php echo $this->options->unique_id; ?>', '<?php echo $post->ID ?>');

                    });
                }());
            </script>

        <?php }

        public function load_css(){

            //Set Parent Container Name.
            $container = $this->options->unique_id;

        ?>

            <style>

                #post-body-content {
                    display:none;
                }

                #temp_image {
                    display: none;
                }

                #<?php echo $container; ?> .inside {
                    margin:10px 0;
                    padding:0;
                }

                #<?php echo $container; ?> .inside span.add_new_slide {
                    margin:0 0 0 10px;
                }

                ul.<?php echo $container; ?>_container {

                }
                ul.<?php echo $container; ?>_container li.sc_gallery_item {
                    text-align: center;
                    float:left;
                    width:15%;
                    max-width: 160px;
                    height:200px;
                    margin:0 1.4% 2.8% 1.4%;
                    background: #DFDFDF;
                    padding:1%;
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
                ul.<?php echo $container; ?>_container li.clear {
                    clear:both;
                    display: block;
                    float: none;
                }
                ul.<?php echo $container; ?>_container li .image-mask{
                    width:99%;
                    height:140px;
                    overflow: hidden;
                    border-radius: 3px;
                    border:1px solid #ccc;
                    background-position: center center;
                    background-size: cover;
                }

                /* Responsive Styling */
                @media only screen and (max-width: 1460px) {
                    ul.<?php echo $container; ?>_container li.sc_gallery_item {
                        width:20%;
                        margin:0 1.3% 2.8%;
                    }
                }

                @media only screen and (max-width: 1260px) {
                    ul.<?php echo $container; ?>_container li.sc_gallery_item {
                        width:32%;
                        margin:0 1.3% 2.8%;
                    }
                }

                @media only screen and (max-width: 1024px) {
                    ul.<?php echo $container; ?>_container li.sc_gallery_item {
                        width:44%;
                        max-width: 100%;
                        margin:0 1.3% 2.8%;
                    }
                }

                @media only screen and (max-width: 860px) {
                    ul.<?php echo $container; ?>_container li.sc_gallery_item {
                        width:32%;
                        margin:0 1.3% 2.8%;
                        max-width: 200px;
                    }
                }

                @media only screen and (max-width: 768px) {

                }

            </style>

        <?php }

        public function custom_meta_save($post_id, $post=false){

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