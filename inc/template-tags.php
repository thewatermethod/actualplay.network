<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package actual-play
 */

 //loaded the twitter oauth stuff
require  get_template_directory() . "/vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;


if ( ! function_exists( 'actual_play_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function actual_play_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'actual-play' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'actual-play' ),
		'<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
	
}
endif;

if ( ! function_exists( 'actual_play_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function actual_play_entry_footer() {


	if( in_category('podcast') && !is_front_page() && !is_home() ){

		performers_footer();

		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'actual-play' ) );
		if ( $categories_list && actual_play_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( '%1$s', 'actual-play' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'actual-play' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( '%1$s', 'actual-play' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	
		if( is_single() ): subscribe_links(); endif;
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function actual_play_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'actual_play_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'actual_play_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so actual_play_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so actual_play_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in actual_play_categorized_blog.
 */
function actual_play_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'actual_play_categories' );
}

add_action( 'edit_category', 'actual_play_category_transient_flusher' );
add_action( 'save_post',     'actual_play_category_transient_flusher' );


function actual_play_display_sharing_links( $actual_play_settings, $for_home_only ){ 

	$class = 'hide-on-home-desktop';

	if( $for_home_only ) {
		$class = 'show-on-home-desktop';
	}	
	?><ul class="sharing-links <?php echo $class; ?>">
	<?php
	if( $actual_play_settings["actualplay_rss"]):?>
		<li><a href="<?php echo $actual_play_settings["actualplay_rss"]; ?>"><span class="fa fa-rss" aria-hidden="true"></span></a></li>
	<?php endif;?>
	<?php if( $actual_play_settings["actualplay_itunes"] ):?>
		<li><a href="<?php echo $actual_play_settings["actualplay_itunes"]; ?>"><span class="fa fa-apple" aria-hidden="true"></span></a></li>
	<?php endif;
	if( $actual_play_settings["actualplay_soundcloud"]):?>	
		<li><a href="<?php echo $actual_play_settings["actualplay_soundcloud"]; ?>"><span class="fa fa-soundcloud" aria-hidden="true"></span></a></li>
	<?php endif;								
	if( $actual_play_settings["actualplay_facebook"] ):?>	
		<li><a href="<?php echo $actual_play_settings["actualplay_facebook"]; ?>"><span class="fa fa-facebook-official" aria-hidden="true"></span></a></li>
	<?php endif;
	if( $actual_play_settings["actualplay_twitter"] ):?>	
		<li><a href="<?php echo $actual_play_settings["actualplay_twitter"]; ?>"><span class="fa fa-twitter" aria-hidden="true"></span></a></li>
	<?php endif;
	if( $actual_play_settings["actualplay_youtube"] ):?>	
		<li><a href="<?php echo $actual_play_settings["actualplay_youtube"]; ?>"><span class="fa fa-youtube" aria-hidden="true"></span></a></li>
	<?php endif; 
	if( $actual_play_settings["actualplay_email"] ):?>	
		<li><a href="<?php echo $actual_play_settings["actualplay_email"]; ?>"><span class="fa fa-envelope" aria-hidden="true"></span></a></li>
	<?php endif; ?>
	</ul>
<?php

}

function performers_footer(){
	if( class_exists('TwitterOAuth') ) {
		$performers = json_decode( get_post_meta( get_the_ID(), 'podcast_performers', true ) );
	
		$connection = null;
		$content = null;
	
			if( $performers != null && is_single() ){
	
				?><div class="performers"><?php
	
				foreach( $performers as $performer ){
	
					$screen_name = get_user_meta( $performer, 'twitterHandle', true);
	
						$actual_play_settings = get_option( 'actualplay_settings' );
	
						if( $connection == null ){
	
							// and make our twitter connection
							$connection = new TwitterOAuth(
								$actual_play_settings['twitter_consumer_key'], 
								$actual_play_settings['twitter_consumer_secret'], 
								$actual_play_settings['twitter_oath_access_token'], 
								$actual_play_settings['twitter_oath_access_token_secret']
							);
					
							$content = $connection->get("account/verify_credentials");
	
					}
	
					if( $screen_name != null ){
	
						$info = $connection->get("users/show", ["screen_name"=> $screen_name ]);
	
						$user = get_userdata( $performer );							
						
						$profile_pic = $info->profile_image_url_https;
	
						?>
							<div class="performer">
								<h3><?php echo $user->display_name; ?></h3>						
								<img src="<?php echo $profile_pic; ?>" alt="">
								<a class="twitter-follow-button"
								href="https://twitter.com/<?php echo $screen_name; ?>"
								data-show-count="false"
								data-size="large">
								Follow @<?php echo $screen_name; ?></a>
						</div>
					<?php
				}
			}
		?></div><?php
		}
	}
}

function subscribe_links(){
	$powerpress_settings = false;

	if( function_exists( 'powerpresssubscribe_get_settings' ) ){
		$powerpress_settings = powerpresssubscribe_get_settings( $ExtraData, false );
	}
	
	$actual_play_settings = get_option( 'actualplay_settings' );

	$itunes_url = false;
	$google_play_url = false;

	// set itunes url
	if( isset($actual_play_settings["actualplay_itunes"] )){
		$itunes_url = $actual_play_settings["actualplay_itunes"];
	}

	if ( $powerpress_settings && $powerpress_settings['itunes_url'] != '' ){
		$itunes_url = $powerpress_settings['itunes_url'];
	}

	// set google play url
	if( isset($actual_play_settings["actualplay_google_play"] )){
		$google_play_url = $actual_play_settings["actualplay_google_play"];
	}

	if ( $powerpress_settings && $powerpress_settings['google_play_url'] != '' ){
		$google_play_url = $powerpress_settings['google_play_url'];
	}

	if( $itunes_url || $google_play_url) {
		echo '<span class="subscribe-links">';
	}

	if( $itunes_url ) {
		echo '<a class="apple" href="'.$itunes_url.'">Open in Apple Podcasts</a>';
	}

	if( $google_play_url) {
		echo '<a class="google" href="'.$google_play_url.'">Open in Google Play</a>';
	}

	if( $itunes_url || $google_play_url) {
		echo '</span>';
	}
}