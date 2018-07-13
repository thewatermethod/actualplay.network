<?php 
    wp_redirect( home_url('/members/'. get_the_id() ), 302 ); 
    die();    
?>