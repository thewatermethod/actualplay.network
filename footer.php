<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package actual-play
 */

?>

	</div><!-- #content -->
</div><!-- #page -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
		
		<?php if( !has_nav_menu('footer') ) : ?>
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'actual-play' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'actual-play' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			Privacy policy
			<span class="sep"> | </span>
			Site Resources
			<span class="sep"> | </span>
			Theme crafted in the <a href="http://www.twilitgrotto.com">Twilit Grotto</a>	
		<?php else : ?>

			<?php

				$footer_menu_args = array(
					'theme_location' => 'footer',
					'link_after' => '<span class="sep"> | </span>'
				);

				wp_nav_menu($footer_menu_args);

			?>

		<?php endif; ?>	
		</div><!-- .site-info -->
	</footer><!-- #colophon -->


<?php wp_footer(); ?>

</body>
</html>
