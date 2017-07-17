<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package actual-play
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header" <?php if(has_post_thumbnail() ) : ?>style="background-image: url(<?php echo the_post_thumbnail_url( 'full' ); ?>);"<?php endif;?>>
		<div class="entry-header-content">
		<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}

		if ( 'post' === get_post_type() ) : ?>
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

	<div class="entry-content">

		<?php

			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'actual-play' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'actual-play' ),
				'after'  => '</div>',
			) );
		?>

	<?php if( in_category('podcasts') ) :?>
		
		<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-4' ); ?>		
		</div><!-- #primary-sidebar -->
	
	<?php elseif ( is_active_sidebar( 'sidebar-2' ) ) : ?>
		<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		</div><!-- #primary-sidebar -->
	<?php endif; ?>	

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php actual_play_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
