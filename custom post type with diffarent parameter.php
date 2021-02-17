<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 */

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

/**
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {
    Container::make( 'theme_options', __( 'Theme Options' ) )
        ->add_fields( array(
            Field::make( 'text', 'crb_text', 'Text Field' ),
        ) );
}


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function twentyseventeen_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyseventeen
	 * If you're building a theme based on Twenty Seventeen, use a find and replace
	 * to change 'twentyseventeen' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentyseventeen' );

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
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'twentyseventeen-featured-image', 2000, 1200, true );

	add_image_size( 'twentyseventeen-thumbnail-avatar', 100, 100, true );

	// Set the default content width.
	$GLOBALS['content_width'] = 525;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus(
		array(
			'top'    => __( 'Top Menu', 'twentyseventeen' ),
			'social' => __( 'Social Links Menu', 'twentyseventeen' ),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
		)
	);

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://wordpress.org/support/article/post-formats/
	 */
	add_theme_support(
		'post-formats',
		array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'audio',
		)
	);

	// Add theme support for Custom Logo.
	add_theme_support(
		'custom-logo',
		array(
			'width'      => 250,
			'height'     => 250,
			'flex-width' => true,
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
	  */
	add_editor_style( array( 'assets/css/editor-style.css', twentyseventeen_fonts_url() ) );

	// Load regular editor styles into the new block-based editor.
	add_theme_support( 'editor-styles' );

	// Load default block styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		'widgets'     => array(
			// Place three core-defined widgets in the sidebar area.
			'sidebar-1' => array(
				'text_business_info',
				'search',
				'text_about',
			),

			// Add the core-defined business info widget to the footer 1 area.
			'sidebar-2' => array(
				'text_business_info',
			),

			// Put two core-defined widgets in the footer 2 area.
			'sidebar-3' => array(
				'text_about',
				'search',
			),
		),

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts'       => array(
			'home',
			'about'            => array(
				'thumbnail' => '{{image-sandwich}}',
			),
			'contact'          => array(
				'thumbnail' => '{{image-espresso}}',
			),
			'blog'             => array(
				'thumbnail' => '{{image-coffee}}',
			),
			'homepage-section' => array(
				'thumbnail' => '{{image-espresso}}',
			),
		),

		// Create the custom image attachments used as post thumbnails for pages.
		'attachments' => array(
			'image-espresso' => array(
				'post_title' => _x( 'Espresso', 'Theme starter content', 'twentyseventeen' ),
				'file'       => 'assets/images/espresso.jpg', // URL relative to the template directory.
			),
			'image-sandwich' => array(
				'post_title' => _x( 'Sandwich', 'Theme starter content', 'twentyseventeen' ),
				'file'       => 'assets/images/sandwich.jpg',
			),
			'image-coffee'   => array(
				'post_title' => _x( 'Coffee', 'Theme starter content', 'twentyseventeen' ),
				'file'       => 'assets/images/coffee.jpg',
			),
		),

		// Default to a static front page and assign the front and posts pages.
		'options'     => array(
			'show_on_front'  => 'page',
			'page_on_front'  => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set the front page section theme mods to the IDs of the core-registered pages.
		'theme_mods'  => array(
			'panel_1' => '{{homepage-section}}',
			'panel_2' => '{{about}}',
			'panel_3' => '{{blog}}',
			'panel_4' => '{{contact}}',
		),

		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus'   => array(
			// Assign a menu to the "top" location.
			'top'    => array(
				'name'  => __( 'Top Menu', 'twentyseventeen' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_about',
					'page_blog',
					'page_contact',
				),
			),

			// Assign a menu to the "social" location.
			'social' => array(
				'name'  => __( 'Social Links Menu', 'twentyseventeen' ),
				'items' => array(
					'link_yelp',
					'link_facebook',
					'link_twitter',
					'link_instagram',
					'link_email',
				),
			),
		),
	);

	/**
	 * Filters Twenty Seventeen array of starter content.
	 *
	 * @since Twenty Seventeen 1.1
	 *
	 * @param array $starter_content Array of starter content.
	 */
	$starter_content = apply_filters( 'twentyseventeen_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
}
add_action( 'after_setup_theme', 'twentyseventeen_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function twentyseventeen_content_width() {

	$content_width = $GLOBALS['content_width'];

	// Get layout.
	$page_layout = get_theme_mod( 'page_layout' );

	// Check if layout is one column.
	if ( 'one-column' === $page_layout ) {
		if ( twentyseventeen_is_frontpage() ) {
			$content_width = 644;
		} elseif ( is_page() ) {
			$content_width = 740;
		}
	}

	// Check if is single post and there is no sidebar.
	if ( is_single() && ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 740;
	}

	/**
	 * Filter Twenty Seventeen content width of the theme.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'twentyseventeen_content_width', $content_width );
}
add_action( 'template_redirect', 'twentyseventeen_content_width', 0 );

/**
 * Register custom fonts.
 */
function twentyseventeen_fonts_url() {
	$fonts_url = '';

	/*
	 * translators: If there are characters in your language that are not supported
	 * by Libre Franklin, translate this to 'off'. Do not translate into your own language.
	 */
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'twentyseventeen' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

		$query_args = array(
			'family'  => urlencode( implode( '|', $font_families ) ),
			'subset'  => urlencode( 'latin,latin-ext' ),
			'display' => urlencode( 'fallback' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function twentyseventeen_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'twentyseventeen-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'twentyseventeen_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentyseventeen_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Blog Sidebar', 'twentyseventeen' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'twentyseventeen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer 1', 'twentyseventeen' ),
			'id'            => 'sidebar-2',
			'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer 2', 'twentyseventeen' ),
			'id'            => 'sidebar-3',
			'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'twentyseventeen_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function twentyseventeen_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf(
		'<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Post title. */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'twentyseventeen_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function twentyseventeen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyseventeen_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function twentyseventeen_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'twentyseventeen_pingback_header' );

/**
* Display custom color CSS.
*/
 
function twentyseventeen_colors_css_wrap() {
	if ( 'custom' !== get_theme_mod( 'colorscheme' ) && ! is_customize_preview() ) {
		return;
	}

	require_once get_parent_theme_file_path( '/inc/color-patterns.php' );
	$hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );

	$customize_preview_data_hue = '';
	if ( is_customize_preview() ) {
		$customize_preview_data_hue = 'data-hue="' . $hue . '"';
	}
	?>
	<style type="text/css" id="custom-theme-colors" <?php echo $customize_preview_data_hue; ?>>
		<?php echo twentyseventeen_custom_colors_css(); ?>
	</style>
	<?php
}
add_action( 'wp_head', 'twentyseventeen_colors_css_wrap' );

/**
 * Enqueues scripts and styles.
 */
function twentyseventeen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyseventeen-fonts', twentyseventeen_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'twentyseventeen-style', get_stylesheet_uri(), array(), '20190507' );

	// Theme block stylesheet.
	wp_enqueue_style( 'twentyseventeen-block-style', get_theme_file_uri( '/assets/css/blocks.css' ), array( 'twentyseventeen-style' ), '20190105' );

	// Load the dark colorscheme.
	if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-colors-dark', get_theme_file_uri( '/assets/css/colors-dark.css' ), array( 'twentyseventeen-style' ), '20190408' );
	}

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'twentyseventeen-style' ), '20161202' );
		wp_style_add_data( 'twentyseventeen-ie9', 'conditional', 'IE 9' );
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'twentyseventeen-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'twentyseventeen-style' ), '20161202' );
	wp_style_add_data( 'twentyseventeen-ie8', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '20161020' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'twentyseventeen-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '20161114', true );

	$twentyseventeen_l10n = array(
		'quote' => twentyseventeen_get_svg( array( 'icon' => 'quote-right' ) ),
	);

	if ( has_nav_menu( 'top' ) ) {
		wp_enqueue_script( 'twentyseventeen-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array( 'jquery' ), '20161203', true );
		$twentyseventeen_l10n['expand']   = __( 'Expand child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['collapse'] = __( 'Collapse child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['icon']     = twentyseventeen_get_svg(
			array(
				'icon'     => 'angle-down',
				'fallback' => true,
			)
		);
	}

	wp_enqueue_script( 'twentyseventeen-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '20190121', true );

	wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );

	wp_localize_script( 'twentyseventeen-skip-link-focus-fix', 'twentyseventeenScreenReaderText', $twentyseventeen_l10n );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'twentyseventeen_scripts' );

/**
 * Enqueues styles for the block-based editor.
 *
 * @since Twenty Seventeen 1.8
 */
function twentyseventeen_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'twentyseventeen-block-editor-style', get_theme_file_uri( '/assets/css/editor-blocks.css' ), array(), '20190328' );
	// Add custom fonts.
	wp_enqueue_style( 'twentyseventeen-fonts', twentyseventeen_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'twentyseventeen_block_editor_styles' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentyseventeen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
			$sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentyseventeen_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function twentyseventeen_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'twentyseventeen_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return array The filtered attributes for the image markup.
 */
function twentyseventeen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'twentyseventeen_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function twentyseventeen_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template', 'twentyseventeen_front_page_template' );

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since Twenty Seventeen 1.4
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function twentyseventeen_widget_tag_cloud_args( $args ) {
	$args['largest']  = 1;
	$args['smallest'] = 1;
	$args['unit']     = 'em';
	$args['format']   = 'list';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'twentyseventeen_widget_tag_cloud_args' );

/**
 * Get unique ID.
 *
 * This is a PHP implementation of Underscore's uniqueId method. A static variable
 * contains an integer that is incremented with each call. This number is returned
 * with the optional prefix. As such the returned value is not universally unique,
 * but it is unique across the life of the PHP process.
 *
 * @since Twenty Seventeen 2.0
 * @see wp_unique_id() Themes requiring WordPress 5.0.3 and greater should use this instead.
 *
 * @staticvar int $id_counter
 *
 * @param string $prefix Prefix for the returned ID.
 * @return string Unique ID.
 */
function twentyseventeen_unique_id( $prefix = '' ) {
	static $id_counter = 0;
	if ( function_exists( 'wp_unique_id' ) ) {
		return wp_unique_id( $prefix );
	}
	return $prefix . (string) ++$id_counter;
}

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );

