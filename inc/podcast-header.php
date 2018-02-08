<?php

/*
 * Expects the following parameters
 *
 * string post type 
 * int post id
 * boolean is_home
 *
 */

function actualplay_get_post_header_and_meta( $post_type, $post_id, $is_home ){ 

	// this checks to see if this will be formatted like a podcast episode
	if( has_post_thumbnail() && powerpress_get_enclosure_data( get_the_ID() ) ): 

		?><header class="entry-header" <?php if(has_post_thumbnail() ) : ?>style="background-image: url(<?php echo the_post_thumbnail_url( 'full' ); ?>);"<?php endif;?>>
			<div class="entry-header-content">
			<?php

			if ( 'post' === $post_type ) : ?>

			<div class="entry-meta">
				<?php 
					$EpisodeData = powerpress_get_enclosure_data( get_the_ID() );
					the_powerpress_content(); ?>
				<span class="meta-info">
					<span><a href="<?php echo $EpisodeData['url']; ?>">Download Episode</a></span>
					<span>Episode Length: <?php echo $EpisodeData['duration']; ?></span>				
					<?php actual_play_posted_on(); ?>				
				</span>
			</div><!-- .entry-meta -->



			<?php
			endif; ?>
			</div>
		</header><!-- .entry-header -->


	<?php 

		return;	
		endif; ?>


<?php
	
}