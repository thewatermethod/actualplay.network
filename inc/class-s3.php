<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class s3_upload_form {	

	private $settings;
	

	/*--------------------------------------------------------------------------------------
    *
    * Add Actions
    *
    *--------------------------------------------------------------------------------------*/

	public static function init() {

		self::$settings = get_option( 'actualplay_settings' );

		add_action('admin_menu', array( __CLASS__, 'add_tools_page' ));

        //https://docs.aws.amazon.com/AmazonS3/latest/API/sigv4-post-example.html


	}

	
	public static function add_tools_page(){
		add_management_page( 'Upload your Everything is True Files','Upload your Everything is True Files','edit_posts', 'everything-is-true-upload', array(__CLASS__, 'render_tools_page') );
	}
		


	public static function render_tools_page() {

		$s3_key = self::settings['amazons3'];
        $s3_secret_key = self::settings['amazons3secret'];
		
		?>
			
			<div class="wrap">  
			<form action="http://sigv4examplebucket.s3.amazonaws.com/" method="post" enctype="multipart/form-data">
				Key to upload: 
				<input type="input"  name="key" value="user/user1/${filename}" /><br />
				<input type="hidden" name="acl" value="public-read" />
				<input type="hidden" name="success_action_redirect" value="http://sigv4examplebucket.s3.amazonaws.com/successful_upload.html" />
				Content-Type: 
				<input type="input"  name="Content-Type" value="image/jpeg" /><br />
				<input type="hidden" name="x-amz-meta-uuid" value="14365123651274" /> 
				<input type="hidden" name="x-amz-server-side-encryption" value="AES256" /> 
				<input type="text"   name="X-Amz-Credential" value="AKIAIOSFODNN7EXAMPLE/20151229/us-east-1/s3/aws4_request" />
				<input type="text"   name="X-Amz-Algorithm" value="AWS4-HMAC-SHA256" />
				<input type="text"   name="X-Amz-Date" value="20151229T000000Z" />

				Tags for File: 
				<input type="input"  name="x-amz-meta-tag" value="" /><br />
				<input type="hidden" name="Policy" value='<Base64-encoded policy string>' />
				<input type="hidden" name="X-Amz-Signature" value="<signature-value>" />
				File: 
				<input type="file"   name="file" /> <br />
				<!-- The elements after this will be ignored -->
				<input type="submit" name="submit" value="Upload to Amazon S3" />
			</form>
  
  		</div>

		<?php
        

		
	}

	public static function cache_api_reponse( $url, $simplecast_api_key ) {


	}


} 