


<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


if(isset($_POST))
	{
	
	
	include('mail-class.php');
  	$mail = new Mail;
	

	
	// set the object data
	$mail->setTo('secretary@glasgowtriathlonclub.co.uk');
	$mail->setFrom($_POST['contact_email']);
	$mail->setSubject($_POST['contact_subject']);
	$mail->setMessage($_POST['contact_message']);
	$mail->setSenderName($_POST['contact_name']);
	$mail->setSelf($_POST['contact_self']);
	
	//var_dump($mail);
	
	// send the mail & return the code/message for the mail
	if(!$mail->send())
		{
		
		// encode the error report into JSON
		echo json_encode($mail->getError());
		
		}
	else
		{
		
		// return 0 to trigger the confirm message	
		echo "0";
		
		}
	
	}

?>