<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ActualPlayMembership {

    static $public_key = '6Leikl8UAAAAAMhN94iOAvtNw5MBEMHUw1nBCjNk';
    static $secret_key = '6Leikl8UAAAAACiKDcGPWE8nWhQjjNlmv_dWLxqT';

	public static function init() {

        add_action('login_head', array( __CLASS__, 'custom_login_logo') );
        add_action( 'register_form', array( __CLASS__, 'add_captcha' ) );


    }
    
    /**
     * Add captcha to new user registration
     */

    public static function add_captcha(){
        


    }


    /**
     *  Reskin the login page
     */

    public static function custom_login_logo(){
       
        if ( !get_header_image() ) {
            return;             
        } 

        ?>

        <style>
            .login h1 a { display:all; background: url('<?php echo get_header_image(); ?>') no-repeat bottom center !important; margin-bottom: 10px; background-size: auto; } 
	        .login h1 a { width: auto!important;}
	    </style> 
        
	                        

        <?php
    }





}