/*Custom Post type start*/

add_action('admin_menu', 'add_admin_options_quiz_list_page');
function add_admin_options_quiz_list_page() {
  add_menu_page( 'Quiz List & Add New Quiz', 'Quiz List & Add New Quiz', 'manage_options','quiz_list_menu', 'quiz_list_menu', '', '', 10 );
}
function quiz_list_menu()
{
    include(dirname(__FILE__).'/Template-All-Quiz-Show.php');
}



add_action("wp_ajax_create_quiz", "create_quiz");
add_action("wp_ajax_nopriv_create_quiz", "create_quiz");
function create_quiz()
{
	$quiz_list = get_option('quiz_list',true);
	$duplicate_post_types = get_option('duplicate_post_types_enabled',true);
	$index = 0;
	if(empty($quiz_list)){$quiz_list = array(); $index = 1;}
	
    
	$quiz_name = strtolower($_POST['quiz_name']);	
	$quiz_count = count($quiz_list);
	$quiz_slug = 'quiz_'.$quiz_count;
	$quiz_slug = sanitize_title($quiz_slug);
	
    $quiz_item_arr = array("index"=>$quiz_count,"slug"=>$quiz_slug,"quiz_name"=>$quiz_name);
    
	array_push($duplicate_post_types,$quiz_slug);
	array_push($quiz_list,$quiz_item_arr);
	
	update_option('quiz_list',$quiz_list);
	update_option('duplicate_post_types_enabled',$duplicate_post_types);
	
	/* Add In Quetions ACF */

	$post = get_post(2625); 
	$data = unserialize($post->post_content);

	$add_quiz = array('param' => 'post_type','operator' => '==','value' => $quiz_slug);
	array_push($data['location'],array($add_quiz));
	$my_post = array('ID' => 2625,'post_content' => serialize($data),);
	wp_update_post( $my_post );

	/* Add In PassWord ACF */

	global $wpdb;
	$table_post = $wpdb->prefix."posts";
	$results1 = $wpdb->get_results("select id from ".$table_post." where post_type = 'acf-field-group' and post_title = 'Password'");
	$results2 = $wpdb->get_results("select id from ".$table_post." where post_parent= ".$results1[0]->id." and post_type = 'acf-field' and post_title = 'Select Quiz'");
	$child_post_id = $results2[0]->id;

	
	$post_password = get_post($child_post_id);
	$data_password = unserialize($post_password->post_content);

	if (!array_key_exists("post_type",$data_password))
	{
		$data_password['post_type'] = array();
	}
	array_push($data_password['post_type'],$quiz_slug);
 
	$my_post_password = array('ID' => $child_post_id,'post_content' => serialize($data_password),);
	wp_update_post( $my_post_password );
	
	echo json_encode(array('status'=>true));
	exit;
}
add_action("wp_ajax_delete_quiz", "delete_quiz");
add_action("wp_ajax_nopriv_delete_quiz", "delete_quiz");

