<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ActualPlayMembership {

    private static $gc_public_key = '';
    private static $gc_secret_key = '';
    private static $mc_api_key = '';

	public static function init() {

        $actual_play_settings = get_option( 'actualplay_settings' );
        self::$gc_public_key = $actual_play_settings['actualplay_captcha_public'];
        self::$gc_secret_key = $actual_play_settings['actualplay_captcha_private'];
        self::$mc_api_key = $actual_play_settings['actualplay_mailchimp'];


        /**
         * New fresh and clean login skin
         */
        add_action( 'login_head', array( __CLASS__, 'custom_login_logo') );

        /**
         * Add a captcha to the registration form cause we aren't having a billion fake registrations
         */
        //add_action( 'register_form', array( __CLASS__, 'add_captcha' ) );        
        //add_action( 'registration_errors', array( __CLASS__, 'validate_captcha' ), 10, 3 );      
        
        /**
         * Check to see if logged in user is subscribed to the mailchimp list
         */
        add_action( 'admin_init', array( __CLASS__, 'check_current_user_subscription_status') );   

		// add user meta box
		// Hooks near the bottom of profile page (if current user) 
		add_action('show_user_profile', array(__CLASS__, 'custom_user_profile_fields' ));
        add_action('show_user_profile', array(__CLASS__, 'user_profile_skin' ), 1);

		// Hooks near the bottom of the profile page (if not current user) 
        add_action('edit_user_profile', array( __CLASS__, 'custom_user_profile_fields' ));

        
        // the mailchimp subscription status is returned on the user rest api response
        add_action( 'rest_api_init', array( __CLASS__, 'add_user_meta_to_api' ) );       

        // add custom members only post type
        add_action( 'init', array(__CLASS__, 'register_members_only_content'), 0 );  

        // subscribe new users to mailchimp on registration
        add_action( 'user_register', array( __CLASS__, 'subscribe_user_to_mailchimp') );

        // handles the ajax request to change the core curriculum from development to production
        add_action( 'wp_ajax_subscribe_mailchimp', array( __CLASS__, 'mailchimp_ajax' ) );

        //add_action( 'wp_ajax_nopriv_subscribe_mailchimp', array( __CLASS__, 'mailchimp_ajax' ) );    

        // handles the ajax request to change the core curriculum from development to production
        add_action( 'wp_ajax_unsubscribe_mailchimp', array( __CLASS__, 'mailchimp_ajax' ) );  
        
        add_action( 'wp_ajax_nopriv_create_user', array( __CLASS__, 'create_user' ) ); 

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
     * ensure subscription is in the user meta response
     */


    public static function add_user_meta_to_api() {
        // register_rest_field ( 'name-of-post-type', 'name-of-field-to-return', array-of-callbacks-and-schema() )
            register_rest_field( 'user', '_membership', array(
               'get_callback'    => array( __CLASS__, 'get_user_meta_for_api'),
               'schema'          => null,
             )
         );


    }

    /**
     * gets the mailchimp subscription status and sets the provided users meta with the info
     */

    public static function check_subscription_status( $user ) {

        // hash that user email for use in the api call
        $hashed_email = md5( $user->user_email );         
     
        // mailchimp api route 
        $url = 'https://us8.api.mailchimp.com/3.0/lists/fb4ae35f4c/members/' . $hashed_email;

        if ( false === ( $mailchimp_user_data = get_transient( $url ) ) ) {

            // check mail chimp
            $response = wp_remote_get( $url, array(            
                'headers' => array(
                    'Authorization' => 'Basic ' . base64_encode( 'anystring' . ':' . self::$mc_api_key ),
                ),
            ) );

            $mailchimp_user_data = wp_remote_retrieve_body( $response );   
            set_transient( $url, $mailchimp_user_data );

        }

        $mailchimp_user_data = json_decode( $mailchimp_user_data );

        $membership = false;

        if( $mailchimp_user_data->status == 'subscribed' ) {
            $membership = true;
        }

        // update user meta
        self::update_user_membership_meta( $user->ID, $membership );    

        return $membership;
    }

    /**
     * Check the logged in users subscription status
     */

    public static function check_current_user_subscription_status() { 

        // get current user
        if( !is_user_logged_in() ) {
            return;
        }

        $user = wp_get_current_user();
                     
        return self::check_subscription_status( $user );

    }

    /**
     *  Create a user via AJAX
     */

    public static function create_user(){

        if ( !isset($_REQUEST['referer']) || $_REQUEST['referer'] != '/members/' ) {            
            return;
        }

        if ( !isset($_REQUEST['nonce']) || wp_verify_nonce( $_REQUEST['nonce'] ) ) {            
            return;
        }

        if( !isset($_REQUEST['email']) ) {
            return;
        }

        $email = $_REQUEST['email'];

        $dummy_password = md5( $email );

        $user = wp_create_user( $email, $dummy_password, $email );

        if( is_wp_error($user) ) {
            return $user;
        }

        wp_new_user_notification( $user, null, 'both' );        
        self::subscribe_user_to_mailchimp( $email );
        wp_set_auth_cookie( $user, true );

        return $user;

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

	public static function custom_user_profile_fields( $user ){    ?>

        <h2>Email Preferences</h2>     
        
        <?php
            $membership = self::check_current_user_subscription_status();

            if( !$membership ) {
                self::render_subscribe_button();
            } else {
                self::render_unsubscribe_button();
            }

        
	}		

    public static function render_unsubscribe_button() { ?>

        <p><a href="https://cthulhudice.us8.list-manage.com/unsubscribe?u=2d506aed373ee18e74e419322&id=fb4ae35f4c">Go to Mailchimp to unsubscribe from emails</a></p>
    
		<?php 
		
    }

    public static function render_subscribe_button() { ?>

        <table class="form-table">
                                        
            <button id="subscribeMailchimp">Subscribe to Mailchimp</button>

            <?php wp_nonce_field('subscribe_to_mailchimp', '_mailchimp' ); ?>

        </table>
        <script>

            document.querySelector('#subscribeMailchimp').addEventListener('click', function( event ) {
                event.preventDefault();

                var data = {
                    'action' : 'subscribe_mailchimp', 
                    'email': document.querySelector('#email').value,
                    'nonce': document.querySelector('#_mailchimp').value,
                    'referer': document.querySelector('input[name="_wp_http_referer"]').value
                };
                
                console.log(data); 

                jQuery.post(
                    ajaxurl, data, function(response) { 
                        console.log(data);           
                        window.location.reload();
                    }
                ).fail(
                    function(response) {
                           
                    }
                );
            });


        </script>
    <?php 
    
    }

    
    public static function get_user_meta_for_api( $object ){

        //get the id of the post object array
        $user = get_user_by( 'id', $object['id'] );      
       
        //return the post meta
        return get_user_meta( $user->ID, '_membership', true );

    }


    public static function mailchimp_ajax() {

         if( !isset( $_POST ) ) {
            return false;
        }
   

        if( $_POST['action'] == 'subscribe_mailchimp') {

            if( !isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'subscribe_to_mailchimp') ) {                
                return;
            }

            self::subscribe_user_to_mailchimp( $_POST['email'] );

        } 

        if( $_POST['action'] == 'unsubscribe_mailchimp') {

            if( !isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'unsubscribe_to_mailchimp') ) {                
                return false;
            }

            self::unsubscribe_user_to_mailchimp( $_POST['email'] );

        } 

        die();     

    }


    /**
     *  Register Custom Post Type
     * */

    public static function register_members_only_content() {

        $labels = array(
            'name'                  => _x( 'Members Only', 'Post Type General Name', 'actualplay' ),
            'singular_name'         => _x( 'Members Only', 'Post Type Singular Name', 'actualplay' ),
            'menu_name'             => __( 'Members Only', 'actualplay' ),
            'name_admin_bar'        => __( 'Members Only', 'actualplay' ),
            'archives'              => __( 'Members Only Archives', 'actualplay' ),
            'attributes'            => __( 'Members OnlyAttributes', 'actualplay' ),
            'parent_item_colon'     => __( 'Parent Item:', 'actualplay' ),
            'all_items'             => __( 'All Items', 'actualplay' ),
            'add_new_item'          => __( 'Add New Item', 'actualplay' ),
            'add_new'               => __( 'Add New', 'actualplay' ),
            'new_item'              => __( 'New Item', 'actualplay' ),
            'edit_item'             => __( 'Edit Item', 'actualplay' ),
            'update_item'           => __( 'Update Item', 'actualplay' ),
            'view_item'             => __( 'View Item', 'actualplay' ),
            'view_items'            => __( 'View Items', 'actualplay' ),
            'search_items'          => __( 'Search Item', 'actualplay' ),
            'not_found'             => __( 'Not found', 'actualplay' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'actualplay' ),
            'featured_image'        => __( 'Featured Image', 'actualplay' ),
            'set_featured_image'    => __( 'Set featured image', 'actualplay' ),
            'remove_featured_image' => __( 'Remove featured image', 'actualplay' ),
            'use_featured_image'    => __( 'Use as featured image', 'actualplay' ),
            'insert_into_item'      => __( 'Insert into item', 'actualplay' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'actualplay' ),
            'items_list'            => __( 'Items list', 'actualplay' ),
            'items_list_navigation' => __( 'Items list navigation', 'actualplay' ),
            'filter_items_list'     => __( 'Filter items list', 'actualplay' ),
        );
        $capabilities = array(
            'edit_post'             => 'manage_options',
            'read_post'             => 'manage_options',
            'delete_post'           => 'manage_options',
            'edit_posts'            => 'manage_options',
            'edit_others_posts'     => 'manage_options',
            'publish_posts'         => 'manage_options',
            'read_private_posts'    => 'manage_options',
        );
        $args = array(
            'label'                 => __( 'Members Only', 'actualplay' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor' ),
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-admin-network',
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'rewrite'               => false,
            'capabilities'          => $capabilities,
            'show_in_rest'          => true,
        );
        register_post_type( 'members_only', $args );

    }

    /**
     * takes a user id and subscribes user to mailchimp
     */

    public static function subscribe_user_to_mailchimp_by_id( $user_id ){
        if( $user_id == 0 || $user_id == null || $user_id == '') {
            return;
        }

        $user = get_user( $user_id );
        $email = $user->user_email;              

        self::subscribe_user_to_mailchimp( $email );

    }


    public static function subscribe_user_to_mailchimp( $email ){        

        $request_body = array( "email_address" => $email, "status" => "pending" );

        $url = 'https://us8.api.mailchimp.com/3.0/lists/fb4ae35f4c/members/';

        $response = wp_remote_post( $url, 
            array( 
                'headers' => array('Authorization' => 'Basic ' . base64_encode( 'anystring' . ':' . self::$mc_api_key )),            
                'body'=> json_encode($request_body) 
            )
        );

        $user = wp_get_current_user();
        
        self::update_user_membership_meta( $user->ID, true );
    }

   

    /**
     *      
     */

    public static function unsubscribe_user_to_mailchimp( $email ){
   
        $request_body = array( "status" => "unsubscribed" );

        $url = 'https://us8.api.mailchimp.com/3.0/lists/fb4ae35f4c/members/'.md5($email);

        $response = wp_remote_request( $url, 
            array( 
                'method' => 'PATCH',
                'headers' => array('Authorization' => 'Basic ' . base64_encode( 'anystring' . ':' . self::$mc_api_key )),            
                'body'=> json_encode($request_body) 
            )
        );

        self::update_user_membership_meta( $user->ID, false );
    }

    /**
     * 
     */


    public static function update_user_membership_meta( $user_id, $subscribed ) {        
        update_user_meta( $user_id, '_membership', $subscribed );        
    }


    /**
     *  Shows customized user profile to match front end of site
     */

    public static function user_profile_skin(){ 

        if( current_user_can('unfiltered_html') ) {
            return;
        } 
        ?>
        <style>
            .ab-icon,
            #adminmenuback,
            #adminmenu,
            h2,
            .user-admin-color-wrap,
            .show-admin-bar.user-admin-bar-front-wrap,
            .user-first-name-wrap,
            .user-last-name-wrap,
            .user-nickname-wrap,
            .user-display-name-wrap,
            .user-url-wrap,
            .user-description-wrap,
            .user-profile-picture {
                display: none;
            }            
        </style>

        <p><strong><a href="<?php echo home_url('/members');?>">Visit Members Area</a></strong></p>


    <?php
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
 