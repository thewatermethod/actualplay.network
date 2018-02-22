<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Podcast_SettingsPage{	
	
	/*--------------------------------------------------------------------------------------
    *
    * Add Actions
    *
    *--------------------------------------------------------------------------------------*/

    static $settings_fields = array(
        'twitter_consumer_key' => 'Twitter Consumer Key',
        'actualplay_itunes' => 'Apple Podcasts URL',
        'actualplay_google_play' => 'Google Play URL',
        'actualplay_stitcher' => 'Stitcher URL',
        'actualplay_soundcloud' => 'Soundcloud URL',
        'actualplay_rss' => 'Podcast RSS URL',
        'actualplay_twitter' => 'Twitter Page',
        'actualplay_facebook' => 'Facebook Page',
        'actualplay_youtube' => 'Youtube Channel',
        'actualplay_email' => 'Email Address',
    );


	public static function init() {
        
        add_action( 'admin_menu', array( __CLASS__ , 'add_admin_menu' ) );
        add_action( 'admin_init', array( __CLASS__, 'settings_init' ) );


	}

    public static function add_admin_menu() { 

        add_options_page( 
            'Theme Settings', 
            'Theme Settings', 
            'manage_options', 
            'actualplay.network', 
            array( __CLASS__, 'options_page' )
        );
    
    }

    public static function settings_init(  ) { 

        register_setting( 'plugin_page', 'actualplay_settings' );

        
        add_settings_section(
            'actualplay_settings', 
            __( 'Actual Play Settings', 'actual-play' ), 
            array( __CLASS__, 'settings_callback'), 
            'plugin_page'
        );
        
        foreach (self::$settings_fields as $key => $value) {
            add_settings_field( 
                $key, 
                __( $value, 'actual-play' ), 
                array( __CLASS__, 'settings_input_render'), 
                'plugin_page', 
                'actualplay_settings',
                array( $key => $value )
            );
        }
   
    }

    public static function settings_callback(){
        echo 'Please enter the values below to populate your site.';

    }

    public static function settings_input_render( $args ){  

        $options = get_option( 'actualplay_settings' );

        foreach ($args as $key => $value) {        
            
            ?>
            <input 
                type='text' 
                name='actualplay_settings[<?php echo $key; ?>]' 
                value='<?php echo $options[$key]; ?>'>
            <?php
        
        }
    }
    
    public static function options_page(  ) { 

        ?>
        <form action='options.php' method='post'>
    
            <h1>ActualPlay.Network</h1>
    
            <?php
                settings_fields( 'plugin_page' );
                do_settings_sections( 'plugin_page' );
                submit_button();
            ?>
    
        </form>
        <?php
    
    }
    

}

