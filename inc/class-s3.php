<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class s3_upload_form {	
	

	/*--------------------------------------------------------------------------------------
    *
    * Add Actions
    *
    *--------------------------------------------------------------------------------------*/

	public static function init() {


		add_action('admin_menu', array( __CLASS__, 'add_tools_page' ));

        //https://docs.aws.amazon.com/AmazonS3/latest/API/sigv4-post-example.html


	}

	
	public static function add_tools_page(){
		add_management_page( 'Upload your Everything is True Files','Upload your Everything is True Files','edit_posts', 'everything-is-true-upload', array(__CLASS__, 'render_tools_page') );
	}
		


	public static function render_tools_page() {

        

		
	}

	public static function cache_api_reponse( $url, $simplecast_api_key ) {


	}


} 