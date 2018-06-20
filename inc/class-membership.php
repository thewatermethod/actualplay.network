<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ActualPlayMembership {

    // TODO: move these to settings fields
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
        <!-- RECAPTCHA -->
        <script src='https://www.google.com/recaptcha/api.js'></script>        
        <div class="g-recaptcha" data-sitekey="6Leikl8UAAAAAMhN94iOAvtNw5MBEMHUw1nBCjNk"></div>
        <!-- END RECAPTCHA -->

    <?      
    }


    /**
     *  Reskin the login & register pages
     */

    public static function custom_login_logo() {
       
        // if there is no custom logo set, then we don't bother we any of this
        if ( !get_header_image() ) {
            return;             
        } 

        ?>

        <script>
            
            document.addEventListener("DOMContentLoaded", function(event) {
                /**
                 * This makes sure that the logo links to the site home page, not wordpress.org
                 */                
                document.querySelector('#login h1 a').setAttribute('href', '<?php echo home_url('/'); ?>');
            });
            
        </script>

        <style>
            body {
                /*background-color: white;*/
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
                /*background: #f1f1f1;*/
                background-image: url( '<?php echo get_template_directory_uri(); ?>/assets/graph.svg');*/
            }

            #login input[type=submit] {
                background-color: #693fb5;
                box-shadow: 0.25em 0.25em 0 #b5a33f;
                border-bottom: 0;
                color: #fff;      
                display: block;
                float: none;
                margin: 0 auto;          
                width: 50%;
            }

            #login input[type=submit]:hover {
                background: #3f8cb5;
                text-decoration: underline;
            }

	    </style> 
        
	                        

        <?php
    }

    /**
     * Validates the captcha response to validate new user registration
     */

    public static function validate_captcha($errors, $sanitized_user_login, $user_email){
        
        $g_captcha_response = $_POST['g-recaptcha-response'];     

        // TODO: add ip address to response
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


// A debug function

if ( ! function_exists('write_log')) {
    function write_log ( $log )  {
       if ( is_array( $log ) || is_object( $log ) ) {
          error_log( print_r( $log, true ) );
       } else {
          error_log( $log );
       }
    }
 }
 