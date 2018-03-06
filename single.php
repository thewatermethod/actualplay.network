<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package actual-play
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );?>

			<?php
			
			$previous_post = get_previous_post();
			$next_post = get_next_post(); ?>

			<nav class="navigation post-navigation" role="navigation">
				<h2 class="screen-reader-text">Post navigation</h2>
				<div class="nav-links">
					<?php if( $previous_post != null) :?>
						<?php $previous_post_link =  get_permalink( $previous_post->ID);?>
						<?php $featured_image = get_the_post_thumbnail_url( $previous_post->ID);?>
						<div class="nav-previous"
							<?php if($featured_image): ?>
								style="background-image: url(<?php echo $featured_image; ?>);"
							<?php endif;?>>
							<a href="<?php echo $previous_post_link; ?>" rel="prev">
								<span><?php echo $previous_post->post_title; ?></span>
							</a>
						</div>
					<?php endif; ?>
					<?php if( $next_post != null ) : ?>
						<?php $next_post_link =  get_permalink( $next_post->ID);  ?>
						<?php $featured_image = get_the_post_thumbnail_url( $next_post->ID);?>
						<div class="nav-next"
							<?php if($featured_image): ?>
								style="background-image: url(<?php echo $featured_image; ?>);"
							<?php endif;?>>
							<a href="<?php echo $next_post_link; ?>" rel="next">
								<span><?php echo $next_post->post_title; ?></span>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</nav>

			<?php

			get_sidebar();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();
