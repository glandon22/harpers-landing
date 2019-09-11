<?php
/**
 * Mountainview Theme Customizer
 *
 * @package Mountainview
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mountainview_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'mountainview_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'mountainview_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'mountainview_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function mountainview_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function mountainview_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function mountainview_customize_preview_js() {
	wp_enqueue_script( 'mountainview-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'jquery', 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'mountainview_customize_preview_js' );


function mountainview_customizer_add_settings($wp_customize){

    $default_colors = mountainview_get_default_colors();

    $wp_customize->add_setting('mountainview_branding_background', array(
        'default' => $default_colors['main'],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'mountainview_branding_background',
            array(
                'label'      => esc_html__( 'Site Title Background', 'mountainview' ),
                'section'    => 'colors',
                'settings'   => 'mountainview_branding_background',
            ) )
    );

    /**
     * Booking settings
     */
    if(class_exists('HotelBookingPlugin')) {

        $wp_customize->add_section('mountainview_booking', array(
            'title' => esc_html__('Booking Options', 'mountainview'),
            'priority' => 31,
        ));
        $wp_customize->add_setting('mountainview_accommodation_list_layout', array(
            'default' => 'default',
            'transport' => 'refresh',
            'type' => 'theme_mod',
            'sanitize_callback' => 'mountainview_sanitize_select'

        ));
        $wp_customize->add_control('mountainview_accommodation_list_layout', array(
            'label' => esc_html__('Accommodation Layouts', 'mountainview'),
            'type' => 'select',
            'section' => 'mountainview_booking',
            'choices' => array(
                'default' => esc_html__('Default', 'mountainview'),
                'grid' => esc_html__('Grid', 'mountainview'),
                'list' => esc_html__('List', 'mountainview'),
            ),
            'settings' => 'mountainview_accommodation_list_layout'

        ));
    }

    $wp_customize->add_setting('main_text_color', array(
        'default' => $default_colors['text'],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'main_text_color', array(
        'label' => esc_html__('Text Color', 'mountainview'),
        'section' => 'colors',
    )));

    // Add Brand color setting and control.
    $wp_customize->add_setting('brand_color', array(
        'default' => $default_colors['main'],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'brand_color', array(
        'label' => esc_html__('Main Color', 'mountainview'),
        'section' => 'colors',
    )));

    // Add Hover Brand color setting and control.
    $wp_customize->add_setting('brand_color_hover', array(
        'default' => $default_colors['secondary'],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'brand_color_hover', array(
        'label' => esc_html__('Button Hover Color', 'mountainview'),
        'section' => 'colors',
    )));

}
add_action('customize_register','mountainview_customizer_add_settings');



function mountainview_sanitize_select( $input, $setting ){

    //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
    $input = sanitize_key($input);

    //get the list of possible select options
    $choices = $setting->manager->get_control( $setting->id )->choices;

    //return input if valid or return default option
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

}


function mountainview_get_default_colors(){
    return apply_filters('mountainview_default_colors', array(
        'main' => '#7db900',
        'secondary' => '#9ad819',
        'text' => '#383838'
    ));
}



function mountainview_logo_background_css(){

    $default_colors = mountainview_get_default_colors();
    $branding_color = get_theme_mod('mountainview_branding_background', $default_colors['main']);

    if(get_theme_mod('mountainview_branding_background') === $default_colors['main']){
        return;
    }

    $style = "
        .site-branding{
            background: {$branding_color};
        }
    ";

    wp_add_inline_style('mountainview-style', $style);
}

add_action('wp_enqueue_scripts', 'mountainview_logo_background_css');