function delete_quiz()
{

	global $table_prefix, $wpdb;
	$table_posts = $table_prefix."posts";
	$table_postmeta = $table_prefix."postmeta";
	$table_term_relationships = $table_prefix."term_relationships";	
	  
	$post_type = $_POST['post_type'];
	if(!empty($post_type)) {

        $result1 = $wpdb->query("DELETE FROM ".$table_posts." WHERE post_type='".$post_type."'");
        $result2 = $wpdb->query("DELETE FROM ".$table_postmeta." WHERE post_id NOT IN (SELECT id FROM wp_posts WHERE post_type='".$post_type."')");
        $result3 = $wpdb->query("DELETE FROM ".$table_term_relationships." WHERE object_id NOT IN (SELECT id FROM wp_posts WHERE post_type='".$post_type."')");
		
		echo json_encode(array('status'=>true,'result1' => $result1,'result2' => $result2,'result3' => $result3));
		$post_type_no_arr = get_option('quiz_list',true);

		$quiz_list = array();

		foreach ($post_type_no_arr as $post_no) 
		{	
			if(strcasecmp(sanitize_title($post_no['slug']),sanitize_title($post_type)) != 0)
			{
				array_push($quiz_list,$post_no);
			}
		}
		update_option('quiz_list',$quiz_list);

		$post = get_post(2625); 
		$data = unserialize($post->post_content);
		$post_type_no_arr = get_option('quiz_list',true);
		$data['location'] = array();

		for ($i=0; $i <count($post_type_no_arr); $i++) { 
			$add_quiz = array('param' => 'post_type','operator' => '==','value' => $post_type_no_arr[$i]['slug']);
			array_push($data['location'],array($add_quiz));
		}
		$my_post = array('ID' => 2625,'post_content' => serialize($data),);
		wp_update_post( $my_post );
			 

		global $wpdb;
		$table_post = $wpdb->prefix."posts";
		$results1 = $wpdb->get_results("select id from ".$table_post." where post_type = 'acf-field-group' and post_title = 'Password'");
		$results2 = $wpdb->get_results("select id from ".$table_post." where post_parent= ".$results1[0]->id." and post_type = 'acf-field' and post_title = 'Select Quiz'");
		$child_post_id = $results2[0]->id;

		$post_password = get_post($child_post_id);

		$data_password = unserialize($post_password->post_content);

		$data_password['post_type'] = array();
		

		for ($i=0; $i <count($post_type_no_arr); $i++) { 
			array_push($data_password['post_type'],sanitize_title($post_type_no_arr[$i]['slug']));
		}
		$my_post_password = array('ID' => $child_post_id,'post_content' => serialize($data_password),);
		wp_update_post( $my_post_password );

		/* dublicate */

		$post_type_no = $post_type;
		$duplicate_post_types = get_option('duplicate_post_types_enabled',true);
		$duplicate_post_types_enabled_list = array();
		foreach ($duplicate_post_types as $duplicate_post_type){	
			if(strcasecmp(sanitize_title($duplicate_post_type),sanitize_title($post_type_no)) != 0){
				array_push($duplicate_post_types_enabled_list,$duplicate_post_type);
			}
		}
		update_option('duplicate_post_types_enabled',$duplicate_post_types_enabled_list);
		echo json_encode(array('status'=>true));

	}
	else
	{
		echo json_encode(array('status'=>false));
	}
	exit;
}


