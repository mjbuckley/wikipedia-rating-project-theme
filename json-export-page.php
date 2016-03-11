<?php
/**
 * Template Name: JSON Export
 * Description: Allow downloading of all user posts in JSON format
 *
 */

 if ( is_user_logged_in() ) {
   // Current user is logged in, so grab user id
   global $current_user;
   get_currentuserinfo();
   $user_id = $current_user->ID;

   // This gets all of the user's posts in json format
   $data = wrp_json_export( $user_id );

   header( 'Content-type: application/json' );
   header('Content-Disposition: attachment; filename="data.json"');
   // Do I need an exit?

   echo $data;
 } else {
   // Not logged in, so shouldn't be accessing this data.  Redirect to home.
   // This includes a 301 header, which probably isn't technically correct, so
   // look at what else I might do (maybe a error page explaining what heppened?).
   wp_redirect( home_url() );
   exit;
 }

?>
