<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ActualPlayMembership {

    // TODO: move these to settings fields
    static $gc_public_key = '6Leikl8UAAAAAMhN94iOAvtNw5MBEMHUw1nBCjNk';
    static $gc_secret_key = '6Leikl8UAAAAACiKDcGPWE8nWhQjjNlmv_dWLxqT';
    static $mc_api_key = '97ed91c6086bdc5fde65f8cc6f9b1696-us8';

	public static function init() {

        /**
         * New fresh and clean login skin
         */
        add_action( 'login_head', array( __CLASS__, 'custom_login_logo') );

        /**
         * Add a captcha to the registration form cause we aren't having a billion fake registrations
         */
        add_action( 'register_form', array( __CLASS__, 'add_captcha' ) );        
        add_action( 'registration_errors', array( __CLASS__, 'validate_captcha' ), 10, 3 );      
        
        /**
         * Check to see if logged in user is subscribed to the mailchimp list
         */
        add_action( 'admin_init', array( __CLASS__, 'check_subscription_status') );   

		// add user meta box
		// Hooks near the bottom of profile page (if current user) 
		add_action('show_user_profile', array(__CLASS__, 'custom_user_profile_fields' ));

		// Hooks near the bottom of the profile page (if not current user) 
        add_action('edit_user_profile', array( __CLASS__, 'custom_user_profile_fields' ));
        
        add_action( 'rest_api_init', array( __CLASS__, 'add_user_meta_to_api' ) );         


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

    public static function add_user_meta_to_api() {
        // register_rest_field ( 'name-of-post-type', 'name-of-field-to-return', array-of-callbacks-and-schema() )
            register_rest_field( 'user', '_membership', array(
               'get_callback'    => array( __CLASS__, 'get_user_meta_for_api'),
               'schema'          => null,
             )
         );


    }

    /**
     * Check the logged in users subscription status
     */

    public static function check_subscription_status() { 

        // get current user

        if( !is_user_logged_in() ) {
            return;
        }

        $user = wp_get_current_user();
                     
        // get current user meta
        $user_status = get_user_meta( $user->ID, '_membership', true );

    
        // hash that user email for use in the api call
        //$hashed_email = md5( $user->user_email );    
        $hashed_email = md5('thewatermethod@gmail.com');
     
        // mail chimp api route 
        $url = 'https://us8.api.mailchimp.com/3.0/lists/fb4ae35f4c/members/' . $hashed_email;

        if ( false === ( $mailchimp_user_data = get_transient( $url ) ) ) {

            // check mail chimp
            $response = wp_remote_get( $url, array(            
                'headers' => array(
                    'Authorization' => 'Basic ' . base64_encode( 'anystring' . ':' . self::$mc_api_key ),
                ),
            ) );

            $mailchimp_user_data = wp_remote_retrieve_body( $response );   
            set_transient( $url, $mailchimp_user_data, HOUR_IN_SECONDS );

        }

        $mailchimp_user_data = json_decode( $mailchimp_user_data );

        // update user meta
        update_user_meta( $user->ID, '_membership', $mailchimp_user_data->status );                    

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

	public static function custom_user_profile_fields( $user ){         
        
        ?>
				
			<h2>Membership</h2>
            <table class="form-table">
                <tr>
                    <th><?php _e( 'Email Subscription' ); ?></label> </th>
                    <td><span><?php echo esc_attr( get_user_meta( '_membership', $user->ID , false) ); ?></span></td>
                </tr>
            </table>

		<?php 
		
    }
    
    public static function get_user_meta_for_api( $object ){
        //get the id of the post object array
        $user_id = $object['id'];
         
        //return the post meta
        return get_user_meta( $user_id, '_membership', true );
    }

    /**
     * Validates the captcha response to validate new user registration
     */

    public static function validate_captcha($errors, $sanitized_user_login, $user_email){
        
        $g_captcha_response = $_POST['g-recaptcha-response'];     

        // TODO: add ip address to response
        $request_args = array(
            'secret' => self::$gc_secret_key,
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
 