add_action('init', 'cw_post_type_quiz_list');
function cw_post_type_quiz_list()
{
	$quiz_list = get_option('quiz_list',true);
	if(!empty($quiz_list))
	{
		foreach($quiz_list as $quiz_item)
		{
			cw_post_type_Quiz($quiz_item['slug'],$quiz_item['quiz_name']);	
		}	
	}

}

function cw_post_type_Quiz($quiz_slug,$quiz_name) {

	$supports = array(
	'title', // post title
	'editor', // post content
	'author', // post author
	'thumbnail', // featured images
	'custom-fields', // custom fields
	'revisions', // post revisions
	'post-formats', // post formats
	);

	$labels = array(
	'name' => _x($quiz_name, 'plural'),
	'singular_name' => _x($quiz_name, 'singular'),
	'menu_name' => _x($quiz_name, 'admin menu'),
	'name_admin_bar' => _x($quiz_name, 'admin bar'),
	'add_new' => _x('Add New', 'add new'),
	'add_new_item' => __('Add New '.$quiz_name),
	'new_item' => __('New '.$quiz_name),
	'edit_item' => __('Edit '.$quiz_name),
	'view_item' => __('View '.$quiz_name),
	'all_items' => __('All '.$quiz_name),
	'search_items' => __('Search '.$quiz_name),
	'not_found' => __('No '.$quiz_name.' found.'),
	);

	$args = array(
	'supports' => $supports,
	'labels' => $labels,
    'show_in_menu' => true,
	'public' => true,
	'query_var' => true,
	'rewrite' => array('slug' => sanitize_title($quiz_slug)),
	'has_archive' => true,
	'hierarchical' => false,
	);
	register_post_type(sanitize_title($quiz_slug), $args);
}

