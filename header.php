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


	$actual_play_settings = get_option( 'actualplay_settings', "#" );

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
		<?php if ( !is_front_page() && !is_home() ) :  echo'<div class="branding-wrapper">';  endif;?>
			<div class="site-branding">
				<?php if ( get_header_image() ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
					</a>
				<?php endif; // End header image check. ?>

				<?php
				if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<p class="desc"><?php bloginfo('description'); ?></p>
					<ul class="sharing-links">
					<?php
					if( $actual_play_settings["actualplay_rss"] ):?>
						<li><a href="<?php echo $actual_play_settings["actualplay_rss"]; ?>"><i class="fa fa-rss" aria-hidden="true"></i></a></li>
					<?php endif;?>

					<?php if( $actual_play_settings["actualplay_itunes"] ):?>
						<li><a href="<?php echo $actual_play_settings["actualplay_itunes"]; ?>"><i class="fa fa-apple" aria-hidden="true"></i></a></li>
					<?php endif;


					if( $actual_play_settings["actualplay_soundcloud"] ):?>	
						<li><a href="<?php echo $actual_play_settings["actualplay_soundcloud"]; ?>"><i class="fa fa-soundcloud" aria-hidden="true"></i></a></li>
					<?php endif;	
					if( $actual_play_settings["actualplay_stitcher"] ):?>		
						<li><a href="<?php echo $actual_play_settings["actualplay_stitcher"]; ?>">Stitcher</a></li>
					<?php endif;
					if( $actual_play_settings["actualplay_facebook"] ):?>	
						<li><a href="<?php echo $actual_play_settings["actualplay_facebook"]; ?>"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
					<?php endif;
					if( $actual_play_settings["actualplay_twitter"] ):?>	
						<li><a href="<?php echo $actual_play_settings["actualplay_twitter"]; ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
					<?php endif; ?>
					</ul>

				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
				endif;

				?>
			</div><!-- .site-branding -->

			<i class="fa fa-bars" aria-hidden="true" id="nav-toggle"></i>

			<nav id="site-navigation" class="main-navigation" role="navigation">
				<span id="nav-close">Close</span>

				<?php if ( get_header_image() ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img id="hideOnHome" src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
					</a>
				<?php endif; 

				
				
				// End header image check. ?>

				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) );

					get_search_form();
				 ?>
			</nav><!-- #site-navigation -->


			<?php 
				if ( is_front_page() && is_home() ) : 
					dynamic_sidebar( 'home-sidebar' ); 
				endif;
			?>
		<?php if ( !is_front_page() && !is_home() ) :  echo'</div>';  endif;?>

		<?php if( is_front_page() || is_home() ): ?>

		<?php  

		$this_query = new WP_Query( array( 'category_name' => 'podcasts', 'posts_per_page' =>1 ) );

		while ( $this_query->have_posts() ) {
    		$this_query->the_post();
    		echo "<h2 class='callout'><a href='" . esc_url( get_permalink() ) . "'' rel='bookmark'>Listen to our newest episode here</a> or <a href='". $actual_play_settings["actualplay_itunes"]   ."'>subscribe on iTunes</a></h2>"; 
		}

		wp_reset_postdata();
		
		?>

		<?php endif; ?>

	</header><!-- #masthead -->

	<div id="content" class="site-content">