function mountainview_brand_color_css(){
    $default_colors = mountainview_get_default_colors();
    $brand_color = get_theme_mod('brand_color', $default_colors['main']);

    if( $brand_color === $default_colors['main']){

        return;
    }
    $css = '
        h1:before, h2:before, h3:before, h4:before, h5:before, h6:before,
        blockquote:before,
        code, kbd, tt, var,
        button,
        input[type="button"],
        input[type="reset"],
        input[type="submit"],
        .button,
        .more-link,
        .main-navigation a:after,
        .page-header .page-title:before,
        .wp-block-button__link,                
        .wp-block-file .wp-block-file__button
        {
            background: '.$brand_color.';
        }
        button,
        input[type="button"],
        input[type="reset"],
        input[type="submit"],
        .button,
        .more-link
        {
            border-color: '.$brand_color.';
        }
        a, a:hover, a:focus, a:active,
        .main-navigation a:hover,
        .main-navigation .current_page_item > a,
        .main-navigation .current-menu-item > a,
        .main-navigation .current_page_ancestor > a,
        .main-navigation .current-menu-ancestor > a,
        .menu-toggle:hover, .menu-toggle:active, .menu-toggle:focus,
        .additional-navigation ul li a:hover,
        .social-menu ul li a:hover,
        .navigation.post-navigation .nav-previous:hover .title .post-title,
        .navigation.post-navigation .nav-next:hover .title .post-title,
        .search-form .search-controls button:hover,
        .front-page-bottom-sidebars ul li:before,
        body.blog .hentry .entry-title a:hover,
        body.archive .hentry .entry-title a:hover,
        body.search .hentry .entry-title a:hover,
        body.blog .hentry .entry-footer .entry-meta > span a:hover, body.blog .hentry .entry-footer > span a:hover,
        body.archive .hentry .entry-footer .entry-meta > span a:hover,
        body.archive .hentry .entry-footer > span a:hover,
        body.search .hentry .entry-footer .entry-meta > span a:hover,
        body.search .hentry .entry-footer > span a:hover,
        body.blog .hentry .entry-footer .featured-post,
        body.archive .hentry .entry-footer .featured-post,
        body.search .hentry .entry-footer .featured-post,
        .child-pages-grid .page .entry-title a:hover,
        .child-pages-simple-grid .page:hover .entry-title,
        .additional-navigation ul li a:hover,        
        .wp-block-button.is-style-outline                
        {
            color: '.$brand_color.';
        }
        .navigation.pagination .nav-links .page-numbers:not(.current):hover {
            background: '.$brand_color.';            
            border-left: 1px solid '.$brand_color.';
            border-top: 1px solid '.$brand_color.';
            border-bottom: 1px solid '.$brand_color.';
        }
        .tagcloud a:hover {            
            background: '.$brand_color.';
            border: 1px solid '.$brand_color.';
        }        
        .social-menu ul li a:hover:before {
            background: '.$brand_color.';
        }
    ';

    wp_add_inline_style('mountainview-style', $css);

    if( defined( 'JETPACK__VERSION' ) ) {
        $jetpack_css = '
            .jetpack-testimonial-shortcode .testimonial-featured-image:after,
            .textwidget .flex-direction-nav a:hover,
            body.archive .site-main .jetpack-testimonial .post-thumbnail:after
            {
                background: '.$brand_color.';
            }
        ';
        wp_add_inline_style('mountainview-jetpack', $jetpack_css);
    }
    if ( class_exists( 'HotelBookingPlugin' ) ) {
        $mphb_css = '
            .mphb-calendar .datepick-ctrl a,
            .datepick-popup .datepick-ctrl a,
            .datepick-popup .mphb-datepick-popup .datepick-month td .datepick-today,
            .mphb_sc_search_results-wrapper .mphb-room-type-title a:hover,
            .mphb_sc_rooms-wrapper .mphb-room-type-title a:hover,
            .mphb_sc_room-wrapper .mphb-room-type-title a:hover,
            .widget-area .mphb-widget-room-type-title a:hover 
            {
                color: '.$brand_color.';
            }
            .flex-control-paging li a.flex-active, .flex-control-paging li a:hover{
                background: '.$brand_color.';
                border-color: '.$brand_color.';
            }        
            .mphb-calendar.mphb-datepick .datepick-month td .datepick-selected,
            .datepick-popup .mphb-datepick-popup .datepick-month td .datepick-selected,
            .datepick-popup .mphb-datepick-popup .datepick-month td a.datepick-highlight
            {
                background-color: '.$brand_color.';
            }
        ';
        wp_add_inline_style('mountainview-mphb', $mphb_css);
    }
}

add_action('wp_enqueue_scripts', 'mountainview_brand_color_css');


function montainciev_secondary_color_css(){

    $default_colors = mountainview_get_default_colors();
    $secondary_color = get_theme_mod('brand_color_hover', $default_colors['secondary']);

    if( $secondary_color === $default_colors['secondary']){
        return;
    }

    $css = '
        button:hover,
        input[type="button"]:hover,
        input[type="reset"]:hover,
        input[type="submit"]:hover,
        .button:hover,
        .more-link:hover,
        button:active, button:focus,
        input[type="button"]:active,
        input[type="button"]:focus,
        input[type="reset"]:active,
        input[type="reset"]:focus,
        input[type="submit"]:active,
        input[type="submit"]:focus,
        .button:active,
        .button:focus,
        .more-link:active,
        .more-link:focus
        {
            border-color: '.$secondary_color.';
            background: '.$secondary_color.';
        }
        .wp-block-button.is-style-outline .wp-block-button__link:hover,
        .wp-block-button.is-style-outline .wp-block-button__link:focus,
        .wp-block-button__link:hover,                
        .wp-block-button__link:focus,                
        .wp-block-file .wp-block-file__button:hover, 
        .wp-block-file .wp-block-file__button:focus 
        {
            border-color: '.$secondary_color.' !important;
            background: '.$secondary_color.' !important;
        }
    ';

    wp_add_inline_style('mountainview-style', $css);
}