function cw_post_type_Password() {

	$supports = array(
	'title', // post title
	'editor', // post content
	'author', // post author
	'thumbnail', // featured images
	// 'excerpt', // post excerpt
	'custom-fields', // custom fields
	// 'comments', // post comments
	'revisions', // post revisions
	'post-formats', // post formats
	);

	$labels = array(
	'name' => _x('Password', 'plural'),
	'singular_name' => _x('Password', 'singular'),
	'menu_name' => _x('Password', 'admin menu'),
	'name_admin_bar' => _x('Password', 'admin bar'),
	'add_new' => _x('Add New', 'add new'),
	'add_new_item' => __('Add New Password'),
	'new_item' => __('New Password'),
	'edit_item' => __('Edit Password'),
	'view_item' => __('View Password'),
	'all_items' => __('All Password'),
	'search_items' => __('Search Password'),
	'not_found' => __('No Password found.'),
	);

	$args = array(
	'supports' => $supports,
	'labels' => $labels,
	'public' => true,
	'query_var' => true,
	'rewrite' => array('slug' => 'Password'),
	'has_archive' => true,
	'hierarchical' => false,
	);
	register_post_type('Password', $args);
}
add_action('init', 'cw_post_type_Password');


add_action("wp_ajax_quiz_password", "quiz_password");
add_action("wp_ajax_nopriv_quiz_password", "quiz_password");
function quiz_password(){
        session_start();
        session_regenerate_id();
    if(isset($_POST['team_name']) && isset($_POST['password']) && isset($_POST['action']))
    {
        $team_name = $_POST['team_name'];
        $post_password = $_POST['password'];
        $not_found = true;
        $raw_data = array();
        $i = 0;

        $args = array(
        'posts_per_page' => -1,
        'post_type' => 'password',
        'post_status' => 'publish',
        );
        
        $postslist = get_posts( $args );
        
        foreach($postslist as $post)
        {
			$questions_list_arr = get_field( "select_quiz", $post->ID,true);
			// print_r($questions_list_arr);
			// exit;
			$quiz_id = $questions_list_arr[0];
			$password_list = get_field( "password_list", $post->ID,true);
			$password_post_id = $post->ID;
            foreach($password_list as $password)
            {
                if($password['password'] == $post_password)
                {
                    

                    update_post_meta($password_post_id,$post_password.'_team_name', $team_name);
                    update_post_meta($password_post_id,$post_password.'_quiz_start', time());
                    update_post_meta($password_post_id,$post_password.'_session_id', session_id());
                    
                    /* set Data in db */
                    
					$quiz_password_status = get_post_meta($password_post_id,$post_password.'_question_status',true);

					if($quiz_password_status === 'false' || $quiz_password_status === false){
                        echo json_encode(array('status'=>false,'message'=>"Password Expired"));
                        exit;
                    }
					$q_count = 0;
					
                    $questions = wp_count_posts(get_post_type($quiz_id))->publish;
                    
                    for($q_no = 1;$q_no<=$questions;$q_no++)
                    {
                        $question_status = get_post_meta($password_post_id,$post_password.'_question_'.$q_no,true);
                        if($question_status === 'true' || $question_status === true){$q_count++;}
                    }
                    if($q_count == count($questions))
                    {
                        echo json_encode(array('status'=>false,'message'=>"Password Expired",'db_true'=> $q_count,'total_question' => $questions));
                        exit;
                    }
                                         
                    /* Start Session */
					$_SESSION["quiz_id"] = $quiz_id;
					$_SESSION["password_post_id"] = $password_post_id;
					$_SESSION["quiz_id_arr"] = $questions_list_arr;
                    $_SESSION[$quiz_id."_team_name"] = $team_name;
                    $_SESSION[$post_password."_team_name"] = $team_name;
                    $_SESSION[$quiz_id."_team_id"] = $post_password;


                    $url = home_url()."/quiz/?id=".rand(111111,999999);
                    echo json_encode(array('status'=>true,'message'=>"",'url'=> $url));
                    exit;
                }
                else
                {
                    $not_found = true;
                }
            }
        }
        if($not_found)
        {
            echo json_encode(array('status'=>false,'message'=>"Enter Valid Password"));
            exit;
        }
    }
    else
    {
        echo json_encode(array('status'=>false,'message'=>"Enter Email And Password"));
    }
    

    exit;
}


