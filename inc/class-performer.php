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

		// add user meta box
		// Hooks near the bottom of profile page (if current user) 
		add_action('show_user_profile', array(__CLASS__, 'custom_user_profile_fields' ));

		// Hooks near the bottom of the profile page (if not current user) 
		add_action('edit_user_profile', array( __CLASS__, 'custom_user_profile_fields' ));

		// Hook is used to save custom fields that have been added to the WordPress profile page (if current user) 
		add_action( 'personal_options_update',  array( __CLASS__, 'update_extra_profile_fields') );

		// Hook is used to save custom fields that have been added to the WordPress profile page (if not current user) 
		add_action( 'edit_user_profile_update',  array( __CLASS__, 'update_extra_profile_fields' ) );

		// add custom post meta box
		add_action( 'add_meta_boxes_post', array( __CLASS__, 'add_custom_post_meta_box') , 10, 2 );

		// handle save post action
		add_action( 'save_post', array( __CLASS__, 'save_post') , 10, 2 );

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

	public static function add_custom_post_meta_box() {
		add_meta_box( 
			'selectPerfomers',
			__( 'Podcast Performer Settings' ),
			array( __CLASS__, 'render_post_meta_box'),
			'post',
			'normal',
			'default'
		);
	}

	public static function custom_user_profile_fields( $user ){
		// TODO: Include admins	
		if( !in_array( 'podcast_performer', $user->roles ) ) {
			return;
		}
		?>	

		<h2>Podcast Performer Meta Settings</h2>
		<table class="form-table">
        	<tr>
            	<th><label for="twitterHandle"><?php _e( 'Twitter Handle' ); ?></label> </th>
        	    <td><input type="text" name="twitterHandle" id="twitterHandle" value="<?php echo esc_attr( get_the_author_meta( 'twitterHandle', $user->ID ) ); ?>"/></td>
            </tr>
    	</table>


	<?php

	}

	public static function render_post_meta_box( $post ){
		// TODO: Include admins	
		
		$performers = get_post_meta( $post->ID, 'podcast_perfomers'); 
		$user_query = get_users( array( 'role__not_in' => array( 'Subscriber', 'Contributor', 'Author', 'Editor' ) ) );
	

		?>
		<?php var_dump( $performers ); ?>
		<fieldset> 
			<label class="widefat" for="podcastPerfomers">Select performers on this podcast</label>
			<select multiple class="widefat" name="podcastPerfomers[]" id="podcastPerfomers">
				
				<?php foreach ($user_query as $user) { 				
					$user = $user->data; 
					$selected = false;
					if( in_array( $user->ID, $performers ) ) {
					
						$selected = true;
					}


				?>				
					<option <?php if( $selected ) : echo 'selected'; endif;?> value="<?php echo $user->ID; ?>"><?php echo $user->display_name ?></option>	
				<?php } //endforeach ?>
			</select>
		</fieldset>

		<?php

	}

	public static function save_post( $post_id ){

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( defined( 'DOING_AJAX' ) && DOING_AUTOSAVE ) {
			return;	
		}

		if( ! isset($_POST['podcastPerformers']) ){
			return;
		}

		// TODO: This still isn't really working, but its close
		$podcast_performers = $_POST['podcastPerformers'];
		update_post_meta( $post_id, 'podcast_perfomers', $podcast_performers ); 

	}



	public static function update_extra_profile_fields( $user_id ) {
		if ( current_user_can( 'edit_user', $user_id ) ) {
			update_user_meta( $user_id, 'twitterHandle', $_POST['twitterHandle'] );
		}
	}
}

if ( ! function_exists('write_log')) {
	function write_log ( $log )  {
	   if ( is_array( $log ) || is_object( $log ) ) {
		  error_log( print_r( $log, true ) );
	   } else {
		  error_log( $log );
	   }
	}
 }
 