add_action('wp_enqueue_scripts', 'montainciev_secondary_color_css');


function mountainview_main_text_color(){
    $default_colors = mountainview_get_default_colors();
    $text_color = get_theme_mod('main_text_color', $default_colors['text']);

    if( $text_color === $default_colors['text']){
        return;
    }

    $css = '
        body,
        button,
        input,
        select,
        optgroup,
        textarea,
        .additional-navigation ul li a,
        .social-menu ul li a,
        .navigation.post-navigation .nav-previous .title .meta-nav,
        .navigation.post-navigation .nav-next .title .meta-nav,
        .tagcloud a,
        .header-image .page-heading-wrapper.no-image .breadcrumbs,
        .front-page-top-sidebar .front-page-main-widget-area                  
        {
            color: '.$text_color.';
        }
    ';

    wp_add_inline_style('mountainview-style', $css);

    if ( class_exists( 'HotelBookingPlugin' ) ) {
        $mphb_css = '
            .mphb_checkout-services-list li label, 
            .mphb_sc_checkout-services-list li label,
            .mphb-rate-chooser .mphb-room-rate-variant label,
            .mphb-gateways-list .mphb-gateway label          
            {
                color: ' . $text_color . ';
            }
        ';
        wp_add_inline_style('mountainview-mphb', $mphb_css);
    }
}

add_action('wp_enqueue_scripts', 'mountainview_main_text_color');

function mountainview_generate_customizer_editor_css(){

    $css = '';

    $default_colors = mountainview_get_default_colors();
    $brand_color = get_theme_mod('brand_color', $default_colors['main']);

    if( $brand_color !== $default_colors['main']){

        $css .= '.editor-block-list__layout .editor-block-list__block a, 
            .editor-block-list__layout .editor-block-list__block a:hover, 
            .editor-block-list__layout .editor-block-list__block a:focus, 
            .editor-block-list__layout .editor-block-list__block a:active,
            .editor-block-list__layout .editor-block-list__block .wp-block-button.is-style-outline .wp-block-button__link
            {
                color: '.$brand_color.'
            }
            
            .editor-block-list__layout .editor-block-list__block .wp-block-button__link,
            .editor-block-list__layout .editor-block-list__block .wp-block-file .wp-block-file__button,
            .editor-block-list__layout .editor-block-list__block .wp-block-quote::before,
            .editor-block-list__layout .editor-block-list__block .wp-block-heading h1::before,
            .editor-block-list__layout .editor-block-list__block .wp-block-heading h2::before,
            .editor-block-list__layout .editor-block-list__block .wp-block-heading h3::before,
            .editor-block-list__layout .editor-block-list__block .wp-block-heading h4::before,
            .editor-block-list__layout .editor-block-list__block .wp-block-heading h5::before,
            .editor-block-list__layout .editor-block-list__block .wp-block-heading h6::before
            {
                background: '.$brand_color.';
            }
            ';

    }

    $secondary_color = get_theme_mod('brand_color_hover', $default_colors['secondary']);

    if( $secondary_color !== $default_colors['secondary']){

        $css .= '
            .editor-block-list__layout .editor-block-list__block .wp-block-button.is-style-outline .wp-block-button__link:hover,
            .editor-block-list__layout .editor-block-list__block .wp-block-button__link:hover,
            .editor-block-list__layout .editor-block-list__block .wp-block-file .wp-block-file__button:hover
            {
                background: '.$secondary_color.' !important;
            }
            
            .editor-block-list__layout .editor-block-list__block .wp-block-button.is-style-outline .wp-block-button__link:hover
            {
                border-color: '.$secondary_color.' !important;
            }
            
        ';

    }

    $text_color = get_theme_mod('main_text_color', $default_colors['text']);

    if( $text_color !== $default_colors['text']){

        $css .= '
        .editor-block-list__layout .editor-block-list__block {
            color: '.$text_color.';
        }
        ';

    }

    return $css;
}

function mountainview_editor_color_css()
{

    wp_enqueue_style('mountainview-editor-style', get_theme_file_uri( '/css/customizer-editor.css' ), false, mountainview_get_theme_version(), 'all' );
    wp_add_inline_style('mountainview-editor-style', mountainview_generate_customizer_editor_css());

}

add_action('enqueue_block_editor_assets', 'mountainview_editor_color_css');
