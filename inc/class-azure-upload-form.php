<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



class Azure_Upload_Form {	


	/*--------------------------------------------------------------------------------------
    *
    * Add Actions
    *
    *--------------------------------------------------------------------------------------*/

	public static function init() {	
		add_action('admin_menu', array( __CLASS__, 'add_tools_page' ));

	}

	
	public static function add_tools_page(){
		add_management_page( 'Upload your Everything is True Files','Upload your Everything is True Files','edit_posts', 'everything-is-true-upload', array(__CLASS__, 'render_tools_page') );
	}
		

	public static function render_tools_page() {
			$actual_play_settings = get_option( 'actualplay_settings' );
			$azuresas = $actual_play_settings['azuresas'];

			?>

			<div id="message" style="display: none;" class=" notice notice-success is-dismissible"><p>Upload Successful</p></div>
			
			<div class="wrap">  
			<h1>Upload your Everything is True files</h1>

			<?php 
			if( $azuresas == "" || !$azuresas ){
				echo "No access";
				return;
			}
			?>
			

			<form action="" method="put">
				<input type="file" name="file" id="file" />
				<input type="submit" id="upload" value="Upload your file" />
			</form>

			<script src="<?php echo get_template_directory_uri(); ?>/assets/azure-storage.blob.min.js" charset="utf-8"></script>

			<script>

				const account = {
    				name: "everythingistrue",
    				sas: "<?php echo $azuresas; ?>"
				};

				const blobUri = 'https://' + account.name + '.blob.core.windows.net';
				const blobService = AzureStorage.Blob.createBlobServiceWithSas(blobUri, account.sas);

				document.querySelector("#upload").addEventListener( "click", function(event) {
					
					event.preventDefault();
					sendStorageRequest();

				});


				function sendStorageRequest() {

					const file = document.querySelector( "#file" ).files[0];

					if( file.type != "audio/mpeg") {
						return;
					}

					blobService.createContainerIfNotExists('audio',  (error, container) => {
						if (error) {
							// Handle create container error
							console.log(error);
						} else {
							finishStorageRequest( file );
						}
					});
	

				}
		

				function finishStorageRequest( file ) {
					blobService.createBlockBlobFromBrowserFile('audio', 
						file.name, 
						file, 
						(error, result) => {
							if(error) {
								// Handle blob error
							} else {
								document.querySelector("#message").style.display = "block";
								console.log('Upload is successful');
							}
                    });
				}

			</script>

		<?php
        

		
	}




} 