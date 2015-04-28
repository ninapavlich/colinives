<?php
/**
 * Twenty Fifteen functions and definitions
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
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Twenty Fifteen 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

/**
 * Twenty Fifteen only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'twentyfifteen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on twentyfifteen, use a find and replace
	 * to change 'twentyfifteen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'twentyfifteen', get_template_directory() . '/languages' );

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
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'twentyfifteen' ),
		'social'  => __( 'Social Links Menu', 'twentyfifteen' ),
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
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = twentyfifteen_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'twentyfifteen_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', twentyfifteen_fonts_url() ) );
}
endif; // twentyfifteen_setup
add_action( 'after_setup_theme', 'twentyfifteen_setup' );

/**
 * Register widget area.
 *
 * @since Twenty Fifteen 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function twentyfifteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'twentyfifteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentyfifteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentyfifteen_widgets_init' );

if ( ! function_exists( 'twentyfifteen_fonts_url' ) ) :
/**
 * Register Google fonts for Twenty Fifteen.
 *
 * @since Twenty Fifteen 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function twentyfifteen_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Sans font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Sans:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Serif, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Serif font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Serif:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Inconsolata, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Inconsolata:400,700';
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'twentyfifteen' );

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
		), '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Fifteen 1.1
 */
function twentyfifteen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyfifteen_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyfifteen-fonts', twentyfifteen_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'twentyfifteen-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie7', 'conditional', 'lt IE 8' );

	wp_enqueue_script( 'twentyfifteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20141010', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentyfifteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}

	wp_enqueue_script( 'twentyfifteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'twentyfifteen-script', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'twentyfifteen' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'twentyfifteen' ) . '</span>',
	) );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_scripts' );

/**
 * Add featured image as background image to post navigation elements.
 *
 * @since Twenty Fifteen 1.0
 *
 * @see wp_add_inline_style()
 */
