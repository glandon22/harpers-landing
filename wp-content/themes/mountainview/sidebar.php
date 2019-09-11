<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mountainview
 */

if ( ( ! is_home() || ! is_singular('post') ) && ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}

if( ( is_home() || is_singular('post') ) && ! is_active_sidebar('sidebar-blog') && ! is_active_sidebar( 'sidebar-1' ) ){
    return;
}
?>

<aside id="secondary" class="widget-area">
	<?php
        if( ( is_singular('post') || is_home() )
            && is_active_sidebar('sidebar-blog') ){
            dynamic_sidebar('sidebar-blog');
        }else{
            dynamic_sidebar( 'sidebar-1' );
        }

	?>
</aside><!-- #secondary -->
