<?php
/**
 * Template part for displaying posts in loop
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mountainview
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php mountainview_post_thumbnail(); ?>
    <div class="entry-wrapper">
        <header class="entry-header">
            <?php
            if ( is_singular() ) :
                the_title( '<h1 class="entry-title">', '</h1>' );
            else :
                the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            endif;
            ?>

        </header><!-- .entry-header -->


        <div class="entry-content">
            <?php
            the_content( sprintf(
                wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'mountainview' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ) );

            wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mountainview' ),
                'after'  => '</div>',
            ) );
            ?>
        </div><!-- .entry-content -->
    </div>
    <div class="entry-footer">
        <?php
        if ( 'post' === get_post_type() ) :
        ?>
        <div class="entry-meta">
            <?php
            mountainview_featured_post();
            mountainview_posted_on();
            mountainview_posted_by();
            mountainview_comments_link();
            mountainview_posted_in();
            ?>
        </div><!-- .entry-meta -->
        <?php endif; ?>
    </div>
</article><!-- #post-<?php the_ID(); ?> -->