function twentyfifteen_post_nav_background() {
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

	wp_add_inline_style( 'twentyfifteen-style', $css );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_post_nav_background' );

/**
 * Display descriptions in main navigation.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function twentyfifteen_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'twentyfifteen_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function twentyfifteen_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'twentyfifteen_search_form_modify' );

/**
 * Implement the Custom Header feature.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/customizer.php';


/* CUSTOM */
/**
* modified by nina@ninalp.com
*/

function populateProjectData($post){
	//apply custom fields to objects:
	$post->sort_order = get_field('sort_order');
	$post->display_title = get_field('display_title');

	$taxonomy = "projectgroup";
	$terms = wp_get_post_terms( get_the_ID(), $taxonomy );
	$pg_term = $terms[0];
	$post->project_group_slug = $pg_term->slug;
	$post->project_name = $pg_term->name;

	//GET LAYOUT AND POPULATE CUSTOM DATA:
	$taxonomy = "projectpageformats";
	$format_terms = wp_get_post_terms( get_the_ID(), $taxonomy );
	$format_term = $format_terms[0];
	$post->layout_type = $format_term->slug;

	$post->url = '/'.$post->project_group_slug.'/'.$post->post_name;

	switch($post->layout_type){
		case 'image-and-text':					
			$project_image = wp_get_attachment_image_src(get_field('project_image'), 'full');	
			$project_image_title = get_the_title(get_field('project_image'));
			$post->image_title = $project_image_title;
			$post->image_source = $project_image[0];
			$post->description = get_field('project_description');
		break;
		case 'image-gallery':
			$gallery_elements = get_field('gallery_element');
			$gallery_output = array();
			
			$len = count($gallery_elements);
			for ($k = 0; $k < $len; $k++) {
				

				$gallery_element = $gallery_elements[$k];						
				$thumbnail_id = $gallery_element['thumbnail'];
				$thumbnail_image = wp_get_attachment_image_src($thumbnail_id, 'full');	
				$thumbnail_title = get_the_title($thumbnail_id);
				$gallery_element['thumbnail_image'] = $thumbnail_image[0];
				$gallery_element['thumbnail_title'] = $thumbnail_title;


				$full_image_id = $gallery_element['image'];
				$full_image = wp_get_attachment_image_src($full_image_id, 'full');	
				$full_image_title = get_the_title($full_image_id);

				$gallery_element['full_image'] = $full_image[0];
				$gallery_element['full_image_title'] = $full_image_title;

				$gallery_output[$k] = $gallery_element;
				
			}

			$post->gallery_elements = $gallery_output;


		break;
		case 'vimeo-video':
			$post->embed_width = get_field('embed_width'); 
			$post->embed_height = get_field('embed_height'); 
			$post->vimeo_id = get_field('vimeo_id');
		break;
		default:
			//ignore
		break;
	}
	return $post;
}

function projectSort( $projectA, $projectB ) {
	return $projectA->sort_order == $projectB->sort_order ? 0 : ( $projectA->sort_order > $projectB->sort_order ) ? 1 : -1;
}
function postSort( $postA, $postB ) {
	
	return $postA->sort_order == $postB->sort_order ? 0 : ( $postA->sort_order > $postB->sort_order ) ? 1 : -1;
}
function getCurrentProjectGroup() {
	global $post;
	$terms = get_the_terms($post->ID, 'projectgroup');
	
	if( (!empty($terms)) && count($terms) > 0){
		foreach( $terms as $term ) {
			return $term;
			unset($term); // Get rid of the other data stored in the object, since it's not needed
		}
	}
	return false;
}

function getGroupProjects($term_name='') {
	global $post;
	
	$output = array();
	if(!empty($term_name)){
		$args = array(
			'post_type' => 'projectpages',
			'tax_query' => array(
				array(
					'taxonomy' => 'projectgroup',
					'field' => 'slug',
					'terms' => $term_name
				)
			)
		);
	}else{
		$args = array(
			'post_type' => 'projectpages',
			'posts_per_page' => -1
		);
	}
	
	
	$menu_query = new WP_Query($args);					
	while ( $menu_query->have_posts() ) {			
		$menu_query->the_post();


		$post = get_post( get_the_ID() );
		
		$visible = get_field('visible');

		
		if ($visible != 'No') {
			
			$post = populateProjectData($post);

			array_push($output, $post);				
		}
		
		
	}
	
	
	//sort by sort order
	usort( $output, 'postSort' );

	
	// Restore original Post Data
	wp_reset_postdata();
	return $output;
}

function getProjectMenuItems(){
	
	
	$menuitems = array();
		
	
			
	
	//Get each taxonomy for 'projectpages'
	$terms = get_terms('projectgroup', 'hide_empty=0');
	$filtered_terms = array();
	
	//get custom sort order property and apply it to the object so we can sort this array
	foreach ( $terms as $term ) {
		
		$visible = get_field('visible', 'projectgroup_'.$term->term_id);
		
		if($visible != 'No'){
			$sort_order = get_field('sort_order', 'projectgroup_'.$term->term_id);
			$term->sort_order = $sort_order;
			array_push($filtered_terms, $term);
		}
	}
	
	//sort by sort order
	usort( $filtered_terms, 'projectSort' );
	

	
	$count = count($filtered_terms);
	$k = 0;
	foreach ( $filtered_terms as $term ) {
		
		$menuitem = new stdClass();

		$menuitem->name = $term->name;
		$menuitem->slug = $term->slug;
		$menuitem->id = $term->term_id;


		// //Get thumbnail data:
		$project_group = $menuitems[$k];
		$thumbnail_id = get_field('project_group_thumbnail', 'projectgroup_'.$term->term_id);
		$image = wp_get_attachment_image_src($thumbnail_id, 'full');	
		$thumbnail = wp_get_attachment_image_src($thumbnail_id, 'thumbnail');	
		
		$menuitem->thumbnail_image = $image[0];
		$menuitem->thumbnail_image_thumbnail = $thumbnail[0];
		$menuitem->thumbnail_title = get_the_title($thumbnail_id);
		
		// //Get Projects:
		$projects = getGroupProjects($term->name);
		$menuitem->projects = $projects;

		if(count($projects)>0){
			$menuitem->first_project = $projects[0];	
		}
		
		$menuitems[$k] = $menuitem;

		$k++;
		
	}
	
	return $menuitems;
}


function getSubMenuItems(){
	global $post;
	
	$current_group = getCurrentProjectGroup();
	return getGroupProjects($current_group->name);	
}