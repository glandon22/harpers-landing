<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mountainview
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'mountainview' ); ?></a>

    <div class="site-wrapper">
        <?php
        $header_class = '';
        if( (is_home() || is_front_page()) && !has_nav_menu('menu-1')){
            $header_class = 'no-menu';
        }
        ?>
        <header id="masthead" class="site-header <?php echo esc_attr($header_class);?>">

            <?php
            $branding_classes = '';
            if(!has_custom_logo()){
                $branding_classes ='no-logo';
            }
            ?>
            <div class="site-branding <?php echo esc_attr($branding_classes);?>">
                <?php
                the_custom_logo();
                ?>
                <div class="site-branding-wrapper">
                    <?php
                    if ( is_front_page() && is_home() ) :
                        ?>
                        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                        <?php
                    else :
                        ?>
                        <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                        <?php
                    endif;
                    $mountainview_description = get_bloginfo( 'description', 'display' );
                    if ( $mountainview_description || is_customize_preview() ) :
                        ?>
                        <p class="site-description"><?php echo esc_html($mountainview_description); /* WPCS: xss ok. */ ?></p>
                    <?php endif; ?>
                </div>
            </div><!-- .site-branding -->
            <?php
            if(has_nav_menu('menu-2') || has_nav_menu('menu-3') || has_nav_menu('menu-1')):
            ?>
                <div class="header-menus">
                <?php
                if(has_nav_menu('menu-2') || has_nav_menu('menu-3')):
                    ?>
                    <div class="header-top-bar">
                        <div class="header-top-menus-wrapper">
                            <?php
                            if(has_nav_menu('menu-2')){
                                wp_nav_menu(array(
                                    'theme_location' => 'menu-2',
                                    'container_class' => 'additional-navigation',
                                    'menu_id' => 'tol-left',
                                    'depth' => 1
                                ));
                            }
                            if(has_nav_menu('menu-3')){
                                wp_nav_menu(array(
                                    'theme_location' => 'menu-3',
                                    'container_class' => 'social-menu',
                                    'menu_id' => 'socials',
                                    'menu_class' => 'theme-social-menu',
                                    'depth' => 1,
                                    'link_before'     => '<span class="menu-text">',
                                    'link_after'      => '</span>',
                                ));
                            }
                            ?>
                        </div>
                    </div>
                <?php
                endif;

                if(has_nav_menu('menu-1')):
                ?>
                <nav id="site-navigation" class="main-navigation">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><i class="fa fa-bars"></i><?php esc_html_e( 'Menu', 'mountainview' ); ?></button>
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'menu-1',
                        'menu_id'        => 'primary-menu',
                        'menu_class' => 'primary-menu',
                        'container_class' => 'menu-primary-container'
                    ) );
                    ?>
                </nav><!-- #site-navigation -->
                <?php
                endif;
                ?>
                </div>
            <?php
            endif;
            ?>
            <div class="header-image">
                <?php
                    mountainview_header_image();
                ?>
            </div>
        </header><!-- #masthead -->

        <div id="content" class="site-content">
