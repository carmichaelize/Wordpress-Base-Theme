<?php

/* Page Template Option */
class sc_icon_meta {

	public $options = null;

	//Build 'Defaults' Object
	public function build_options() {
		return array(
			'post_types' => array('post'),
			'unique_id'=>'sc_icon_meta', //unique prefix
			'title'=>'Icon Meta', //title
			'context'=>'side', //normal, advanced, side
			'priority'=>'high', //default, core, high, low
			'show_on'=> false //show only on specified pages
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

		//Load Font Awesome
        wp_register_style( 'font-awesome', TEMPLATE_PATH.'/css/font-awesome.css' );
        wp_enqueue_style( 'font-awesome', TEMPLATE_PATH.'/css/font-awesome.css' );

		//Load CSS
        add_action('admin_footer', array(&$this, 'load_css'), 998);
        //Load JS
        add_action('admin_footer', array(&$this, 'load_js'), 999);

		$icon_list = array(
		             //0 => 'icon-glass',
		             //1 => 'icon-music',
		             2 => 'icon-search',
		             3 => 'icon-envelope',
		             //4 => 'icon-heart',
		             //5 => 'icon-star',
		             //6 => 'icon-star-empty',
		             7 => 'icon-user',
		             //8 => 'icon-film',
		             9 => 'icon-th-large',
		             10 => 'icon-th',
		             11 => 'icon-th-list',
		             12 => 'icon-ok',
		             13 => 'icon-remove',
		             14 => 'icon-zoom-in',
		             15 => 'icon-zoom-out',
		             16 => 'icon-off',
		             17 => 'icon-signal',
		             18 => 'icon-cog',
		             //19 => 'icon-trash',
		             20 => 'icon-home',
		             21 => 'icon-file',
		             //22 => 'icon-time',
		             //23 => 'icon-road',
		             24 => 'icon-download-alt',
		             25 => 'icon-download',
		             26 => 'icon-upload',
		             27 => 'icon-inbox',
		             28 => 'icon-play-circle',
		             29 => 'icon-repeat',
		             30 => 'icon-refresh',
		             31 => 'icon-list-alt',
		             32 => 'icon-lock',
		             //33 => 'icon-flag',
		             //34 => 'icon-headphones',
		             //35 => 'icon-volume-off',
		             //36 => 'icon-volume-down',
		             //37 => 'icon-volume-up',
		             38 => 'icon-qrcode',
		             //39 => 'icon-barcode',
		             40 => 'icon-tag',
		             41 => 'icon-tags',
		             42 => 'icon-book',
		             43 => 'icon-bookmark',
		             44 => 'icon-print',
		             45 => 'icon-camera',
		             //46 => 'icon-font',
		             //47 => 'icon-bold',
		             //48 => 'icon-italic',
		             //49 => 'icon-text-height',
		             //50 => 'icon-text-width',
		             51 => 'icon-align-left',
		             52 => 'icon-align-center',
		             53 => 'icon-align-right',
		             54 => 'icon-align-justify',
		             55 => 'icon-list',
		             //56 => 'icon-indent-left',
		             //57 => 'icon-indent-right',
		             //58 => 'icon-facetime-video',
		             59 => 'icon-picture',
		             60 => 'icon-pencil',
		             61 => 'icon-map-marker',
		             //62 => 'icon-adjust',
		             //63 => 'icon-tint',
		             64 => 'icon-edit',
		             65 => 'icon-share',
		             66 => 'icon-check',
		             //67 => 'icon-move',
		             //68 => 'icon-step-backward',
		             //69 => 'icon-fast-backward',
		             //70 => 'icon-backward',
		             //71 => 'icon-play',
		             //72 => 'icon-pause',
		             //73 => 'icon-stop',
		             //74 => 'icon-forward',
		             //75 => 'icon-fast-forward',
		             //76 => 'icon-step-forward',
		             //77 => 'icon-eject',
		             //78 => 'icon-chevron-left',
		             //79 => 'icon-chevron-right',
		             //80 => 'icon-plus-sign',
		             //81 => 'icon-minus-sign',
		             //82 => 'icon-remove-sign',
		             //83 => 'icon-ok-sign',
		             //84 => 'icon-question-sign',
		             85 => 'icon-info-sign',
		             //86 => 'icon-screenshot',
		             //87 => 'icon-remove-circle',
		             //88 => 'icon-ok-circle',
		             //89 => 'icon-ban-circle',
		             //90 => 'icon-arrow-left',
		             //91 => 'icon-arrow-right',
		             //92 => 'icon-arrow-up',
		             //93 => 'icon-arrow-down',
		             94 => 'icon-share-alt',
		             //95 => 'icon-resize-full',
		             //96 => 'icon-resize-small',
		             97 => 'icon-plus',
		             //98 => 'icon-minus',
		             99 => 'icon-asterisk',
		             100 => 'icon-exclamation-sign',
		             //101 => 'icon-gift',
		             //102 => 'icon-leaf',
		             //103 => 'icon-fire',
		             //104 => 'icon-eye-open',
		             //105 => 'icon-eye-close',
		             106 => 'icon-warning-sign',
		             //107 => 'icon-plane',
		             108 => 'icon-calendar',
		             109 => 'icon-random',
		             110 => 'icon-comment',
		             111 => 'icon-magnet',
		             //112 => 'icon-chevron-up',
		             //113 => 'icon-chevron-down',
		             114 => 'icon-retweet',
		             //115 => 'icon-shopping-cart',
		             116 => 'icon-folder-close',
		             117 => 'icon-folder-open',
		             //118 => 'icon-resize-vertical',
		             //119 => 'icon-resize-horizontal',
		             120 => 'icon-bar-chart',
		             //121 => 'icon-twitter-sign',
		             //122 => 'icon-facebook-sign',
		             //123 => 'icon-camera-retro',
		             //124 => 'icon-key',
		             125 => 'icon-cogs',
		             126 => 'icon-comments',
		             //127 => 'icon-thumbs-up',
		             //128 => 'icon-thumbs-down',
		             //129 => 'icon-star-half',
		             //130 => 'icon-heart-empty',
		             131 => 'icon-signout',
		             //132 => 'icon-linkedin-sign',
		             //133 => 'icon-pushpin',
		             //134 => 'icon-external-link',
		             //135 => 'icon-signin',
		             //136 => 'icon-trophy',
		             //137 => 'icon-github-sign',
		             //138 => 'icon-upload-alt',
		             //139 => 'icon-lemon',
		             140 => 'icon-phone',
		             //141 => 'icon-check-empty',
		             //142 => 'icon-bookmark-empty',
		             //143 => 'icon-phone-sign',
		             //144 => 'icon-twitter',
		             //145 => 'icon-facebook',
		             //146 => 'icon-github',
		             //147 => 'icon-unlock',
		             //148 => 'icon-credit-card',
		             //149 => 'icon-rss',
		             //150 => 'icon-hdd',
		             //151 => 'icon-bullhorn',
		             //152 => 'icon-bell',
		             //153 => 'icon-certificate',
		             //154 => 'icon-hand-right',
		             //155 => 'icon-hand-left',
		             //156 => 'icon-hand-up',
		             //157 => 'icon-hand-down',
		             //158 => 'icon-circle-arrow-left',
		             //159 => 'icon-circle-arrow-right',
		             //160 => 'icon-circle-arrow-up',
		             //161 => 'icon-circle-arrow-down',
		             //162 => 'icon-globe',
		             163 => 'icon-wrench',
		             //164 => 'icon-tasks',
		             //165 => 'icon-filter',
		             //166 => 'icon-briefcase',
		             //167 => 'icon-fullscreen',
		             //168 => 'icon-group',
		             169 => 'icon-link',
		             //170 => 'icon-cloud',
		             //171 => 'icon-beaker',
		             //172 => 'icon-cut',
		             173 => 'icon-copy',
		             174 => 'icon-paper-clip',
		             //175 => 'icon-save',
		             //176 => 'icon-sign-blank',
		             //177 => 'icon-reorder',
		             //178 => 'icon-list-ul',
		             //179 => 'icon-list-ol',
		             //180 => 'icon-strikethrough',
		             //181 => 'icon-underline',
		             //182 => 'icon-table',
		             //183 => 'icon-magic',
		             //184 => 'icon-truck',
		             //185 => 'icon-pinterest',
		             //186 => 'icon-pinterest-sign',
		             //187 => 'icon-google-plus-sign',
		             //188 => 'icon-google-plus',
		             //189 => 'icon-money',
		             //190 => 'icon-caret-down',
		             //191 => 'icon-caret-up',
		             //192 => 'icon-caret-left',
		             //193 => 'icon-caret-right',
		             //194 => 'icon-columns',
		             //195 => 'icon-sort',
		             //196 => 'icon-sort-down',
		             //197 => 'icon-sort-up',
		             198 => 'icon-envelope-alt',
		             //199 => 'icon-linkedin',
		             200 => 'icon-undo',
		             //201 => 'icon-legal',
		             //202 => 'icon-dashboard',
		             //203 => 'icon-comment-alt',
		             //204 => 'icon-comments-alt',
		             //205 => 'icon-bolt',
		             206 => 'icon-sitemap',
		             //207 => 'icon-umbrella',
		             //208 => 'icon-paste',
		             209 => 'icon-lightbulb',
		             //210 => 'icon-exchange',
		             //211 => 'icon-cloud-download',
		             //212 => 'icon-cloud-upload',
		             //213 => 'icon-user-md',
		             //214 => 'icon-stethoscope',
		             //215 => 'icon-suitcase',
		             //216 => 'icon-bell-alt',
		             //217 => 'icon-coffee',
		             //218 => 'icon-food',
		             219 => 'icon-file-alt',
		             //220 => 'icon-building',
		             //221 => 'icon-hospital',
		             //222 => 'icon-ambulance',
		             //223 => 'icon-medkit',
		             //224 => 'icon-fighter-jet',
		             //225 => 'icon-beer',
		             //226 => 'icon-h-sign',
		             //227 => 'icon-plus-sign-alt',
		             //228 => 'icon-double-angle-left',
		             //229 => 'icon-double-angle-right',
		             //230 => 'icon-double-angle-up',
		             //231 => 'icon-double-angle-down',
		             //232 => 'icon-angle-left',
		             //233 => 'icon-angle-right',
		             //234 => 'icon-angle-up',
		             //235 => 'icon-angle-down',
		             236 => 'icon-desktop',
		             237 => 'icon-laptop',
		             238 => 'icon-tablet',
		             239 => 'icon-mobile-phone',
		             //240 => 'icon-circle-blank',
		             241 => 'icon-quote-left',
		             242 => 'icon-quote-right',
		             243 => '\f110 icon-spinner',
		                 244 => 'icon-circle',
		        //   245 => 'icon-reply',
		        //   246 => '\f113 icon-github-alt',
		             247 => 'icon-folder-close-alt',
		             248 => 'icon-folder-open-alt',
		     	);

                wp_nonce_field( basename( __FILE__ ), $this->options->unique_id.'_nonce' ); 

                $data = get_post_meta($object->ID, $this->options->unique_id, $new_meta_value, true);

                $data = $data[0];

                ?>

                <?php //if( $data['icon'] ) : ?>
                        <div id="icon-preview">
                                <i class="<?php echo $data['icon']; ?>"></i>
                        </div>
                <?php //endif; ?>

                <p>
                    <select id="sc_icon_select" class="widefat" name="<?php echo $this->options->unique_id; ?>[icon]">
                            
                        <option value=""> -- Select -- </option>

                        <?php foreach($icon_list as $key => $icon) : ?>

                                <option class="<?php echo $icon; ?>" value="<?php echo $icon; ?>" <?php echo $icon == $data['icon'] ? 'selected' : '' ; ?> ><?php $icon = explode('-', $icon); echo $icon[1]; ?></option>
                        
                        <?php endforeach; ?>

                    </select>
                </p>

                <em>Please view the <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Font Awesome Documentation</a> for further details.</em>

                       
	<?php }

	public function load_js(){ ?>

		<script>

            jQuery(document).ready(function($){

                //Wrap Text in Span (Not Web Standard!)
                $('#sc_icon_select option').each(function(){
                        $(this).html('<span> - '+$(this).text()+'</span>');
                });

                //Display Icon On Select
                $('#sc_icon_select').on('change', function(){
                        $('#icon-preview i').removeClass().addClass($(this).val());
                });

            });

        </script>

	<?php }

	public function load_css(){ ?>

		<style>

            #icon-preview {
                    text-align:center; 
                    /*padding:10px 0;*/
                    font-size:70px;
            }

            #sc_icon_select option {
                    display: block;
                    font-size: 18px;
                    color:#333333;
            }

            #sc_icon_select option span {
                    font-family: sans-serif;
                    font-size: 13px;
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

		//Create 'Options' Object
		$this->options = (object)array_merge($this->build_options(), $params);

		add_action( 'init', array(&$this, 'custom_meta_setup'));

	}
	
}


?>