<?php
/**
 * Mountainview functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Mountainview
 */

if ( ! function_exists( 'mountainview_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function mountainview_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Mountainview, use a find and replace
		 * to change 'mountainview' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'mountainview', get_template_directory() . '/languages' );

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

		set_post_thumbnail_size(800);
		add_image_size('mountainview-large', 1516);

		add_image_size('mountainview-medium', 924, 616, true);
		add_image_size('mountainview-small', 150, 100, true);

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'mountainview' ),
            'menu-2' => esc_html__( 'Header left', 'mountainview' ),
            'menu-3' => esc_html__( 'Header right (social)', 'mountainview' ),
			'menu-4' => esc_html__( 'Footer', 'mountainview' ),
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

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'mountainview_custom_background_args', array(
			'default-image' => get_template_directory_uri() . '/images/bg_image.jpg',
            'default-preset' => 'custom',
            'default-position-x' => 'center',
            'default-position-y' => 'top',
            'default-size' => 'auto',
            'default-repeat' => 'no-repeat',
            'default-attachment' => 'scroll',
            'default-color' => '96acbd',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 60,
			'width'       => 60,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		add_theme_support('jetpack-testimonial');

        add_theme_support( 'responsive-embeds' );

        add_theme_support( 'align-wide' );

        add_theme_support('editor-styles');

        add_editor_style(array('css/editor-style.css', mountainview_fonts_url()));

        add_theme_support( 'editor-color-palette', array(
            array(
                'name' => __( 'Primary', 'mountainview' ),
                'slug' => 'primary',
                'color' => '#7db900',
            ),
            array(
                'name' => __( 'Secondary', 'mountainview' ),
                'slug' => 'secondary',
                'color' => '#383838',
            ),
            array(
                'name' => __( 'Light green', 'mountainview' ),
                'slug' => 'light-green',
                'color' => '#9ad819',
            ),
            array(
                'name' => __( 'Light gray', 'mountainview' ),
                'slug' => 'light-gray',
                'color' => '#f3f5f7',
            ),
            array(
                'name' => __( 'Gray', 'mountainview' ),
                'slug' => 'gray',
                'color' => '#e3e3e3',
            ),
            array(
                'name' => __( 'White', 'mountainview' ),
                'slug' => 'white',
                'color' => '#fff',
            ),
            array(
                'name' => __( 'Black', 'mountainview' ),
                'slug' => 'black',
                'color' => '#292929',
            ),
        ) );

	}
endif;
add_action( 'after_setup_theme', 'mountainview_setup' );

/**
 * Get theme version.
 *
 * @access public
 * @return string
 */
function mountainview_get_theme_version() {
    $theme_info = wp_get_theme( get_template() );
    return $theme_info->get('Version');
}


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mountainview_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'mountainview_content_width', 800 );
}
add_action( 'after_setup_theme', 'mountainview_content_width', 0 );

