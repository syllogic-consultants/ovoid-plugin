<?php
/*
Plugin Name: OVOID-Connect
Plugin URI: http://codex.wordpress.org/Adding_Administration_Menus
Description: OVOID-Connect Custom Plugin
Author: Syllogic
Author URI: http://wordpress.syllogic.in
*/
if (!class_exists("Listing")) 
    include_once("class_listing.php");

if (!class_exists("Projects"))
    include_once("Projects.php");

if (!class_exists("Projectupdates"))
    include_once("ProjectUpdates.php");
    
class OvoidConnect extends Listing {
    public function __construct() {
        $ProjectUpdates_obj = new ProjectUpdates(); 
        $Projects_obj = new projects();
       
    }

}

$Ovoid_obj = new OvoidConnect();

function ovoid_emailCheck() {
   // This function gets called from the projects page through AJAX...
   // get email passed via AJAX
   
   $email = $_GET['email'];
  // echo "The email ID passed is $email\n";
      
   // Check the User Object
   $user = get_user_by( 'email', $email );
   //echo "The email ID passed is $email\n";
   
   if ($user) {
      echo $user->user_login;
      exit;      
   }   
   else { 
     echo 0;
      exit;
   }   
}

 // creating Ajax call for WordPress  
   add_action( 'wp_ajax_nopriv_ovoid_emailCheck', 'ovoid_emailCheck' );  
   add_action( 'wp_ajax_ovoid_emailCheck', 'ovoid_emailCheck' );  
?>
