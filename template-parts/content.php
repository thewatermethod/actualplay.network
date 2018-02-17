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

<?php if (function_exists('powerpress_get_enclosure_data')) :?>
	<?php actualplay_get_post_header_and_meta( get_post_type() , get_the_ID(), true ); ?>	
<?php endif; ?>

	<div class="entry-content">

		<?php

			if( is_single() ){
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			}
			
//			$wp_kses = wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'actual-play' ), array( 'span' => array( 'class' => array() ) ) );

//			if( in_category('podcasts') ){
				$wp_kses = wp_kses( __( 'Show notes %s <span class="meta-nav">&rarr;</span>', 'actual-play' ), array( 'span' => array( 'class' => array() ) ) );	
//			}

			the_content( sprintf(
				/* translators: %s: Name of current post. */
				$wp_kses,
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
