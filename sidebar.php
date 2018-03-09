<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package actual-play
 */

if ( !is_active_sidebar( 'sidebar-1' ) // Generic Sidebar
	&& !is_active_sidebar( 'sidebar-2' ) // Posts Sidebar
	&& !is_active_sidebar( 'sidebar-3' ) // Page Sidebar
	&& !is_active_sidebar( 'sidebar-4' ) ) { //Podcasts Category Sidebar
	return;
}
?>

	
<?php if ( is_active_sidebar( 'sidebar-2' ) && !is_page() ) : ?>

	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	</div><!-- #primary-sidebar -->

<?php endif; ?>	

<?php if( is_active_sidebar( 'sidebar-3' ) && is_page() ) :?>
	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-3' ); ?>
	</div><!-- #primary-sidebar -->

<?php endif; ?>

<?php 

if ( !is_active_sidebar( 'sidebar-2' ) // Posts Sidebar
	&& !is_active_sidebar( 'sidebar-3' ) // Page Sidebar
	&& !is_active_sidebar( 'sidebar-4' ) ) { //Podcasts Category Sidebar )
?>
	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- #primary-sidebar -->
<?php

}