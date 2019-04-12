<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



class Actual_Play_Theme {	

    public static function init (){
    
        /**
         *  A place to dump info and api keys
         */

        require_once 'class-theme-settings-page.php';
        Podcast_SettingsPage::init();
    
        /**
         * creates a podcast statistics page (Simplecast integration)
         */

        require_once 'class-statistics.php';
        Podcast_Statistics::init();

	    // todo- Create custom game taxonomy

        /**
         *  Add theme supports, other housekeeping functions
         */

        add_action( 'after_setup_theme', array(__CLASS__, 'setup_theme' ) );

    }  

    /**
     *  
     */

    public static function setup_theme(){

    } 

} 