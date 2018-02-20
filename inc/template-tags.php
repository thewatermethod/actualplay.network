<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package actual-play
 */

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

	include_once 'keys.php';

	// TODO: Figure out how to test this locally

	//Display the performer twitter info
	// $url = 'https://api.twitter.com/1.1/users/show.json';
	// $postfields = array(
	// 	'screen_name' => 'pizzapranks', 		
	// );

	// $twitter = new TwitterAPIExchange($twitter_api_settings);
	// echo $twitter->buildOauth($url, 'GET')
    // 	->setPostfields($postfields)
    // 	->performRequest();


	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
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
