<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * actual-play functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package actual-play
 */

require_once 'inc/class-actual-play-theme.php';
Actual_Play_Theme::init();



/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function actual_play_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'actual_play_content_width', 640 );
}
add_action( 'after_setup_theme', 'actual_play_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function actual_play_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Menu Widget Area', 'actual-play' ),
		'id'            => 'home-sidebar',
		'description'   => esc_html__( 'This displays below the sharing links in the main menu and on the home page', 'actual-play' ),
		'before_widget' => '<div class="menu-callout widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<span style="display: none;">',
		'after_title'   => '</span>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'actual-play' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Below all other sidebars, posts and pages.', 'actual-play' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Posts Sidebar', 'actual-play' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Below all content, posts only', 'actual-play' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Below all content pages only', 'actual-play' ),
		'id'            => 'sidebar-3',
		'description'   => esc_html__( 'Add widgets here.', 'actual-play' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Podcasts Sidebar', 'actual-play' ),
		'id'            => 'sidebar-4',
		'description'   => esc_html__( 'After content, before posts navigation, only on "Podcasts" category', 'actual-play' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( '404 Page Content', 'actual-play' ),
		'id'            => '404-page-content',
		'description'   => esc_html__( 'Add widgets here.', 'actual-play' ),
		'before_widget' => '<section class="error-404 not-found">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<header class="page-header"><h1 class="page-title">',
		'after_title'   => '</header></h1><div class="page-content">',
	) );	
}
add_action( 'widgets_init', 'actual_play_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function actual_play_scripts() {
	
	// Let's not even bother
	//wp_deregister_script( 'jquery' );
	// TODO - infinite scroll without jetpack/remove jetpack completely
	// we really want this site to scrape the bare metals

	//wp_deregister_style('dashicons');

	//here's the various javascripts for the webpage	
	wp_enqueue_style( 'actual-play-style', get_template_directory_uri() . '/min/style.css' );
	wp_enqueue_script( 'actual-play-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	
	//wp_enqueue_script( 'twitter-for-websites', 'https://platform.twitter.com/widgets.js', array(), '20151215', true );
	
	wp_enqueue_script( 'actual-play-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'actual_play_scripts' );

function actual_play_admin_scripts(){
	//wp_enqueue_script( 'stats', get_template_directory_uri() . '/dist/bundle.js', array(), wp_rand(1,99), true );
	//wp_enqueue_script( 'vue', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js' );
}

add_action( 'admin_enqueue_scripts', 'actual_play_admin_scripts');


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Custom post header/meta
 */
require get_template_directory() . '/inc/podcast-header.php';


/**
 * Allow SVG upload
 */

function apn_cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'apn_cc_mime_types');

/**
 * Add category names to body classes
 */

function apn_add_category_name($classes = '') {
   if(is_single()) {
      $category = get_the_category();
      $classes[] = 'category-'.$category[0]->slug; 
   }
   return $classes;
}
add_filter('body_class','apn_add_category_name');

/**
 * Custom css compilation
 */
require get_template_directory() . '/inc/css.php';

