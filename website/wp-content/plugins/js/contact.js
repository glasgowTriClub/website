
jQuery(document).ready(function() 
	{
  
  	contactButton = jQuery("#contact_submit");
  	contactButton.click(function(event){buttonClicked(event)});
  	
  	quickContactButton = jQuery("#quickContactSubmit");
  	quickContactButton.click(quickButtonClicked);
  
	});
	
	
function buttonClicked(event)
	{
	
	event.preventDefault()
	
	jQuery.ajax({
  		type: 'POST',
 		url: "../ajax-mail.php",
  		data: jQuery("#contactForm").serialize(),
  		success: processMailResponse,
  		dataType: "JSON"
		});

	//console.log(jQuery("#contactForm").serialize());
	
	}
	
function quickButtonClicked()
	{
	
	event.preventDefault()
	
	jQuery.ajax({
  		type: 'POST',
 		url: "ajax-mail.php",
  		data: jQuery("#quickContactForm").serialize(),
  		success: processMailResponse,
  		dataType: "JSON"
		});

	//console.log(jQuery("#contactForm").serialize());
	
	}
	
function processMailResponse(data)
	{
	
	console.log(data);
	
		/* code
			 0 = sent fine
			 1 = null to
			 2 = null from
			 4 = null senderName
			 8 = null subject
			 16 = null message
			 32 = invalid email
			 
			 */
			 
		hideErrors();
		
		if(data == "0")
			{
			
			showConfirm();
			
			}
		else
			{
	
			showError(data, "32", "error_invalid");
			showError(data, "16", "error_message");
			showError(data, "8", "error_subject");
			showError(data, "4", "error_name");
			showError(data, "2", "error_email");
			showError(data, "1", "error_to");
		
			}
	}
	
function showConfirm()
	{
	
	
	confirm("Your message has been sent!");
	
	}
	
	
	
function showError(data, key, id)
	{
	
		if(data[key] != null ) { jQuery("#" + id).css("display","block").text(data[key]); }
	
	}
	
function hideErrors()
	{
	
	hideError("error_invalid");
	hideError("error_message");
	hideError("error_subject");
	hideError("error_name");
	hideError("error_email");
	hideError("error_to");
	
	}
	
function hideError(id)
	{
	jQuery("#" + id).css("display","none");
	}