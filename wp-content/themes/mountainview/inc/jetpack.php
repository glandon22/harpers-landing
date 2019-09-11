<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.com/
 *
 * @package Mountainview
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 * See: https://jetpack.com/support/content-options/
 */
function mountainview_jetpack_setup() {

	// Add theme support for Responsive Videos.
    if( ! has_action( 'enqueue_block_assets' ) && ! function_exists( 'gutenberg_can_edit_post_type' ) ){

        add_theme_support( 'jetpack-responsive-videos' );

    }

	// Add theme support for Content Options.
	add_theme_support( 'jetpack-content-options', array(
        'author-bio'         => true,
		'post-details'    => array(
			'stylesheet' => 'mountainview-style',
			'date'       => '.posted-on',
			'categories' => '.cat-links',
			'author'     => '.byline',
			'comment'    => '.comments-link',
		),
		'featured-images' => array(
			'archive'    => true,
			'post'       => true,
			'page'       => true,
		),
	) );
}
add_action( 'after_setup_theme', 'mountainview_jetpack_setup' );

function mountainview_author_bio_avatar_size() {
    return 100; // in px
}
add_filter( 'jetpack_author_bio_avatar_size', 'mountainview_author_bio_avatar_size' );


