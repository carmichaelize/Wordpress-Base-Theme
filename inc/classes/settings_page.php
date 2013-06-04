<?php

class sc_theme_settings_page {

	public $options;

	public function render_page() { ?>

		<div class='wrap'>
			<?php screen_icon(); ?>
			<h2>Themes Options</h2>

			<form method='post' action='options.php' enctype='multipart/form'>

				<?php settings_fields('sc_theme_options'); //register group name ?>
				<?php do_settings_sections('sc-theme-options'); //page name ?>

				<p class="submit">
					<input type="submit" value="Save Changes" class="button button-primary" id="Update" name="Update">
				</p>

			</form>

		</div>
	
	<?php }

	public function validate_inputs(){
		//validation
	}

	public function add_page(){
		add_options_page('Theme Options', 'Theme Options', 'administrator', 'sc-theme-options', array($this,'render_page'));
	}

	public function register_settings(){
     	
    	register_setting('sc_theme_options', 'sc_theme_options');

    	//General Contact Details
    	add_settings_section('sc_contact_section', 'Contact Details', array($this, 'validate_inputs'), 'sc-theme-options');
    	add_settings_field('name', 'Company Name', array($this, 'name_input'), 'sc-theme-options', 'sc_contact_section');
    	add_settings_field('address', 'Company Address', array($this, 'address_input'), 'sc-theme-options', 'sc_contact_section');
    	add_settings_field('phone', 'Phone Number', array($this, 'phone_input'), 'sc-theme-options', 'sc_contact_section');
    	add_settings_field('email', 'Email Address', array($this, 'email_input'), 'sc-theme-options', 'sc_contact_section');
    	
    	//Social Media Links
    	add_settings_section('sc_social_section', 'Social Media Links', array($this, 'validate_inputs'), 'sc-theme-options');
    	add_settings_field('facebook', 'Facebook URL', array($this, 'facebook_input'), 'sc-theme-options', 'sc_social_section');
    	add_settings_field('twitter', 'Twitter URL', array($this, 'twitter_input'), 'sc-theme-options', 'sc_social_section');
    	add_settings_field('linkedin', 'LinkedIn URL', array($this, 'linkedin_input'), 'sc-theme-options', 'sc_social_section');

    	//Social Media Links
    	add_settings_section('sc_analytics_section', 'Analytics & SEO', array($this, 'validate_inputs'), 'sc-theme-options');
    	add_settings_field('google_analytics_key', 'Google Analytics Key', array($this, 'google_analytics_input'), 'sc-theme-options', 'sc_analytics_section');

	}

	/* Render Inputs */

	public function name_input(){
		echo "<input type='text' class='regular-text' name='sc_theme_options[name]' value='{$this->options->name}' />";
	}

	public function address_input(){
		echo "<textarea style='width:25em;' class='regular-text' name='sc_theme_options[address]'>{$this->options->address}</textarea>";
	}

	public function phone_input(){
		echo "<input class='regular-text' type='text' name='sc_theme_options[phone]' value='{$this->options->phone}' />";
	}

	public function email_input(){
		echo "<input class='regular-text' type='text' name='sc_theme_options[email]' value='{$this->options->email}' />";
	}

	public function facebook_input(){
		echo "<input class='regular-text' type='text' name='sc_theme_options[facebook]' value='{$this->options->facebook}' />";
	}

	public function twitter_input(){
		echo "<input class='regular-text' type='text' name='sc_theme_options[twitter]' value='{$this->options->twitter}' />";
	}

	public function linkedin_input(){
		echo "<input class='regular-text' type='text' name='sc_theme_options[linkedin]' value='{$this->options->linkedin}' />";
	}

	public function google_analytics_input(){
		echo "<input class='regular-text' type='text' name='sc_theme_options[google_analytics_key]' value='{$this->options->google_analytics_key}' />";
	}

	public function __construct(){
		//Get and Set Previously Saved Data
		$this->options = (object)get_option('sc_theme_options');
		
		add_action("admin_menu", array($this, "add_page"));
		add_action('admin_init', array($this, "register_settings"));  
	}
}

?>