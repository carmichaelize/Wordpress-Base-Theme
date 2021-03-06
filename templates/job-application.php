<?php

$validation_message = "";

if( isset($_POST['submit']) ){

	$passes = true;

	// Verify nonce before proceeding
	if( !isset( $_POST['sc_application_form_nonce'] ) || !wp_verify_nonce( $_POST['sc_application_form_nonce'], basename( __FILE__ ) ) ){
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

	//CV Upload
	if($_FILES['file']['error'] == UPLOAD_ERR_OK) {

		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime = finfo_file($finfo, $_FILES['file']['tmp_name']);

		if($mime == 'application/msword' || $mime == 'application/pdf'){

			//Check 'temp' Directory Exsists
			if(!file_exists(WP_CONTENT_DIR .'/uploads/temp')){
    			mkdir(WP_CONTENT_DIR .'/uploads/temp', 0777, true);
			}
			move_uploaded_file($_FILES["file"]["tmp_name"], WP_CONTENT_DIR .'/uploads/temp/'.basename($_FILES['file']['name']));
			$attachment = array(WP_CONTENT_DIR ."/uploads/temp/".$_FILES["file"]["name"]);
		} else {
			$validation_message = "<span class='error'><i class='icon-remove-sign'></i> Invalid File Type</span>";
			$attachment = NULL;
			$passes = false;
		}

	} else {
		$attachment = NULL;
	}

	if( $passes ) {
		//Build Message
		$message = 'Name: '.$_POST['form_name']."\n";
		$message .= $_POST['form_address'] ? "Address:\n".$_POST['form_address']."\n\n" : '';
		$message .= 'Email: '.$_POST['form_email']."\n";
		$message .= 'Tel: '.$_POST['form_phone']."\n\n";
		$message .= "Cover Letter / Summary:\n".$_POST['form_message'];

		$validation_message = "<span class='success'>Thank you for your enquiry, we'll get back to you soon.</span>";

		$headers = "From: ".get_bloginfo('name')." <".get_bloginfo('admin_email').">";
		wp_mail(get_bloginfo('admin_email'), "Job Application", $message, $headers, $attachment);

		//Delete Attachment
		if($attachment){
			$files = glob(WP_CONTENT_DIR.'/uploads/temp/*');
			foreach($files as $file){
			  if(is_file($file)){
			  	 unlink($file); // delete file
			  }
			}
		}
	}

} else {
	$passes = false;
}

?>

<?php echo $validation_message; ?>

<form id="job_application_form" enctype="multipart/form-data" method="POST" <?php echo $passes ? 'style="display:none;"' : '' ; ?>>

	<?php wp_nonce_field( basename( __FILE__ ), 'sc_application_form_nonce' ); ?>

	<label for="contact_name">Name</label>
	<br />
	<input id="contact_name" type="text" name="form_name" value="<?php echo isset($_POST['form_name']) ? $_POST['form_name'] : '' ; ?>" />

	<br />

	<label for="contact_phone">Phone Number</label>
	<br />
	<input id="contact_phone" type="text" name="form_phone" value="<?php echo isset($_POST['form_phone']) ? $_POST['form_phone'] : '' ; ?>" />

	<br />

	<label for="contact_email">Email</label>
	<br />
	<input id="contact_email" type="text" name="form_email" value="<?php echo isset($_POST['form_email']) ? $_POST['form_email'] : '' ; ?>" />

	<br />

	<label for="contact_address">Address</label>
	<br />
	<textarea id="contact_address" name="form_address"><?php echo isset($_POST['form_address']) ? $_POST['form_address'] : '' ; ?></textarea>

	<br />

	<label for="contact_message">Cover Letter / Summary</label>
	<br />
	<textarea id="contact_message" name="form_message"><?php echo isset($_POST['form_message']) ? $_POST['form_message'] : '' ; ?></textarea>

	<br />

	<label for="contact_file">Upload CV:</label>
	<br />
	<input type="file" id="contact_file" name="file" size="20">

	<br /><br />

	<button name="submit">Submit</button>

</form>