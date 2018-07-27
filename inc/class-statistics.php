<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Podcast_Statistics {	
	

	/*--------------------------------------------------------------------------------------
    *
    * Add Actions
    *
    *--------------------------------------------------------------------------------------*/

	public static function init() {

		add_action('admin_menu', array( __CLASS__, 'add_tools_page' ));


	}

	/*--------------------------------------------------------------------------------------
    *
    * Add the Podcast Statistics Page under menu title
    *
    *--------------------------------------------------------------------------------------*/

	
	public static function add_tools_page(){
		add_management_page( 'Podcast Statistics','Podcast Statistics','edit_posts', 'podcast-statistics', array(__CLASS__, 'render_tools_page') );
	}
	
	

	/*--------------------------------------------------------------------------------------
    *
    * Render the Podcast Statistics Page
    *
    *--------------------------------------------------------------------------------------*/

	public static function render_tools_page() {

		$actual_play_settings = get_option( 'actualplay_settings' );
		$simplecast_api_key = $actual_play_settings['simplecast_api'];
		$simplecast_podcast_id = $actual_play_settings['simplecast_podcast_id'];

		if( $simplecast_api_key == '' || $simplecast_podcast_id == '' ) {
			return;
		}

		$all_episodes_url =  'https://api.simplecast.com/v1/podcasts/'.$simplecast_podcast_id.'/episodes.json';

		$all_episodes_request = self::cache_api_reponse( $all_episodes_url, $simplecast_api_key );			
		
		$episodes = json_decode( $all_episodes_request );
		
		?>
		<div class="wrap">
			<h1>Podcast Statistics</h1>

			<table style="width: 100%;">

		<?php 
			foreach ($episodes as $episode ) {

				$haystack = $episode->title;
				$needle = 'ActualPlay.Network';

				if (strpos($haystack, $needle) !== false) {

					?><tr style="width: 100%;">
						<td style="padding: .5em; border-bottom: 1px solid #ccc;width: 50%; font-size: 1.25em"><?php echo $episode->title; ?></td>
					<?php
						$episode_url = 'https://api.simplecast.com/v1/podcasts/'.$simplecast_podcast_id.'/statistics/episode.json?timeframe=all&episode_id=' . $episode->id;
						$episode_stats_request = self::cache_api_reponse( $episode_url, $simplecast_api_key );
						$episode_stats = json_decode($episode_stats_request);			
									?>
						<td style="padding: .5em; border-bottom: 1px solid #ccc;width: 50%; font-size: 1.25em"><?php echo $episode_stats->total_listens; ?></td>
					</tr>

				<?php

				}				

			}
			

		?>
		</table>
		</div>

		<?php
		
	}

	public static function cache_api_reponse( $url, $simplecast_api_key ) {
		// Get any existing copy of our transient data
		if ( false === ( $request_body = get_transient( $url ) ) ) {

			$headers = array(
				'X-API-KEY' =>  $simplecast_api_key
			);

			$response = wp_remote_get( $url, array( 'headers' => $headers ) ); 
			$request_body = wp_remote_retrieve_body( $response );

			set_transient( $url, $request_body, 24 * HOUR_IN_SECONDS );

		}
		
		return $request_body;


	}


} 