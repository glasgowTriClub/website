 jQuery(document).ready(function() 
 {

	// when the document has loaded get the volunter submit button and appen the action lister to it
	volunteerButton = jQuery("#volunteerSubmit");
	volunteerButton.click(makeVolunteerRequest);

 });


// function that make the AJAX request to 'ajaxurl' and then calls the response 
function makeVolunteerRequest()
	{
	
	// stop the button click doing anything
	event.preventDefault();
	
	formData = jQuery("#volunteerForm").serialize();
		
	formData += "&volunteerNonce=" + MyAjax.volunteerNonce; 
		
	jQuery.post(
    // see tip #1 for how we declare global javascript variables
    MyAjax.ajaxurl,
	formData,
    function(response) 
    	{
        
        changeForm();
        
        response = JSON.parse(response)
        
        if(response.action === "add")
        	{
        	
        	addVolunteer(response)
        	
        	}
        else if(response.action === "remove")
        	{
        	
        	
        	removeVolunteer(response)
        	
        	}
    	}
	);
	
	}
	
	
	
function addVolunteer(response)
	{
	console.log(response)
	//response = JSON.parse(response)
	//console.log(response)
	
	volunteerList = jQuery("#volunteerList");
	volunteerList.append('<li id="volunteer_' + response.id +'">'+ response.avatar +'</li>');
	
	 jQuery("#noVolunteerMsg").hide();
	
	}
	
	
function removeVolunteer(response)
	{
	
	vol = jQuery("#volunteer_" + response.id);
	console.log(vol);
	vol.remove();
	
	
	// check how many volunteers
	volunteers = jQuery("#volunteerList > li").length;
	
	// none? show the message
	if(volunteers === 0)
		{
		jQuery("#noVolunteerMsg").show();
		}
		
	}
	
function changeForm()
	{
	
	volunteerButton = jQuery("#volunteerSubmit");
	
	// access the action fild in the form	
	actionField = jQuery("input[name=action]");
	action = actionField.attr("value");
	
	
	//find what the action is and change the form accordingly
	if(action === "add_volunteer")
		{
		// the action is currently add volunteer, change it to remove
		actionField.attr("value", "remove_volunteer")
		
		//update the button text
		volunteerButton.attr("value", "Unvolunteer")
		
		
		
		}
	else if(action === "remove_volunteer")
		{
		
		
		//update the button text
		volunteerButton.attr("value", "Volunteer")		

		//action field is currently remove, change to add
		actionField.attr("value", "add_volunteer")
		
		}
	
	}

/*
    {
        // here we declare the parameters to send along with the request
        // this means the following action hooks will be fired:
        // wp_ajax_nopriv_myajax-submit and wp_ajax_myajax-submit
        action : 'add_volunteer',
 
        // other parameters can be added along with "action"
        postID : MyAjax.postID
    },
    
*/