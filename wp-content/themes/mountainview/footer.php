<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mountainview
 */

?>

        </div><!-- #content -->

        <?php
            get_sidebar('footer');
        ?>

        <footer id="colophon" class="site-footer">
            <div class="footer-wrapper">
                <div class="site-info">
                    <?php
                    $dateObj = new DateTime;
                    $year    = $dateObj->format( "Y" );
                    $site_info =  sprintf( esc_html__('&copy; %1$s %2$s', 'mountainview'), $year, get_bloginfo('name') );
                    echo apply_filters('mountainview_site_info_footer', $site_info);
                    ?>
                </div><!-- .site-info -->
                <?php
            if(has_nav_menu('menu-4')){
                wp_nav_menu(array(
                    'theme_location' => 'menu-4',
                    'menu_id'        => 'footer-menu',
                    'menu_class' => 'footer-menu',
                    'container_class' => 'menu-footer-container',
                    'depth' => 1
                ));
            }

            ?>
            </div>
        </footer><!-- #colophon -->
    </div><!-- .site-wrapper -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
