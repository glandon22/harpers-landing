<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Mountainview
 */

if ( ! function_exists( 'mountainview_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function mountainview_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);
        if( ! is_single()){
            $posted_on = sprintf(
            /* translators: %s: post date. */
                esc_html_x( '%s', 'post date', 'mountainview' ),
                '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
            );
        }else{
            $posted_on = $time_string;
        }

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'mountainview_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function mountainview_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( '%s', 'post author', 'mountainview' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if( ! function_exists('mountainview_posted_in')){
    function mountainview_posted_in(){
        if ( 'post' === get_post_type() ) {
			$separator =esc_html_x(', ', 'Separator between the categories', 'mountainview');

            $categories_list = get_the_category_list($separator);
            if ($categories_list) {
                /* translators: 1: list of categories. */
                printf('<span class="cat-links">%1$s</span>', $categories_list); // WPCS: XSS OK.
            }
        }
    }
}

if( ! function_exists('mountainview_comments_link')){
    function mountainview_comments_link(){
        if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                    /* translators: %s: post title */
                        __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'mountainview' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                )
            );
            echo '</span>';
        }
    }
}

if( ! function_exists('mountainview_featured_post')){
    function mountainview_featured_post(){
        if('post' == get_post_type() && is_sticky()):
            ?>
            <span class="featured-post"><?php
                echo esc_html__('Featured', 'mountainview');
                ?></span>
            <?php
        endif;
    }
}

if( ! function_exists('mountainview_post_tags')){
    function mountainview_post_tags(){
        if('post' == get_post_type()){
            $tags_list = get_the_tag_list( '', esc_html_x( ' ', 'Used between list items, there is a space.', 'mountainview' ) );
            if ( $tags_list ) {
                printf( '<p class="tagcloud"><span class="tags-links"><span class="tags-title">%1$s </span>%2$s</span></p>',
                    esc_html_x( 'Tagged: ', 'Used before tag names.', 'mountainview' ),
                    $tags_list
                );
            }
        }
    }
}


