<?php

/* Page Template Option */
class sc_post_gallery {

        public $options = null;

        //Build 'Defaults' Object
        public function build_options() {
            return array(
                'unique_id'   => 'sc_page_slider_images', //unique prefix
                'single'      => false, //set more than one image
                'post_types'  => array('post', 'page'), //post types
                'title'       => 'Image(s)', //title
                'context'     => 'normal', //normal, advanced, side
                'priority'    => 'default', //default, core, high, low
                'description' => '', //description text to appear in meta box
                'show_on'     => false //show only on specified pages (array of post ids)
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
                    $this->options->description ? $this->options->title.' <span class="title-caption">'.$this->options->description.'</span>' : $this->options->title, //Title
                    $this->options->single ? array(&$this, 'single_custom_meta_render') : array(&$this, 'multiple_custom_meta_render'), // Callback (builds html)
                    $post_type, // Admin page (or post type)
                    $this->options->single ? 'side' : 'normal' , // Context
                    $this->options->priority, // Priority
                    $callback_args = null
                );
            }

        }

        public function single_custom_meta_render($object, $box){

            wp_nonce_field( basename( __FILE__ ), $this->options->unique_id.'_nonce' );

            global $post;

            $image_src = '';

            //$image = get_post_meta( $post->ID, $this->options->unique_id, true );
            $image = is_array($image = get_post_meta( $post->ID, $this->options->unique_id, true )) ? $image[0] : $image ;

            //var_dump($image);

            //Load CSS
            add_action('admin_footer', array(&$this, 'load_single_css'), 998);
            //Load JS
            add_action('admin_footer', array(&$this, 'load_single_js'), 999);

            ?>

            <span class="add_new_slide button button-primary button-large sc-set-image" <?php echo isset($image) && wp_get_attachment_url($image) ? 'style="display:none;"' : '' ; ?>>Add New Image</span>

            <?php if( isset($image) && wp_get_attachment_url( $image ) ): ?>

                <div class="sc_gallery_item">
                    <div class="image-mask" style="background-image:url('<?php echo wp_get_attachment_url( $image ) ?>');"></div>
                    <input type="hidden" name="<?php echo $this->options->unique_id; ?>" class="upload_image_id" value="<?php echo $image; ?>" />
                    <p>
                        <a title="Set Slider Image" href="#" class="sc-set-image">Set Image</a>
                        <a title="Remove Slider Image" href="#" class="remove-image">Remove Image</a>
                    </p>
                </div>

            <?php endif; ?>

            <!-- template -->
            <script id="sc_gallery_image_single" type="text/template">
                <div class="sc_gallery_item">
                    <div class="image-mask"></div>
                    <input type="hidden" name="<?php echo $this->options->unique_id; ?>" class="upload_image_id" value="" />
                    <p>
                        <a title="Set Slider Image" href="#" class="sc-set-image">Set Image</a>
                        <a title="Remove Slider Image" href="#" class="remove-image">Remove Image</a>
                    </p>
                </div>
            </script>
            <!-- /template -->

        <?php }


        public function load_single_js(){ ?>

            <script type="text/javascript">

                (function(){

                    jQuery(document).ready(function($){

                        function sc_wp_gallery_images(unique_id){

                            function init(){

                                //Meta Containers
                                this.file_frame = null;
                                this.currentItem = null,
                                this.itemContainer = $('#'+unique_id).find('.inside');

                                this.actions();
                            }

                            init.prototype.setImage = function(event){

                                //If the media frame already exists, reopen it.
                                if(self.file_frame){
                                    console.log('Has Been Created');
                                    self.file_frame.open();
                                    return false;
                                }

                                // Create the media frame.
                                self.file_frame = wp.media.frames.file_frame = wp.media({
                                    title: $(this).data( 'uploader_title' ),
                                    button: {
                                         text: $(this).data( 'uploader_button_text' ),
                                    },
                                    multiple: false // Set to true to allow multiple files to be selected
                                });

                                // When an image is selected, run a callback.
                                self.file_frame.on( 'select', function() {
                                // We set multiple to false so only get one image from the uploader
                                    attachment = self.file_frame.state().get('selection').first().toJSON();

                                    //self.currentItem = $(this).closest('div');
                                    //window.send_to_editor = self.attach_image;

                                    var container = self.itemContainer;
                                    self.currentItem = $(container.find('#sc_gallery_image_single').html());

                                    // newImage.find('input.upload_image_id').attr({
                                    //     'name': attachment.url.id
                                    // });
                                    //console.log(newImage);
                                   //self.currentItem = newImage;

                                   //self.currentItem.html(attachment.url);
                                   self.currentItem.find('.image-mask').attr('style','background-image: url("'+attachment.url+'");');
                                   self.currentItem.find('.upload_image_id').attr({'value': attachment.id});

                                   //self.currentItem.find('.upload_image_id').val(attachment.url.id);
                                   //self.currentItem.find('.remove-image').show();
                                   //file_frame.close();
                                   //console.log(self.currentItem);

                                   container.find('.sc_gallery_item').remove();
                                   container.find('.button').before(self.currentItem);

                                   //Hide Add Image Button
                                   container.find('.button').hide();
                                   //container.html(self.currentItem);

                                });

                                // Finally, open the modal
                                self.file_frame.open();

                                return false;
                            }

                            init.prototype.actions = function(){

                                //Add / Change Image After DOM Creation
                                this.itemContainer.on('click', '.sc-set-image', function(event){
                                    event.preventDefault();
                                    self.setImage(event);
                                });

                                //Remove Image From Container/DOM
                                this.itemContainer.on('click', '.remove-image', function(){
                                    var container = $(this).closest('div');
                                    container.fadeOut(600, function(){
                                        container.remove();
                                        self.itemContainer.find('.add_new_slide.button').show();
                                    });
                                    return false;
                                });

                            }

                            var self = new init();
                            return self;

                        }

                        new sc_wp_gallery_images('<?php echo $this->options->unique_id; ?>', '<?php echo $post->ID ?>');

                    });
                }());
            </script>

        <?php }

        public function load_single_css(){

            //Set Parent Container Name.
            $container = $this->options->unique_id;

            ?>

            <style>

                #temp_image {
                    display: none;
                }

                #<?php echo $container; ?> .title-caption {
                    color:#888;
                    font-size: 12px;
                    font-style: italic;
                    font-family: sans-serif;
                }

                #<?php echo $container; ?> .inside span.add_new_slide {
                    position: relative;
                    margin:10px auto;
                    width:120px;
                    display: block;
                }

                #<?php echo $container; ?> div.sc_gallery_item {
                    text-align: center;
                    margin:3%;
                }

                #<?php echo $container; ?> div.sc_gallery_item .image-mask{
                    width:99%;
                    height:166px;
                    overflow: hidden;
                    border-radius: 3px;
                    border:1px solid #ccc;
                    background-position: center center;
                    background-size: cover;
                }

            </style>

        <?php }

        public function multiple_custom_meta_render($object, $box){

            wp_nonce_field( basename( __FILE__ ), $this->options->unique_id.'_nonce' );

            global $post;

            $image_src = '';

            $images = get_post_meta( $post->ID, $this->options->unique_id, true );

            //Load CSS
            add_action('admin_footer', array(&$this, 'load_multiple_css'), 998);
            //Load JS
            add_action('admin_footer', array(&$this, 'load_multiple_js'), 999);

        ?>

        <span class="add_new_slide button button-primary button-large sc-add-image">Add New Image</span>

        <div class="clear"></div>

        <ul class="sc_gallery_container">
            <?php if(isset($images) && is_array($images) ): ?>

                <?php foreach($images as $image): ?>

                    <?php if( $image && wp_get_attachment_url( $image ) ) : ?>

                        <li class="sc_gallery_item">
                            <div class="image-mask" style="background-image:url('<?php echo wp_get_attachment_url( $image ) ?>');"></div>
                            <input type="hidden" name="<?php echo $this->options->unique_id; ?>[]" class="upload_image_id" value="<?php echo $image; ?>" />
                            <p>
                                <a title="Set Slider Image" href="#" class="sc-set-image">Set Image</a>
                                <a title="Remove Slider Image" href="#" class="remove-image">Remove Image</a>
                            </p>
                        </li>

                    <?php endif; ?>

                <?php endforeach; ?>

            <?php endif; ?>

            <li class="clear"></li>

        </ul>

        <!-- template -->
            <script id="sc_gallery_image_single" type="text/template">
                <li class="sc_gallery_item">
                    <div class="image-mask"></div>
                    <input type="hidden" name="<?php echo $this->options->unique_id; ?>[]" class="upload_image_id" value="" />
                    <p>
                        <a title="Set Slider Image" href="#" class="sc-set-image">Set Image</a>
                        <a title="Remove Slider Image" href="#" class="remove-image">Remove Image</a>
                    </p>
                </li>
            </script>
        <!-- /template -->

        <?php }

        public function load_multiple_js(){ ?>

            <script>

                (function(){

                    jQuery(document).ready(function($){

                        function sc_wp_gallery_images(unique_id){

                            function init(){

                                //Meta Containers
                                this.file_frame = null;
                                this.currentItem = null,
                                this.itemContainer = $('#'+unique_id).find('.inside');

                                this.actions();
                            }

                            init.prototype.setImage = function(event, append, item){

                                event.preventDefault();

                                var container = self.itemContainer;

                                //Get Gallery Item
                                if(append == false){
                                    self.currentItem = item;
                                } else {
                                    self.currentItem = $(container.find('#sc_gallery_image_single').html());
                                }

                                //Open Uploader If It Already Exsists.
                                if(self.file_frame){
                                    self.file_frame.open();
                                    return false;
                                }

                                //Create the media frame.
                                self.file_frame = wp.media.frames.file_frame = wp.media({
                                    title: $(this).data( 'uploader_title' ),
                                    button: {
                                         text: $(this).data( 'uploader_button_text' ),
                                    },
                                    multiple: false // Set to true to allow multiple files to be selected
                                });

                                //Add / Update Image on Selection
                                self.file_frame.on( 'select', function() {

                                   attachment = self.file_frame.state().get('selection').first().toJSON();
                                   //Update Imge SRC and Input Value
                                   self.currentItem.find('.image-mask').attr('style','background-image: url("'+attachment.url+'");');
                                   self.currentItem.find('.upload_image_id').attr({'value': attachment.id});

                                   container.find('.sc_gallery_container').find('li.clear').before(self.currentItem);

                                   return false;

                                });

                                //Open Media Uploader
                                self.file_frame.open();

                                return false;
                            }

                            init.prototype.actions = function(){

                                //Add New Image
                                this.itemContainer.on('click', '.sc-add-image', function(event){
                                    self.setImage(event, true);
                                });

                                //Change Image
                                this.itemContainer.on('click', '.sc-set-image', function(event){
                                    var item = $(this).parents('.sc_gallery_item');
                                    self.setImage(event, false, item);
                                });

                                //Remove Image From Container/DOM
                                this.itemContainer.on('click', '.remove-image', function(){
                                    var container = $(this).parents('.sc_gallery_item');
                                    container.fadeOut(600, function(){
                                        container.remove();
                                    });
                                    return false;
                                });

                                //jQuery Sortable / Change Gallery Order
                                this.itemContainer.find('.sc_gallery_container').sortable({
                                    appendTo: document.body,
                                    // start: function( event, ui ) {
                                    //     $('.sc_gallery_container li.clear').hide();
                                    // },
                                    // out: function( event, ui ) {
                                    //     $('.sc_gallery_container li.clear').show();
                                    // }

                                });

                            }

                            var self = new init();
                            return self;

                        }

                        new sc_wp_gallery_images('<?php echo $this->options->unique_id; ?>', '<?php echo $post->ID ?>');

                    });
                }());
            </script>

        <?php }

        public function load_multiple_css(){

            //Set Parent Container Name.
            $container = $this->options->unique_id;

        ?>

            <style>

/*                #post-body-content {
                    display:none;
                }*/

                #<?php echo $container; ?> .title-caption {
                    color:#888;
                    font-size: 12px;
                    font-style: italic;
                    font-family: sans-serif;
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

                ul.sc_gallery_container {

                }
                ul.sc_gallery_container li.sc_gallery_item {
                    text-align: center;
                    float:left;
                    width:15%;
                    max-width: 160px;
                    height:200px;
                    margin:0 1.4% 2.8% 1.4%;
                    padding:1%;
                    border-radius: 3px;
                    cursor:move;
                    border:1px solid #ccc;
                    background: #ffffff;
                    background: -moz-linear-gradient(top,  #ffffff 0%, #dfdfdf 100%);
                    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#dfdfdf));
                    background: -webkit-linear-gradient(top,  #ffffff 0%,#dfdfdf 100%);
                    background: -o-linear-gradient(top,  #ffffff 0%,#dfdfdf 100%);
                    background: -ms-linear-gradient(top,  #ffffff 0%,#dfdfdf 100%);
                    background: linear-gradient(to bottom,  #ffffff 0%,#dfdfdf 100%);
                    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#dfdfdf',GradientType=0 ); /* IE6-9 */
                }
                ul.sc_gallery_container li.clear {
                    clear:both;
                    display: block;
                    float: none;
                }
                ul.sc_gallery_container li .image-mask{
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


                //var_dump($_POST[$this->options->unique_id]);
                //exit;

                //Show Only On Specific Pages
                // if( $this->options->show_on && !in_array(get_the_id(), $this->options->show_on) ){
                //     return false;
                // }

                /* Verify the nonce before proceeding. */
                if ( !isset( $_POST[$this->options->unique_id.'_nonce'] ) || !wp_verify_nonce( $_POST[$this->options->unique_id.'_nonce'], basename( __FILE__ ) ) ){
                    return $post_id;
                }

                /* Get the post type object. */
                //$post_type = get_post_type_object( $post->post_type );

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