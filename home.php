<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package actual-play
 */

get_header(); ?>

	<div id="primary" class="content-area">	

		<?php	

		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php
			endif;

			$post_int = 0;
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				if( $post_int === 0 || $post_int == 1){
					
					echo "<div class='row'>";

				}
			 		
			 	$bg = '';	
			 	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
			 	if( $image != ''){
			 		$bg = 'style="background-image: url('.$image[0].');"';
			 	}
			 	?>
				<article id="post-<?php the_ID(); ?>" <?php post_class($post_int); echo $bg; ?>>

					<div class="article-wrap" <?php if($post_int ===0): echo 'id="hero"'; endif;?> >
						<header class="entry-header">
							<?php
								if ( is_single() ) {
									the_title( '<h1 class="entry-title">', '</h1>' );
								} else {
									the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
								}

							 ?>
						</header><!-- .entry-header -->
						<div class="entry-meta">
							<?php the_powerpress_content(); ?>						
						</div><!-- .entry-meta -->

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
						</div><!-- .entry-content -->

						<footer class="entry-footer">
							<?php //actual_play_entry_footer(); ?>
						</footer><!-- .entry-footer -->

					</div>
				</article><!-- #post-## -->

				
<?php
			if( $post_int === 0 || $post_int % 2 == 0){
					echo "</div>";
				}
			$post_int++;
			endwhile;


		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

	
	</div><!-- #primary -->

<?php

get_footer();
