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
        add_action( 'registration_errors', array( __CLASS__, 'validate_captcha' ), 10, 3 );


    }
    
    /**
     * Add captcha to new user registration
     */

    public static function add_captcha() { ?>
    
        <script src='https://www.google.com/recaptcha/api.js'></script>        
        <div class="g-recaptcha" data-sitekey="6Leikl8UAAAAAMhN94iOAvtNw5MBEMHUw1nBCjNk"></div>

    <?      
    }


    /**
     *  Reskin the login page
     */

    public static function custom_login_logo() {
       
        if ( !get_header_image() ) {
            return;             
        } 

        ?>

        <style>
            body {
                background-color: white;
              /*  background-image: url( '<?php echo get_template_directory_uri(); ?>/assets/graph.svg');*/
            }
            #login {
                width: 400px;
            }
            .login h1 a { 
                display:all; 
                background: url('<?php echo get_header_image(); ?>') no-repeat bottom center !important; 
                margin-bottom: 10px; 
                background-size: auto; 
            } 
	        .login h1 a { 
                width: auto!important;
            }
            .login form {
                background: #f1f1f1;           
            }
	    </style> 
        
	                        

        <?php
    }

    public static function validate_captcha($errors, $sanitized_user_login, $user_email){

        $g_captcha_response = $_POST['g-recaptcha-response'];     

        $request_args = array(
            'secret' => self::$secret_key,
            'response' => $g_captcha_response,
        );

        $request = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array( 'body' => $request_args ) );
        $request_body = json_decode(wp_remote_retrieve_body( $request ));

        if( $request_body->success == 1 ) {
            return $errors;
        }

        $errors->add('captcha_failure', 'Sorry, something isn\'t quite right');

		return $errors;
	
    }



} // Closes ActualPlay Membership class

if ( ! function_exists('write_log')) {
    function write_log ( $log )  {
       if ( is_array( $log ) || is_object( $log ) ) {
          error_log( print_r( $log, true ) );
       } else {
          error_log( $log );
       }
    }
 }
 