<?php

class Mail
	{
	
	public $to; // string who the mail is for
	public $from; // who it is from
	public $senderName; // who sent it
	public $message; // the message
	public $subject; // the subject
	public $self; // send to self
	
	public $status; 
			
			/* code
			 0 = sent fine
			 1 = null to
			 2 = null from
			 4 = null senderName
			 8 = null subject
			 16 = null message
			 32 = invalid email
			 
			 */
			
	
	public function __construct()
		{
	
	//echo"hello";
	
		return $this;
		
		}
		
	
	// settors
	public function setTo($to){ $this->to = $to; }
	public function setFrom($from){ $this->from = $from; }
	public function setSenderName($senderName){ $this->senderName = $senderName; }
	public function setSubject($subject){ $this->subject = $subject; }
	public function setMessage($message){ $this->message = $message; }
	public function setSelf($self){ $this->self = $self; }	
	
	// send the message
	public function send()
		{
		
		// check the information is valid
		if($this->checkValid())
			{
			
			// set the header for the email
			$header = $this->setHeader();
			
			// try send the mail
			if(mail($this->to, $this->subject, $this->message, $header))
				{
				return true;
				}
			else
				{
				// return false is there was a problem sending the mail
				return false;
				}
				
			
			}
		
		}
		
		
	// checks that all the parameters are valid
	public function checkValid()
		{
		
		// check that to, from, message, subject, senderName are all set
		if(($this->to == "") || ($this->to == "0"))
			{
			
			$this->status += 1;
			
			
			}
			
		if($this->from == "") 
			{
			
			$this->status += 2;
			
			}
			
		if($this->senderName == "") 
			{
			
			$this->status += 4;
			
			
			}
			
		if($this->subject == "") 
			{
			
			$this->status += 8;
			
			
			}
			
		if($this->message == "") 
			{
			
			$this->status += 16;
			
			
			}
			
		
		// check that the email is valid	
		if(!$this->validEmail())
			{
			
			$this->status += 32;
			
			}
		
		if($this->status == 0)
			{
			return true;
			}
		else
			{
			return false;
			}
		
		}
		
	// create the haeder for the mail
		function setHeader()
		{
		
		$headers = "";
		
		// set a bcc to the sender
		if($this->self == true)
			{
			$headers .= 'Bcc: ' . $this->from. "\r\n";
			}
		
		
		// set the date
		$headers .= 'Date: ' . date("c") . "\r\n";
		
		// set the reply-to & From
		$headers .= 'Reply-To: ' . $this->from. "\r\n";
		$headers .= 'From: ' . $this->from. "\r\n";
		
		// set the x-mailer
		$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
		
		// set the MIME & content-type
		$headers .=  'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		return $headers;
		
		}
		
		
	/**
	Validate an email address.
	Provide email address (raw input)
	Returns true if the email address has the email 
	address format and the domain exists.
	
	http://www.linuxjournal.com/article/9585?page=0,3
	*/
	private function validEmail()
		{
		
		$email = $this->from;
		
   		$isValid = true;
  		$atIndex = strrpos($email, "@");
   		if (is_bool($atIndex) && !$atIndex)
   			{
     		$isValid = false;
   			}
   			
  		else
  			{
     		$domain = substr($email, $atIndex+1);
    		$local = substr($email, 0, $atIndex);
    		$localLen = strlen($local);
    		$domainLen = strlen($domain);
      		if ($localLen < 1 || $localLen > 64)
      			{
       	  		// local part length exceeded
         		$isValid = false;
      			}
      		else if ($domainLen < 1 || $domainLen > 255)
      			{
         		// domain part length exceeded
         		$isValid = false;
      			}
      		else if ($local[0] == '.' || $local[$localLen-1] == '.')
      			{
         		// local part starts or ends with '.'
         		$isValid = false;
      			}
      		else if (preg_match('/\\.\\./', $local))
      			{
         		// local part has two consecutive dots
         		$isValid = false;
     			}
      		else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      			{
         		// character not valid in domain part
         		$isValid = false;
      			}
      		else if (preg_match('/\\.\\./', $domain))
      			{
        		 // domain part has two consecutive dots
        		 $isValid = false;
      			}
      		else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local)))
     			{
        		// character not valid in local part unless 
        		// local part is quoted
        		if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local)))
         			{
            		$isValid = false;
         			}
      			}
      			
      		if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
     			{
        		// domain not found in DNS
         		$isValid = false;
      			}
  			 }
  		 return $isValid;
		}

	public function getError()
		{
		
		$errors = array();
		$status = $this->status;
		
		//echo"status: "; var_dump($status); 
		
		// this could potentially be a switch statement
		if($status >= 32)
			{
			
			$errors[32] = "The email address supplied is invalid.";
			$status -= 32;
			
			}
			
		if($status >= 16)
			{
			
			$errors[16] = "The Message field is empty.";
			$status -= 16;
			
			}
			
		if($status >= 8)
			{
			
			$errors[8] = "The Subject field is empty.";
			$status -= 8;
			
			}
			
		if($status >= 4)
			{
			
			$errors[4] = "The Sender Name field is empty.";
			$status -= 4;
			
			}
			
		if($status >= 2)
			{
			
			$errors[2] = "The From field is empty.";
			$status -= 2;
			
			}
			
		if($status >= 1)
			{
			
			$errors[1] = "The To field is empty.";
			$status -= 1;
			
			}
		
		if($this->status == 0)
			{
			
			$errors[0] = "No Error.";
			
			}
			
		return $errors;
		
		}
		
	}

?>