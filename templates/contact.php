<?php

$validation_message = "";

if( isset($_POST['submit']) ){

	$passes = true;

	if( !$_POST['form_name'] || !$_POST['form_email'] || !$_POST['form_message'] ){
		$validation_message = "Please Fill In All Fields";
		$passes = false;
	} elseif( !preg_match('/@.+?\.(co.uk|com|org|gov|co|eu)$/', $_POST['form_email']) ){
		$validation_message = "Please Provide A Valid Email Address";
	 	$passes = false;
	}

	if( $passes ) {
		//Build Message
		$message = 'Name: '.$_POST['form_name']."\n";
		$message .= 'Email: '.$_POST['form_email']."\n";
		$message .= "Message:\n".$_POST['form_message'];

		$validation_message = "Thank you for your enquiry, we'll get back to you soon.";
		wp_mail(get_bloginfo('admin_email'), "Website Enquiry", $message );
	}

} else {
	$passes = false;
}

?>

<?php echo $validation_message; ?>

<form id="contact_form" method="POST" <?php echo $passes ? 'style="display:none;"' : '' ; ?>>

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