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
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */

    public static function setup_theme(){

        /*
	    * Make theme available for translation.
	    * Translations can be filed in the /languages/ directory.
	    * If you're building a theme based on actual-play, use a find and replace
	    * to change 'actual-play' to the name of your theme in all the template files.
	    */
	    load_theme_textdomain( 'actual-play', get_template_directory() . '/languages' );

	    // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
        
        /*
        * Let WordPress manage the document title.
        * By adding theme support, we declare that this theme does not use a
        * hard-coded <title> tag in the document head, and expect WordPress to
        * provide it for us.
        */
        add_theme_support( 'title-tag' );

        /*
        * Enable support for Post Thumbnails on posts and pages.
        *
        * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
        */
        add_theme_support( 'post-thumbnails' );
        
        register_nav_menus( array(
            'primary' => esc_html__( 'Primary', 'actual-play' ),
            'footer' => esc_html__('Footer', 'actual-play')
        ) );
        
        /*
        * Switch default core markup for search form, comment form, and comments
        * to output valid HTML5.
        */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        add_theme_support( 'post-thumbnails' );
        /*
        * Enable support for Post Formats.
        * See https://developer.wordpress.org/themes/functionality/post-formats/
        */
        add_theme_support( 'post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
        ) );

        // Set up the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'actual_play_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        ) ) );
    } 

} 