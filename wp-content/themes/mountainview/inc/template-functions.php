<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Mountainview
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function mountainview_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'page-no-sidebar';
	}

    if( is_page_template('template-page-no-sidebar.php') ||
        is_page_template('template-grid-page-no-sidebar.php')||
        is_page_template('template-front-page-no-sidebar.php') ){
        $classes[] = 'page-no-sidebar';
    }
    if( is_page_template('template-page-sidebar-right.php') ){
        $classes[] = 'page-sidebar-right';
    }

    if(is_front_page() && !has_post_thumbnail()){
        $classes[] = 'home-no-header-image';
    }

	return array_unique($classes);
}
add_filter( 'body_class', 'mountainview_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function mountainview_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'mountainview_pingback_header' );


function mountainview_search_form( $form ) {
    $form = '<form role="search" method="get" class="search-form" action="' . home_url( '/' ) . '" >
        <div class="search-controls">
            <label>
		        <span class="screen-reader-text">'. esc_html_x( 'Search for:', 'label', 'mountainview' ) .'</span>
                <input type="search" class="search-field" placeholder="'. esc_attr_x( 'Search &hellip;', 'placeholder', 'mountainview' ). '" 
                    value="'. get_search_query() .'" name="s" />
            </label>
        <button type="submit" id="search-submit"><i class="fa fa-search"></i><span class="screen-reader-text">'. esc_html_x( 'Search', 'submit button', 'mountainview' ). '</span></button>
        </div>
        </form>';

    return $form;
}

add_filter( 'get_search_form', 'mountainview_search_form' );

if(!function_exists('mountainview_page_heading_classes_filter')){
    function mountainview_page_heading_classes_filter( $classes ){
        if( ! is_active_sidebar('sidebar-1')){
            $classes[] = 'no-sidebar';
        }

        if(is_page_template('template-page-no-sidebar.php') ||
            is_page_template('template-grid-page-no-sidebar.php')||
            is_page_template('template-front-page-no-sidebar.php')){
            $classes[] = 'no-sidebar';
        }
        if(is_page_template('template-page-sidebar-right.php')){
            $classes[] = 'sidebar-right';
        }

        return $classes;
    }
}
add_filter('mountainview_page_heading_classes', 'mountainview_page_heading_classes_filter', 5);

