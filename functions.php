<?php
/**
 * actual-play functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package actual-play
 */

if ( ! function_exists( 'actual_play_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function actual_play_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on actual-play, use a find and replace
	 * to change 'actual-play' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'actual-play', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	
	require_once 'inc/class-performer.php';
	Podcast_Performer::init();

	require_once 'inc/class-theme-settings-page.php';
	Podcast_SettingsPage::init();

	// TODO: Create custom game taxonomy


	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'actual-play' ),
		'footer' => esc_html__('Footer', 'actual-play')
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	add_theme_support( 'post-thumbnails' );
	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'actual_play_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

}

endif;

add_action( 'after_setup_theme', 'actual_play_setup' );

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

	// this grabs the fonts for the everything is true pages
	if( in_category( 'everything-is-true' ) ){
		wp_enqueue_style('everything-is-true-fonts', 'https://fonts.googleapis.com/css?family=Metal+Mania|New+Rocker' );
	}

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


/**
 * Disable emojis.
 */

function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}

add_action( 'init', 'disable_emojis' );


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

function featuredtoRSS( $content ) {
	global $post;

	if ( has_post_thumbnail( $post->ID ) ){
		$content = '' . get_the_post_thumbnail( $post->ID, 'thumbnail', array( 'style' => 'float:left; margin:0 15px 15px 0;' ) ) . '' . $content;
	}
	return $content;
}
	
add_filter('the_excerpt_rss', 'featuredtoRSS');
add_filter('the_content_feed', 'featuredtoRSS');