if ( ! function_exists( 'mountainview_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function mountainview_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;


if ( ! function_exists( 'mountainview_the_posts_pagination' ) ) :
    /**
     * Displays the post pagination.
     */
    function mountainview_the_posts_pagination() {
        the_posts_pagination( array(
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'mountainview' ) . ' </span>',
            'mid_size'           => 1,
        ) );
    }
endif;

if(!function_exists('mountainview_header_image')){
    function mountainview_header_image(){
        global $post;
        if (has_post_thumbnail() && !is_home() && !is_archive() && !is_search()){
            ?>
            <div class="image">
                <?php
                 the_post_thumbnail('mountainview-large');
                ?>
            </div>
            <?php
            mountainview_page_heading('has-image');

        }else{
            mountainview_page_heading('no-image');
        }

    }
}

if(!function_exists('mountainview_page_heading')){
    function mountainview_page_heading($type){
        if(is_front_page()){
            return;
        }
        $page_header_classes = array(
            'page-heading-wrapper',
            $type
        );
        $page_header_classes = apply_filters('mountainview_page_heading_classes', $page_header_classes);
        ?>
        <div class="<?php echo esc_attr(implode(' ', $page_header_classes));?>">
            <div class="page-heading">
            <?php
            if ( is_home() && ! is_front_page() ) {
                ?>
                <div class="page-header">
                    <p class="page-title"><?php echo apply_filters( 'the_title', get_the_title( get_option( 'page_for_posts' ) ) ); ?></p>
                </div><!-- .page-header -->
                <?php
            }elseif ( is_home() && is_front_page() ) {
                ?>
                <div class="page-header">
                    <p class="page-title"><?php bloginfo('name'); ?></p>
                </div><!-- .page-header -->
                <?php
            } elseif ( is_single() || is_page()) {
                ?>
                <div class="page-header">
                    <?php the_title( '<p class="page-title">', '</p>' ); ?>
                </div><!-- .page-header -->
                <?php
            } elseif ( is_search() ) {
                ?>
                <div class="page-header">
                    <p class="page-title">
                        <?php
                        echo wp_kses(
							/* translators: %s: search query. */
							sprintf( __( 'Search Results for: %s', 'mountainview' ), '<span>' . get_search_query() . '</span>' ),
							array(
								'span' => array(),
							)
						);
                        ?>
                    </p>
                </div>
                <?php
            }elseif (is_404()){
                ?>
                <div class="page-header">
                    <p class="page-title">
                        <?php
                        echo esc_html__( 'Oops! That page can&rsquo;t be found.', 'mountainview' );
                        ?>
                    </p>
                </div>
                <?php

            } elseif ( is_archive() ) {
                if(function_exists('is_woocommerce') && is_woocommerce()){
                    ?>
                    <div class="page-header">
                        <p class="page-title">
                            <?php woocommerce_page_title(); ?>
                        </p>
                    </div><!-- .page-header -->
                    <?php
                }else{
                    ?>
                    <div class="page-header">
                        <?php
                        the_archive_title('<p class="page-title">', '</p>');
                        the_archive_description( '<div class="archive-description">', '</div>' );
                        ?>
                    </div>
                    <?php
                }
            }

            mountainview_breadcrumbs();
            ?>
            </div>
        </div>
        <?php
    }
}

if( ! function_exists('mountainview_breadcrumbs')){
    function mountainview_breadcrumbs(){
        if(is_home()){
            return;
        }
        if ( function_exists( 'breadcrumb_trail' ) ) {
            ?>
            <div class="breadcrumbs">
                <?php
                breadcrumb_trail(array(
                    'show_on_front'   => false,
                    'show_browse'     => false,
                ));
                ?>
            </div>
            <?php
        }
    }
}


if(!function_exists('mountainview_child_pages_grid')){
    function mountainview_child_pages_grid(){
        global $post;
        $args   = apply_filters( 'mountainview_child_pages_list_args', array(
                'post_type'      => 'page',
                'posts_per_page' => - 1,
                'post_parent'    => $post->ID,
                'order'          => 'ASC',
                'orderby'        => 'menu_order'
            )
        );
        $parent = new WP_Query( $args );
        if ( $parent->have_posts() ) :?>
        <div class="child-pages-grid">
            <?php
            while ($parent->have_posts()):
                $parent->the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="entry-wrapper">
                    <?php
                    if(has_post_thumbnail()):
                    ?>
                    <a href="<?php the_permalink();?>" class="post-thumbnail">
                        <?php
                        the_post_thumbnail('mountainview-medium');
                        ?>
                    </a>
                    <?php
                    endif;
                    the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                    the_content(sprintf(
                        wp_kses(
                        /* translators: %s: Name of current post. Only visible to screen readers */
                            __( 'Read more<span class="screen-reader-text"> "%s"</span>', 'mountainview' ),
                            array(
                                'span' => array(
                                    'class' => array(),
                                ),
                            )
                        ),
                        get_the_title()
                    ) );
                    ?>
                </div>
            </article>
            <?php
            endwhile;
            ?>
        </div>
        <?php
        endif;
        wp_reset_query();


    }
}


if ( ! function_exists( 'mountainview_related_posts' ) ) :
    /**
     * Displays related posts
     */
    function mountainview_related_posts( $post ) {
        if ( 'post' === get_post_type() ) {
            global $post;
            $categories = wp_get_post_categories( $post->ID );
            if ( $categories ) {
                $args     = array(
                    'category__in'        => $categories,
                    'post__not_in'   => array( $post->ID ),
                    'posts_per_page' => 4
                );
                $my_query = new wp_query( $args );
                if ( $my_query->have_posts() ):
                    ?>
                    <div class="related-posts">
                        <h2 class="related-posts-title"><?php esc_html_e( 'Related Posts', 'mountainview' ); ?></h2>
                        <!-- .related-posts-title -->
                        <ul>
                            <?php
                            while ( $my_query->have_posts() ) {
                                $my_query->the_post();
                                ?>
                                <li>
                                    <a href="<?php the_permalink() ?>" rel="bookmark"
                                       title="<?php the_title_attribute(); ?>"><?php echo esc_html(get_the_title()); ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div><!-- .related-posts -->
                <?php
                endif;
                ?>
                <?php
            }
            wp_reset_query();
        }
    }

endif;

if( ! function_exists('mountainview_the_post_navigation')){
    function mountainview_the_post_navigation(){

        the_post_navigation(array(
            'next_text' => '<div class="next"><div class="title"><span class="meta-nav" aria-hidden="true">' . esc_html__('Next', 'mountainview') . '</span> ' .
                '<span class="screen-reader-text">' . esc_html__('Next', 'mountainview') . '</span> ' .
                '<span class="post-title">%title</span></div>'.
                '</div> ',
            'prev_text' => '<div class="previous"><div class="title"><span class="meta-nav" aria-hidden="true">' . esc_html__('Previous', 'mountainview') . '</span> ' .
                '<span class="screen-reader-text">' . esc_html__('Previous', 'mountainview') . '</span> ' .
                '<span class="post-title">%title</span></div>'.
                '</div>'
        ));

    }
}




if(!function_exists('mountainview_child_pages_simple_grid')){
    function mountainview_child_pages_simple_grid(){
        global $post;
        $args   = apply_filters( 'mountainview_child_pages_simple_list_args', array(
                'post_type'      => 'page',
                'posts_per_page' => - 1,
                'post_parent'    => $post->ID,
                'order'          => 'ASC',
                'orderby'        => 'menu_order'
            )
        );
        $parent = new WP_Query( $args );
        if ( $parent->have_posts() ) :?>
            <div class="child-pages-simple-grid">
                <?php
                while ($parent->have_posts()):
                    $parent->the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-wrapper">
                            <a href="<?php the_permalink();?>">
                            <?php
                            if(has_post_thumbnail()):
                                ?>
                                <div  class="post-thumbnail">
                                    <?php
                                        the_post_thumbnail();
                                    ?>
                                </div>
                                <?php
                            endif;
                            the_title( '<h2 class="entry-title">', '</h2>' );
                            ?>
                            </a>
                        </div>
                    </article>
                <?php
                endwhile;
                ?>
            </div>
        <?php
        endif;
        wp_reset_query();

    }
}