add_action("wp_ajax_question_verification", "question_verification");
add_action("wp_ajax_nopriv_question_verification", "question_verification");
function question_verification()
{
    if(isset($_POST['action']) 
    && !empty($_POST['action']) 
    && $_POST['action'] == "question_verification" 
    && isset($_POST['question_no']) 
    && !empty($_POST['question_no']) 
    && isset($_POST['quiz_id']) 
    && !empty($_POST['quiz_id'])
    && isset($_POST['template']) 
    && !empty($_POST['template'])
    && isset($_POST['answer']) 
    && !empty($_POST['answer'])
    && isset($_POST['password'])
    && !empty($_POST['password']))
    {
        $question_no = $_POST['question_no'];
		$quiz_id = $_POST['quiz_id'];
		$quiz_static_id = $_POST['quiz_static_id'];
        $template = $_POST['template'];
        $answer = $_POST['answer'];
		$password = $_POST['password'];
		$possword_id = $_POST['possword_id'];
		
		$select_template = get_field( "select_template", $quiz_id,true);
		$template = str_replace("-","_",$select_template);
		$data = get_field( $template , $quiz_id,true);  
        $question_text = $data['question_text'];
        $answers = $question_text['answers'];
        $answer_list = get_post_meta($possword_id,$password.'_question_answer_list',true);
        if(empty($answer_list)){$answer_list = array();}
		$answer_flag = true;

		$question_count = wp_count_posts(get_post_type($quiz_static_id))->publish;

        if(!empty($answer))
        {
            if($data['answer_type'] == 'multiple_answer')
            {
                $answers = $data['multiple_answers'];
                if(empty($data['multiple_answers']) || $data['multiple_answers'] == '' || $data['multiple_answers'] == null || !isset($data['multiple_answers']))
                {
                    $answers = $data['multiple_answer'];
                }

                for($ans = 0; $ans<count($answers);$ans++)
                {                   
                    if(strtolower($answers[$ans]['answer']) == strtolower($answer) && $answers[$ans]['correct'] == 1)
                    {
                        // echo "condtion for"."</br>";
                        if($question_count  == $question_no)
                        {
                            update_post_meta($possword_id,$password.'_question_status','false');
							update_post_meta($possword_id,$password.'_quiz_end',time());
							session_destroy();
                        }
                        
                        update_post_meta($possword_id,$password.'_question_'.$question_no,'true');
                        $answer_item = ["question_no"=>$question_no,"answer"=>$answer,"answer_status"=>'true'];
                        array_push($answer_list,$answer_item);
                        update_post_meta($possword_id,$password.'_question_answer_list',$answer_list);
    
                        echo json_encode(array('status'=>true));
                        exit;
            
                    }
                }
                
            }
            else if($data['answer_type'] == 'single_answer')
            {
				$answers = $data['single_answer'];
				// echo $data['single_answer'];
                
                // echo strtolower($answers).' == '.strtolower($answer);
                
                if(strtolower($answers) == strtolower($answer))
                {
                    if($question_count == $question_no)
                    {
                        update_post_meta($possword_id,$password.'_question_status','false');
						update_post_meta($possword_id,$password.'_quiz_end',time());
						session_destroy();
                    }
                    
                    update_post_meta($possword_id,$password.'_question_'.$question_no,'true');
                    $answer_item = ["question_no"=>$question_no,"answer"=>$answer,"answer_status"=>'true'];
                    array_push($answer_list,$answer_item);
                    update_post_meta($possword_id,$password.'_question_answer_list',$answer_list);

                    echo json_encode(array('status'=>true));
                    exit;
                    
                }
                
            }else
            {
                if($question_count == $question_no)
                {
                    update_post_meta($possword_id,$password.'_question_status','false');
					update_post_meta($possword_id,$password.'_quiz_end',time());
					session_destroy();
                }
                
                update_post_meta($possword_id,$password.'_question_'.$question_no,'true');
                $answer_item = ["question_no"=>$question_no,"answer"=>$answer,"answer_status"=>'true'];
                array_push($answer_list,$answer_item);
                update_post_meta($possword_id,$password.'_question_answer_list',$answer_list);

                echo json_encode(array('status'=>true));
                exit;
            }

            if($answer_flag)
            {
                $answer_item = ["question_no"=>$question_no,"answer"=>$answer,"answer_status"=>'false'];
                array_push($answer_list,$answer_item);
                update_post_meta($possword_id,$password.'_question_answer_list',$answer_list);
                echo json_encode(array('status'=>false,'message'=>"Your answer is incorrect, please try again"));
                exit;
            }
        }
        else
        {
            if(count($questions) == $question_no)
            {
                update_post_meta($possword_id,$password.'_question_status','false');
				update_post_meta($possword_id,$password.'_quiz_end',time());
				session_destroy();
            }
            
            update_post_meta($possword_id,$password.'_question_'.$question_no,'true');
            $answer_item = ["question_no"=>$question_no,"answer"=>$answer,"answer_status"=>'true'];
            array_push($answer_list,$answer_item);
            update_post_meta($possword_id,$password.'_question_answer_list',$answer_list);
            echo json_encode(array('status'=>true));
            exit;
        }

    }
    else
    {
        echo json_encode(array('status'=>false,'message'=>"something want to wrong"));
        exit;
    }
    
}

