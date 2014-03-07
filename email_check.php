<?php
require_once( dirname( dirname( __FILE__ ) ) . '/wp-load.php' );
require_once( ABSPATH . 'wp-admin/includes/admin.php' );
// get email passed via AJAX
$email = $_GET['email'];

// Check the User Object
$user = get_user_by( 'email', $email );

// do check
if ($user) {
//   $userInfo = get_userdata( $userID ); 
//   $response = $userInfo->user_login;
   $response = $user->user_login;
}
else {
    $response = 0;
}

?>