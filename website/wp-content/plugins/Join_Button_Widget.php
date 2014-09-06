<?php
/*
Plugin Name: Join Button Widget
Plugin URI: http://poeredByCoffee.co.uk
Description: Adds A Button Linking to the Join Page
Version: 1.0
Author: Stewart Ritchie
Author URI: http://poweredByCoffee.co.uk
License: GPL2
*/

class Join_Button extends WP_Widget {  
	function Join_Button() {  
		parent::WP_Widget(false, 'Join Button');  
	}  
	function form($instance) {  
		// outputs the options form on admin  
	}  
	function update($new_instance, $old_instance) {  
		// processes widget options to be saved  
		return $new_instance;  
	}  
	function widget($args, $instance) 
	{  
		extract($args);

		echo $before_widget;  

		$current_user = wp_get_current_user();
		if ( 0 == $current_user->ID ) 
		{

			echo '<a href="'. get_bloginfo(url) .'/join" class="button">Join The Club </a>';
			echo '<a href="'. get_bloginfo(url) .'/register" class="button">Register </a>';

			sidebarlogin();
		}else {
			// Logged in.
			echo '<a href="'. get_bloginfo(url) .'/wp-login.php?action=logout" class="button">Logout</a>';
			echo '<a href="'. get_bloginfo(url) .'/members-area" class="button">Members Area</a>';
			echo '<a href="'. get_bloginfo(url) .'/wp-admin/profile.php" class="button">Your Profile</a>';

		}

		echo $after_widget;  
	}  
}  



add_action('widgets_init', 'pbc_register_join_widget');

// load the widget for the join button	
function pbc_register_join_widget() 
{
	register_widget('Join_Button');
}


?>
