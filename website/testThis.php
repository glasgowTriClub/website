<?php
/**
 * Update variable settings.
 * Load to your WP root folder.
 */
 
// Set $to as the email you want to send the test to
$to = "paulmcnally000@gmail.com";
 
// No need to make changes below this line
 
// Email subject and body text
$subject = 'wp_mail function test';
$message = 'This is a test of the wp_mail function: wp_mail is working';
$headers = '';
 
// Load WP components, no themes
define('WP_USE_THEMES', false);
require('wp-load.php');
 
// Call the wp_mail function, display message based on the result.
if( wp_mail( $to, $subject, $message, $headers ) ) {
    // the message was sent...
    echo 'The test message was sent. Check your email inbox.';
} else {
    // the message was not sent...
    echo 'The message was not sent!';
};
?>
