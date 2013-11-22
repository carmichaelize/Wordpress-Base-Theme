<?php

$validation_message = "";

if( isset($_POST['submit']) ){

	$passes = true;

	// Verify nonce before proceeding
	if( !isset( $_POST['sc_contact_form_nonce'] ) || !wp_verify_nonce( $_POST['sc_contact_form_nonce'], basename( __FILE__ ) ) ){
		$validation_message = "<span class='error'><i class='icon-remove-sign'></i> Security Fail !!!!</span>";
		$passes = false;
	}

	if( !$_POST['form_name'] || !$_POST['form_email'] || !$_POST['form_message'] ){
		$validation_message = "<span class='error'><i class='icon-remove-sign'></i> Please Fill In All Fields</span>";
		$passes = false;
	} elseif( !preg_match('/@.+?\.(co.uk|com|org|gov|co|eu)$/', $_POST['form_email']) ){
		$validation_message = "<span class='error'><i class='icon-remove-sign'></i> Please Provide A Valid Email Address</span>";
	 	$passes = false;
	}

	if( $passes ) {
		//Build Message
		$message = 'Name: '.$_POST['form_name']."\n";
		$message .= 'Email: '.$_POST['form_email']."\n";
		$message .= "Message:\n".$_POST['form_message'];

		$validation_message = "<span class='success'>Thank you for your enquiry, we'll get back to you soon.</span>";

		//add_filter( 'wp_mail_content_type', 'set_html_content_type' );
		$headers = "From: ".get_bloginfo('name')." <".get_bloginfo('admin_email').">";
		wp_mail(get_bloginfo('admin_email'), "Website Enquiry", $message, $headers );

	}

} else {
	$passes = false;
}

?>

<?php echo $validation_message; ?>

<form id="contact_form" method="POST" <?php echo $passes ? 'style="display:none;"' : '' ; ?>>

	<?php wp_nonce_field( basename( __FILE__ ), 'sc_contact_form_nonce' ); ?>

	<label for="contact_name">Name</label>
	<br />
	<input id="contact_name" type="text" name="form_name" value="<?php echo isset($_POST['form_name']) ? $_POST['form_name'] : '' ; ?>" />

	<br />

	<label for="contact_email">Email</label>
	<br />
	<input id="contact_email" type="text" name="form_email" value="<?php echo isset($_POST['form_email']) ? $_POST['form_email'] : '' ; ?>" />

	<br />

	<label for="contact_message">Message</label>
	<br />
	<textarea id="contact_message" name="form_message"><?php echo isset($_POST['form_message']) ? $_POST['form_message'] : '' ; ?></textarea>

	<br />

	<button name="submit">Submit</button>
	
</form>