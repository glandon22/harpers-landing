<?php
/**
 *
 * Template Name: No Sidebar
 *
 * Template Post Type: page, post, mphb_room_type
 *
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mountainview
 */

get_header();
?>

    <div id="primary" class="content-area no-sidebar">
        <main id="main" class="site-main">

            <?php
            while ( have_posts() ) :
                the_post();

                if( in_array(get_post_type(), array('post', 'mphb_room_type')) ){

                    get_template_part( 'template-parts/content', 'single' );

                }else{

                    get_template_part( 'template-parts/content', 'page' );

                }



                if( 'post' == get_post_type() ){

                    mountainview_post_tags();

                    mountainview_related_posts($post);

                    get_template_part('template-parts/biography');
                }
                // If comments are open or we have at least one comment, load up the comment template.

                if( in_array(get_post_type(), array('post', 'mphb_room_type')) ){
                    mountainview_the_post_navigation();
                }

                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;


            endwhile; // End of the loop.
            ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
