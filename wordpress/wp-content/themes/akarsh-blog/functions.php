<?php
/**
 * Akarsh Blog functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Akarsh_Blog
 * @since Akarsh Blog 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Akarsh Blog 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

if ( ! function_exists( 'akarsh_blog_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Akarsh Blog 1.0
 */
function akarsh_blog_setup() {

	$default_settings = akarsh_blog_default_settings();
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/akarsh_blog
	 * If you're building a theme based on akarsh_blog, use a find and replace
	 * to change 'akarsh-blog' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'akarsh-blog' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

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
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1000, 500, false );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'akarsh-blog' ),
		
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'video', 'quote', 'gallery', 'audio'
	) );

	/*
	 * Enable support for custom logo.
	 *
	 * @since Akarsh Blog 1.5
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 248,
		'width'       => 248,
		'flex-height' => true,
	) );	


	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	
	add_editor_style();

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );

}
endif; // akarsh_blog_setup
add_action( 'after_setup_theme', 'akarsh_blog_setup' );

/**
 * Register widget area.
 *
 * @since Akarsh Blog 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function akarsh_blog_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'akarsh-blog' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'akarsh-blog' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'akarsh_blog_widgets_init' );

if ( ! function_exists( 'akarsh_blog_fonts_url' ) ) :
/**
 * Register Google fonts for Akarsh Blog.
 *
 * @since Akarsh Blog 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function akarsh_blog_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Roboto: on or off', 'akarsh-blog' ) ) {
		$fonts[] = 'Roboto:300,400';
	}	

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'akarsh-blog' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Akarsh Blog 1.1
 */
function akarsh_blog_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'akarsh_blog_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 *
 * @since Akarsh Blog 1.0
 */
function akarsh_blog_scripts() {
	
	$site_gf_fonts = array();
	
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'akarsh-blog-fonts', akarsh_blog_fonts_url(), array(), null );	

	// Load our main stylesheet.
	wp_enqueue_style( 'akarsh-blog-style', get_stylesheet_uri() );
	
	// Font Awesome CSS
	wp_register_style( 'font-awesome',  get_template_directory_uri() . '/assets/css/font-awesome.min.css', array());
	wp_enqueue_style( 'font-awesome' );
	
	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'akarsh-blog-ie', get_template_directory_uri() . '/assets/css/ie.css', array( 'akarsh_blog-style' ), '20141010' );
	wp_style_add_data( 'akarsh-blog-ie', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'akarsh-blog-ie7', get_template_directory_uri() . '/assets/css/ie7.css', array( 'akarsh_blog-style' ), '20141010' );
	wp_style_add_data( 'akarsh-blog-ie7', 'conditional', 'lt IE 8' );

	wp_enqueue_script( 'akarsh-blog-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20141010', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'akarsh-blog-keyboard-image-navigation', get_template_directory_uri() . '/assets/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}

	wp_enqueue_script( 'akarsh-blog-script', get_template_directory_uri() . '/assets/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'akarsh-blog-script', 'akarsh_blog_screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'akarsh-blog' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'akarsh-blog' ) . '</span>',
	) );	
	
		
}
add_action( 'wp_enqueue_scripts', 'akarsh_blog_scripts' );


/**
 * Add featured image as background image to post navigation elements.
 *
 * @since Akarsh Blog 1.0
 *
 * @see wp_add_inline_style()
 */
function akarsh_blog_post_nav_background() {
	if ( ! is_single() ) {
		return;
	}

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$css      = '';

	if ( is_attachment() && 'attachment' == $previous->post_type ) {
		return;
	}

	if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
		$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . '); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	if ( $next && has_post_thumbnail( $next->ID ) ) {
		$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . '); border-top: 0; }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	wp_add_inline_style( 'akarsh_blog-style', $css );
}
add_action( 'wp_enqueue_scripts', 'akarsh_blog_post_nav_background' );

/**
 * Display descriptions in main navigation.
 *
 * @since Akarsh Blog 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function akarsh_blog_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'akarsh_blog_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Akarsh Blog 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function akarsh_blog_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'akarsh_blog_search_form_modify' );

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since Akarsh Blog 1.9
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function akarsh_blog_widget_tag_cloud_args( $args ) {
	$args['largest']  = 22;
	$args['smallest'] = 8;
	$args['unit']     = 'pt';
	$args['format']   = 'list';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'akarsh_blog_widget_tag_cloud_args' );


/**
 * Implement the Custom Header feature.
 *
 * @since Akarsh Blog 1.0
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Akarsh Blog 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Akarsh Blog 1.0
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Customizer additions.
 *
 * @since Akarsh Blog 1.0
 */
require get_template_directory() . '/inc/akarshblog-functions.php';
require get_template_directory() . '/inc/akarshblog-theme-css.php';


/**
 * Load dashboard
 */
require get_template_directory() . '/inc/dashboard/class-akarsh-blog-dashboard.php';
$dashboard = new akarsh_blog_dashboard;