function mountainview_adjust_content_width() {
    global $content_width;

    if( is_page_template('template-page-no-sidebar.php') ||
        is_page_template('template-front-page-no-sidebar.php') ||
        is_page_template('template-grid-page-no-sidebar.php')){
        $content_width = 924;
    }
}
add_action( 'template_redirect', 'mountainview_adjust_content_width');


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mountainview_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'mountainview' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'mountainview' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
    register_sidebar( array(
        'name'          => esc_html__( 'Blog Sidebar', 'mountainview' ),
        'id'            => 'sidebar-blog',
        'description'   => esc_html__( 'Add widgets here.', 'mountainview' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'mountainview' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'mountainview' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'mountainview' ),
		'id'            => 'sidebar-3',
		'description'   => esc_html__( 'Add widgets here.', 'mountainview' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'mountainview' ),
		'id'            => 'sidebar-4',
		'description'   => esc_html__( 'Add widgets here.', 'mountainview' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 4', 'mountainview' ),
		'id'            => 'sidebar-5',
		'description'   => esc_html__( 'Add widgets here.', 'mountainview' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page Footer Top', 'mountainview' ),
		'id'            => 'sidebar-6',
		'description'   => esc_html__( 'Add widgets here.', 'mountainview' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page Footer Left', 'mountainview' ),
		'id'            => 'sidebar-7',
		'description'   => esc_html__( 'Add widgets here.', 'mountainview' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page Footer Right', 'mountainview' ),
		'id'            => 'sidebar-8',
		'description'   => esc_html__( 'Add widgets here.', 'mountainview' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'mountainview_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function mountainview_scripts() {

    wp_enqueue_style( 'mountainview-fonts', mountainview_fonts_url() );

	wp_enqueue_style( 'mountainview-style', get_stylesheet_uri(), array(), mountainview_get_theme_version() );

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css', array(), '4.7.0' );

    if ( class_exists( 'HotelBookingPlugin' ) ) {
        wp_enqueue_style('mountainview-mphb', get_template_directory_uri() . '/css/motopress-hotel-booking.css', array(), mountainview_get_theme_version());
    }

    if( defined( 'JETPACK__VERSION' ) ){
        wp_enqueue_style( 'mountainview-jetpack', get_template_directory_uri() . '/css/jetpack.css', array(), mountainview_get_theme_version());

        wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/assets/flex-slider/jquery.flexslider-min.js', array('jquery'), '2.7.1', true );
        wp_enqueue_style('flexslider-style', get_template_directory_uri() . '/assets/flex-slider/flexslider.css', array(), '2.7.1');
    }

	wp_enqueue_script( 'mountainview-script', get_template_directory_uri() . '/js/functions.js', array('jquery'), mountainview_get_theme_version(), true );

	wp_enqueue_script( 'mountainview-navigation', get_template_directory_uri() . '/js/navigation.js', array(), mountainview_get_theme_version(), true );

	wp_enqueue_script( 'mountainview-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), mountainview_get_theme_version(), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mountainview_scripts' );

if (!function_exists('mountainview_fonts_url')) :
    /**
     * Register Google fonts for Mountainview.
     *
     * Create your own mountainview_fonts_url() function to override in a child theme.
     *
     * @return string Google fonts URL for the theme.
     */
    function mountainview_fonts_url()
    {
        $fonts_url = '';
        $font_families = array();

        /**
         * Translators: If there are characters in your language that are not
         * supported by Lato, translate this to 'off'. Do not translate
         * into your own language.
         */
        if ('off' !== esc_html_x('on', 'Ubuntu font: on or off', 'mountainview')) {
            $font_families[] = 'Ubuntu:400,500,700';
        }
        if ('off' !== esc_html_x('on', 'Lora font: on or off', 'mountainview')) {
            $font_families[] = 'Lora:400,700';
        }
        if ($font_families) {
            $query_args = array(
                'family' => urlencode(implode('|', $font_families)),
                'subset' => urlencode('latin,latin-ext'),
            );
            $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
        }

        return esc_url_raw($fonts_url);

        $fonts_url = '';
    }
endif;

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
/**
 * Load MPHB compatibility file.
 */
if ( class_exists( 'HotelBookingPlugin' ) ) {
	require get_template_directory() . '/inc/mphb-functions.php';
}

/**
 * Load TGM
 */

require_once get_template_directory() . '/inc/tgmpa-init.php';

/**
 * Load demo-data
 */

require_once get_template_directory() . '/inc/demo-import.php';


add_filter('default_page_template_title', function() {
    return esc_html__('Sidebar Left', 'mountainview');
});


if (!function_exists('mountainview_widget_tag_cloud_args')) :
    /**
     * Modifies tag cloud widget arguments to have all tags in the widget same font size.
     *
     * @since Mountainview 1.0.0
     *
     * @param array $args Arguments for tag cloud widget.
     *
     * @return array A new modified arguments.
     */
    function mountainview_widget_tag_cloud_args($args)
    {
        $args['largest'] = 0.75;
        $args['smallest'] = 0.75;
        $args['unit'] = 'rem';

        return $args;
    }
endif;
add_filter('widget_tag_cloud_args', 'mountainview_widget_tag_cloud_args');