add_action('admin_menu', 'add_plugin_options_page');
function add_plugin_options_page() {
  add_menu_page( 'Quiz Detail', 'Quiz Detail', 'manage_options','quiz_detail', 'quiz_detail_show', '', '', 10 );
}
function quiz_detail_show()
{
    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'password',
        'post_status' => 'publish',
    );
        
    $postslist = get_posts( $args );
    $i = 0;
    foreach($postslist as $post)
    {
		$quiz_id = get_field( "select_quiz", $post->ID,true);
		// print_r($quiz_id[0]);
		$possword_id = $post->ID;

        $password_list = get_field( "password_list", $post->ID,true);
        include(dirname(__FILE__).'/Template-Admin-Quiz-Detail.php');
        $i++;
    }
}


$n=10; 
function getName($n) { 
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $randomString = ''; 
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 
  
    return $randomString; 
} 
function dolly_css() {
    // This makes sure that the positioning is also good for right-to-left languages
    $x = is_rtl() ? 'left' : 'right';
 
    echo "<style type='text/css'>
            .post-type-password .acf-field.acf-field-relationship .acf-input .acf-relationship .selection {
                display: none;
            }
            </style>";
}
add_action( 'admin_head', 'dolly_css' );
/*Custom Post type end*/

add_action("wp_ajax_get_current_select_post_type", "get_current_select_post_type");
add_action("wp_ajax_nopriv_get_current_select_post_type", "get_current_select_post_type");
function get_current_select_post_type()
{
    $post_id = $_POST['post_id'];
    $password_list = get_field( "select_quiz",$post_id,true);
    echo json_encode(array('status'=>true,"post_type"=>get_post_type($password_list[0])));
    exit;
    
}
add_action("wp_ajax_remove_quiz_from_db","remove_quiz_from_db");
add_action("wp_ajax_nopriv_remove_quiz_from_db","remove_quiz_from_db");
function remove_quiz_from_db()
{
    if(!empty($_POST['password']) && !empty($_POST['quiz_id']))
    {
        $password = $_POST['password'];
        $quiz_id = $_POST['quiz_id'];
        
        delete_post_meta($quiz_id,$password.'_team_name');
        delete_post_meta($quiz_id,$password.'_quiz_start');
        delete_post_meta($quiz_id,$password.'_quiz_end');
        delete_post_meta($quiz_id,$password.'_session_id');
        delete_post_meta($quiz_id,$password.'_question_status');
        delete_post_meta($quiz_id,$password.'_question_answer_list');

        
        $total_question = count(get_field( "questions", $_POST['quiz_id'],true));
        
        for($i=0;$i<$total_question;$i++)
        {
            delete_post_meta($quiz_id,$password.'_question_'.$i);
            delete_post_meta($quiz_id,' password_list_'.$i.'_password');
           
        }
    }
    echo json_encode(array('status'=>true,'data'=>$_POST));
    exit;
}
add_action('admin_footer', 'my_admin_add_js');
function my_admin_add_js() {
	echo '<script>';?>
	jQuery(document).ready(function(){
        setInterval(function(){
            jQuery('.values.ui-sortable .layout').each(function(){
                var header_text = jQuery(this).find('.acf-fields [data-name="question_text"].acf-field .acf-input input[type="text"]').first().val();
                jQuery(this).find('[data-name="collapse-layout"].acf-fc-layout-handle').html('<span class="acf-fc-layout-order">@</span>'+header_text);
            });
        },1000);    
            jQuery('.layout').removeClass('-collapsed');
            jQuery('.layout').addClass('-collapsed');
		
		setInterval(function(){jQuery('.choices ul li ul').hide();},100);
		jQuery(document).on('click','.acf-rel-label',function(){
			jQuery(this).siblings('ul').find('li').each(function(){
				jQuery(this).children('span').trigger('click');
			});
		});
		
	});
	
	setInterval(function(){jQuery('.selection ul.acf-bl.list.choices-list').css('height','100%');},100);
	
	jQuery(document).on('change','.acf-field.acf-field-relationship .acf-relationship select',function(){
	        
            setTimeout(function(){jQuery('.values ul.acf-bl.list.values-list.ui-sortable li span a').trigger('click');console.log("value remove");},500);
            setTimeout(function(){jQuery('ul.acf-bl.list.choices-list li span').trigger('click');console.log("value add");},1000);
    });
    console.log("test code1");
    if(jQuery('body').hasClass('post-type-password'))
    {
            console.log("test code2");
            var formdata = new FormData();        
            
            formdata.append("action", 'get_current_select_post_type');
            formdata.append("post_id", "<?=get_the_ID()?>");

            jQuery.ajax({
                type: 'POST',
                url: '<?=admin_url("admin-ajax.php")?>',
                traditional: true,
                processData: false,
                contentType: false,	
                dataType: "json",
                data:formdata,
              success: function (response) 
              {
                  console.log(response.post_type);
                  jQuery('.acf-field.acf-field-relationship .acf-relationship select').val(response.post_type)
              },
              error: function (jqXHR,textStatus,errorThrown) {
                  console.log(jqXHR);
                  console.log(textStatus);
                  console.log(errorThrown);            
              }
          }); 
    }
    
    jQuery(document).on('click','a.acf-icon.-minus.small.acf-js-tooltip',function(){
        console.log('click on password remove');
        var password = jQuery(this).parents('tr.acf-row').find('input[type="text"]').val();
        var quiz_id = jQuery(this).parents('.inside.acf-fields.-top').find('div[data-name="select_quiz"] .acf-input select').val();
        jQuery('a[data-event="confirm"]').click();
        var formdata = new FormData();        
        formdata.append("action", 'remove_quiz_from_db');
        formdata.append("password", password);
        formdata.append("quiz_id", quiz_id);
        console.log(formdata);
        jQuery.ajax({
            type: 'POST',
            url: '<?=admin_url("admin-ajax.php")?>',
            traditional: true,
            processData: false,
            contentType: false,	
            dataType: "json",
            data:formdata,
          success: function (response) 
          {
            if(response.status)
            {
                
            }
          },
          error: function (jqXHR,textStatus,errorThrown) {
              console.log(jqXHR);
              console.log(textStatus);
              console.log(errorThrown); 
          }
        });  
    });

<?php echo '</script>';
	
}