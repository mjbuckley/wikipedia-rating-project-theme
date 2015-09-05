<?php
/**
 * Wikipedia Rating Project Theme functions and definitions
 *
 * @package wrp-theme
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'wrp_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wrp_theme_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Wikipedia Rating Project Theme, use a find and replace
	 * to change 'wrp-theme' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'wrp-theme', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'wrp-theme' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'wrp_theme_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // wrp_theme_setup
add_action( 'after_setup_theme', 'wrp_theme_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function wrp_theme_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'wrp-theme' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'wrp_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wrp_theme_scripts() {
	wp_enqueue_style( 'wrp-theme-style', get_stylesheet_uri() );

	wp_enqueue_style( 'wrp-theme-google-fonts', 'http://fonts.googleapis.com/css?family=Lato:400,700,700italic|Lora:400,700,400italic' );

	wp_enqueue_style( 'wrp-theme-fontawesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );

	wp_enqueue_script( 'wrp-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'wrp-theme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wrp_theme_scripts' );

// Add a login/out link at end of nav menu in primary menu location.
// There should is a cleaner way to do this, but I can't get it working, and this is fine.
function wrp_theme_add_loginout( $menu, $args ) {
	if ($args->theme_location == 'primary') {
    $loginout = '<li class="menu-item">' . wp_loginout($_SERVER['REQUEST_URI'], false ) . '</li>';
    $menu .= $loginout;
    return $menu;
   }
}
add_filter( 'wp_nav_menu_items','wrp_theme_add_loginout', 10, 2 );

// Include wrp_review post_type on author archive pages
// NOT SURE IF REMOVE ACTION is really needed or not
// is_admin() check needed or else this will mess with the post edit screen
// Set to show 20 reviews rather than typical 10, plus only show reviews, not posts/pages
function wrp_theme_fix_author_archive($query) {
  if ( !is_admin() && $query->is_author) {
    $query->set( 'post_type', array('wrp_review') );
    $query->set( 'posts_per_page', 20 );
    remove_action( 'pre_get_posts', 'wrp_theme_fix_author_archive' );
  }
}
add_action('pre_get_posts', 'wrp_theme_fix_author_archive');

function wrp_theme_remove_wp_logo( $wp_admin_bar ) {
  $wp_admin_bar->remove_node( 'wp-logo' );
}
add_action( 'admin_bar_menu', 'wrp_theme_remove_wp_logo', 999 );


// Grabbed this code for replacing the howdy greeting.  Works, feel like there should be a better way.
function wrp_theme_replace_howdy( $wp_admin_bar ) {
  $my_account=$wp_admin_bar->get_node('my-account');
  $newtitle = str_replace( 'Howdy,', 'Welcome,', $my_account->title );
  $wp_admin_bar->add_node( array(
    'id' => 'my-account',
    'title' => $newtitle,
    )
  );
}
add_filter( 'admin_bar_menu', 'wrp_theme_replace_howdy', 25 );


// Prepopulate theme with default pages on theme activation.  Only adds pages if they don't already exist, so nothing
// gets overwritten.  They can also always be removed by user, but the idea is to have a fully functioning site out of the box.
function wrp_theme_create_pages() {

  $page_check = get_page_by_title( 'Disciplines' ); // Returns page object if exists, null if not
  $new_page = array(
    'post_type' => 'page', 
    'post_title' => 'Disciplines',
    'post_content' => 'All reviews sorted by discipline:',
    'post_status' => 'publish',
  );
  if( is_null( $page_check ) ) { // Only createspage if it doesn't already exist.
    wp_insert_post( $new_page );
  }

  $page_check = get_page_by_title( 'Ratings' );
  $new_page = array(
    'post_type' => 'page', 
    'post_title' => 'Ratings',
    'post_content' => 'All reviews sorted by rating:',
    'post_status' => 'publish',
  );
  if( is_null( $page_check ) ) {
    wp_insert_post( $new_page );
  }

  $page_check = get_page_by_title( 'Titles' );
  $new_page = array(
    'post_type' => 'page', 
    'post_title' => 'Titles',
    'post_content' => 'All reviews sorted by title:',
    'post_status' => 'publish',
  );
  if( is_null( $page_check ) ) {
    wp_insert_post( $new_page );
  }

  $page_check = get_page_by_title( 'About' );
  $new_page = array(
    'post_type' => 'page', 
    'post_title' => 'About',
    'post_content' => "The text on this page can be edited by going to the Pages section in the Dashboard.  This would be a good place to explain the purpose of the site and to include some contact information.  You might consider mentioning and including a link to <a href='http://mjbuckley.github.io/wikipedia-rating-project'>The Wikipedia Rating Project.</a>",
    'post_status' => 'publish',
  );
  if( is_null( $page_check ) ) {
    wp_insert_post( $new_page );
  }

  $site_title = get_bloginfo();
  if ( ! empty( $site_title ) ) {
    $page_check = get_page_by_title( $site_title );
    $new_page = array(
      'post_type' => 'page', 
      'post_title' => $site_title,
      'post_content' => "This site allows users to rate the quality of Wikipedia articles.  It is built with tools from <a href='http://mjbuckley.github.io/wikipedia-rating-project'>The Wikipedia Rating Project.</a>  The text on this page can be edited by going to the Pages section in the Dashboard.",
      'post_status' => 'publish',
    );
    if( is_null( $page_check ) ) {
      $site_title_page = wp_insert_post( $new_page );

      if ( $site_title_page && ! is_wp_error( $site_title_page ) ) { // set as home page
        update_option( 'page_on_front', $site_title_page );
        update_option( 'show_on_front', 'page' );
      }  
    } else { // Page already exist. Don't modify content, but set as front page
      update_option( 'page_on_front', $page_check->ID );
      update_option( 'show_on_front', 'page' );
    }
  }
}
add_action( 'after_switch_theme', 'wrp_theme_create_pages' );


// Create and prepopulate a default nav menu.
function wrp_theme_create_menu() {

  // Check if the menu exists
  $menu_name = 'Primary Menu';
  $menu_exists = wp_get_nav_menu_object( $menu_name );

  // If it doesn't exist, let's create it.
  if( ! $menu_exists ) {
    $menu_id = wp_create_nav_menu( $menu_name );

    // Set up default menu items
    $reviews_menu = wp_update_nav_menu_item( $menu_id, 0, array(
      'menu-item-title' =>  'Reviews',
      'menu-item-url' => home_url( '/#' ),
      'menu-item-parent-id' => 0,
      'menu-item-status' => 'publish'));

      // Drop downs for the home menu
      wp_update_nav_menu_item( $menu_id, 0, array(
        'menu-item-title' =>  'View by title',
        'menu-item-url' => home_url( '/titles/' ),
        'menu-item-parent-id' => $reviews_menu,
        'menu-item-status' => 'publish'));

      wp_update_nav_menu_item( $menu_id, 0, array(
        'menu-item-title' =>  'View by rating',
        'menu-item-url' => home_url( '/ratings/' ),
        'menu-item-parent-id' => $reviews_menu,
        'menu-item-status' => 'publish'));

      wp_update_nav_menu_item( $menu_id, 0, array(
        'menu-item-title' =>  'View by discipline',
        'menu-item-url' => home_url( '/disciplines/' ),
        'menu-item-parent-id' => $reviews_menu,
        'menu-item-status' => 'publish'));

      wp_update_nav_menu_item( $menu_id, 0, array(
        'menu-item-title' =>  'All reviews',
        'menu-item-url' => home_url( '/reviews/' ),
        'menu-item-parent-id' => $reviews_menu,
        'menu-item-status' => 'publish'));

    wp_update_nav_menu_item( $menu_id, 0, array(
      'menu-item-title' =>  'About',
      'menu-item-url' => home_url( '/about/' ), 
      'menu-item-status' => 'publish'));

    wp_update_nav_menu_item( $menu_id, 0, array(
      'menu-item-title' =>  'Home',
      'menu-item-classes' => 'home',
      'menu-item-url' => home_url( '/' ), 
      'menu-item-status' => 'publish'));
  }

  // place the new menu in correct location
  $locations = get_theme_mod( 'nav_menu_locations' );
  $locations['primary'] = $menu_name;
  set_theme_mod( 'nav_menu_locations', $locations );

}
add_action( 'after_switch_theme', 'wrp_theme_create_menu' );


/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

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