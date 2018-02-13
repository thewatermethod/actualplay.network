<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package actual-play
*/


$actual_play_settings = get_option( 'actualplay_settings' );

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'actual-play' ); ?></a>

	<header id="masthead" class="site-header" role="banner">

		<!-- here is the title text for the screen readers -->
		<?php if ( is_front_page() && is_home() ) : ?>
			<h1 class="site-title screen-reader-text"><?php bloginfo( 'name' ); ?></h1>
		<?php else : ?>
			<p class="site-title screen-reader-text"><?php bloginfo( 'name' ); ?></p>
		<?php
		endif; ?>
		<!-- Ends screen reader texts-->



		<!-- This is the wrapper for the header workings -->
		<div class="site-branding">

			<!-- -Hamburger Menu -->

			<span class="fa fa-bars nav-toggle" aria-hidden="true" id="nav-toggle"></span>


			<!-- Logo Image --> 

			<?php // this function is badly named "get_header_image" but really seeks out the logo
				if ( get_header_image() ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
					</a>
			<?php endif; // End header image check. ?>

	
			<!-- Social Media Icons -->
			
			<ul class="sharing-links">
				<?php
				if( $actual_play_settings["actualplay_rss"]):?>
					<li><a href="<?php echo $actual_play_settings["actualplay_rss"]; ?>"><span class="fa fa-rss" aria-hidden="true"></span></a></li>
				<?php endif;?>
				<?php if( $actual_play_settings["actualplay_rss"] ):?>
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
				
		</div><!-- .site-branding -->


		<nav id="site-navigation" class="main-navigation" role="navigation">
			<span id="nav-close" class="nav-close">Close</span>

			<?php if ( get_header_image() ) : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
				</a>
			<?php endif; 

			
			
			// End header image check. ?>

			<?php 

				wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) );
				
				if ( is_active_sidebar( 'home-sidebar' ) ) {
					dynamic_sidebar( 'home-sidebar' ); 
				}

			?>		
			
		</nav><!-- #site-navigation -->


	</header><!-- #masthead -->

	<div id="content" class="site-content">


