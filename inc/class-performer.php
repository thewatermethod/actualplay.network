<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Podcast_Performer {	
	
	/*--------------------------------------------------------------------------------------
    *
    * Add Actions
    *
    *--------------------------------------------------------------------------------------*/

    static $custom_roles = array( 
		'podcast_performer' => 'Podcast Performer' 
    );        

    static $custom_roles_capabilities = array(
		'podcast_performer' => array(		
			'activate_plugins' => false,
			'delete_others_pages' => false,
			'delete_others_posts' => false,
			'delete_pages' => true,
			'delete_posts' => true,
			'delete_private_pages' => true,
			'delete_private_posts' => true,
			'delete_published_pages' => true,
			'delete_published_posts' => true,
			'edit_dashboard' => false,
			'edit_others_pages' => false,
			'edit_others_posts' => false,
			'edit_pages' => true,
			'edit_posts' => true,
			'edit_private_pages' => true,
			'edit_private_posts' => true,
			'edit_published_pages' => true,
			'edit_published_posts' => true,
			'edit_theme_options' => false,
			'export' => false,
			'import' => false,
			'list_users' => true,
			'manage_categories' => true,
			'manage_links' => false,
			'manage_options' => false,
			'moderate_comments' => true,
			'promote_users' => false,
			'publish_pages' => true,
			'publish_posts' => true,
			'read_private_pages' => true,
			'read_private_posts' => true,
			'read' => true,
			'remove_users' => false,
			'switch_themes' => false,
			'upload_files' => true,
			'customize' => false,
			'delete_site' => false,
			'edit_users' => false,
			'create_users' => false,
			'delete_users' => false,
			'unfiltered_html' => true,
		)
	);

	public static function init() {

        // add user role
        add_action( 'init', array(__CLASS__, 'add_custom_user_roles') );

        // add user meta

	}

    
	public static function add_custom_user_roles(){
        
        $custom_roles_capabilities = get_transient( 'custom_roles_capabilites' );

        if( $custom_roles_capabilities == self::$custom_roles_capabilities ){
            return;
        }       
             
        $custom_roles_capabilities = self::$custom_roles_capabilities;
        set_transient( 'custom_roles_capabilites', $custom_roles_capabilities);
       
	    foreach( self::$custom_roles as $key => $value ) {

			add_role( $key, $value, self::$custom_roles_capabilities[$key]);
	
		}

	}

}