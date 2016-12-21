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
					Theme crafted in the <a href="http://www.twilitgrotto.com">Twilit Grotto</a>	
		<?php else : ?>

			<?php

				$footer_menu_args = array(
					'theme_location' => 'footer'
					
				);

				wp_nav_menu($footer_menu_args);

			?>

		<?php endif; ?>	
		</div><!-- .site-info -->
	</footer><!-- #colophon -->


<?php wp_footer(); ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-50120343-8', 'auto');
  ga('send', 'pageview');

</script>

</body>
</html>
