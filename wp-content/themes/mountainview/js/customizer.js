/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

    var style = $( '#oceanica-color-scheme-css' );

    if ( ! style.length ) {
        style = $( 'head' ).append( '<style type="text/css" id="oceanica-color-scheme-css" />' )
            .find( '#oceanica-color-scheme-css' );
    }
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );

	wp.customize( 'mountainview_branding_background', function (value) {
		value.bind( function (to) {
			$('.site-branding').css('background', to);
        });
    });
    wp.customize( 'brand_color', function (value) {
        value.bind( function ( to ) {
            var style, el;

			style = '<style class="custom-preview-brand-color">'+
                'h1:before, h2:before, h3:before, h4:before, h5:before, h6:before,'+
                'blockquote:before,'+
                'code, kbd, tt, var,'+
            	'button,'+
                'input[type="button"],'+
                'input[type="reset"],'+
                'input[type="submit"],'+
				'.button,'+
				'.more-link,'+
				'.main-navigation a:after,'+
				'.page-header .page-title:before,'+
				'.jetpack-testimonial-shortcode .testimonial-featured-image:after,'+
				'.textwidget .flex-direction-nav a:hover,'+
				'body.archive .site-main .jetpack-testimonial .post-thumbnail:after'+
					'{'+
                	'background: '+to+';'+
				'}'+
            	'button,'+
                'input[type="button"],'+
                'input[type="reset"],'+
                'input[type="submit"],'+
				'.button,'+
				'.more-link'+
					'{'+
						'border-color: '+to+';'+
				'}'+
				'a, a:hover, a:focus, a:active,'+
				'.main-navigation a:hover,'+
				'.main-navigation .current_page_item > a,'+
				'.main-navigation .current-menu-item > a,'+
				'.main-navigation .current_page_ancestor > a,'+
				'.main-navigation .current-menu-ancestor > a,'+
				'.menu-toggle:hover, .menu-toggle:active, .menu-toggle:focus,'+
				'.additional-navigation ul li a:hover,'+
				'.social-menu ul li a:hover,'+
				'.navigation.post-navigation .nav-previous:hover .title .post-title,'+
				'.navigation.post-navigation .nav-next:hover .title .post-title,'+
				'.search-form .search-controls button:hover,'+
				'.front-page-bottom-sidebars ul li:before,'+
				'body.blog .hentry .entry-title a:hover,'+
				'body.archive .hentry .entry-title a:hover,'+
				'body.search .hentry .entry-title a:hover,'+
				'body.blog .hentry .entry-footer .entry-meta > span a:hover, body.blog .hentry .entry-footer > span a:hover,'+
				'body.archive .hentry .entry-footer .entry-meta > span a:hover,'+
				'body.archive .hentry .entry-footer > span a:hover,'+
				'body.search .hentry .entry-footer .entry-meta > span a:hover,'+
				'body.search .hentry .entry-footer > span a:hover,'+
				'body.blog .hentry .entry-footer .featured-post,'+
				'body.archive .hentry .entry-footer .featured-post,'+
				'body.search .hentry .entry-footer .featured-post,'+
				'.child-pages-grid .page .entry-title a:hover,'+
				'.child-pages-simple-grid .page:hover .entry-title,'+
                '.mphb-calendar .datepick-ctrl a,'+
				'.datepick-popup .datepick-ctrl a,'+
				'.datepick-popup .mphb-datepick-popup .datepick-month td .datepick-today,'+
				'.mphb_sc_search_results-wrapper .mphb-room-type-title a:hover,'+
				'.mphb_sc_rooms-wrapper .mphb-room-type-title a:hover,'+
				'.mphb_sc_room-wrapper .mphb-room-type-title a:hover,'+
				'.widget-area .mphb-widget-room-type-title a:hover,'+
				'.additional-navigation ul li a:hover'+
            	'{'+
						'color: '+to+';'+
					'}'+
				'.navigation.pagination .nav-links .page-numbers:not(.current):hover {'+
					'background: '+to+';'+
					'border-left: 1px solid '+to+';'+
					'border-top: 1px solid '+to+';'+
					'border-bottom: 1px solid '+to+';'+
				'}'+
				'.tagcloud a:hover {'+
						'background: '+to+';'+
						'border: 1px solid '+to+';'+
				'}'+
				'.flex-control-paging li a.flex-active, .flex-control-paging li a:hover{'+
						'background: '+to+';'+
						'border-color: '+to+';'+
				'}'+
				'.mphb-calendar.mphb-datepick .datepick-month td .datepick-selected,'+
				'.datepick-popup .mphb-datepick-popup .datepick-month td .datepick-selected,'+
				'.datepick-popup .mphb-datepick-popup .datepick-month td a.datepick-highlight'+
					'{'+
						'background-color: '+to+';'+
					'}'+
				'.social-menu ul li a:hover:before'+
					'{'+
						'background: '+to+';'+
					'}'+
            '</style>';

			el = $('.custom-preview-brand-color');
            if ( el.length ) {
                el.replaceWith( style ); // style element already exists, so replace it
            } else {
                $( 'head' ).append( style ); // style element doesn't exist so add it
            }

        });
	});


    wp.customize( 'brand_color_hover', function (value) {
		value.bind(function (to) {
            var style, el;

            style = '<style class="custom-preview-secondary-color">'+
                'button:hover,'+
                'input[type="button"]:hover,'+
                'input[type="reset"]:hover,'+
                'input[type="submit"]:hover,'+
				'.button:hover,'+
				'.more-link:hover,'+
                'button:active, button:focus,'+
                'input[type="button"]:active,'+
                'input[type="button"]:focus,'+
                'input[type="reset"]:active,'+
                'input[type="reset"]:focus,'+
                'input[type="submit"]:active,'+
                'input[type="submit"]:focus,'+
				'.button:active,'+
				'.button:focus,'+
				'.more-link:active,'+
				'.more-link:focus'+
				'{'+
					'border-color: '+to+';'+
					'background: '+to+';'+
				'}'+
                '</style>';

            el = $('.custom-preview-secondary-color');
            if ( el.length ) {
                el.replaceWith( style ); // style element already exists, so replace it
            } else {
                $( 'head' ).append( style ); // style element doesn't exist so add it
            }
        });
    });


    wp.customize( 'main_text_color', function (value) {
        value.bind(function (to) {
            var style, el;

            style = '<style class="custom-preview-text-color">'+
                'body,'+
                'button,'+
                'input,'+
                'select,'+
                'optgroup,'+
                'textarea,'+
				'.additional-navigation ul li a,'+
				'.social-menu ul li a,'+
				'.navigation.post-navigation .nav-previous .title .meta-nav,'+
				'.navigation.post-navigation .nav-next .title .meta-nav,'+
				'.tagcloud a,'+
				'.header-image .page-heading-wrapper.no-image .breadcrumbs,'+
				'.mphb_checkout-services-list li label,'+
				'.mphb_sc_checkout-services-list li label,'+
				'.mphb-rate-chooser .mphb-room-rate-variant label,'+
				'.mphb-gateways-list .mphb-gateway label,'+
				'.front-page-top-sidebar .front-page-main-widget-area'+
				'{'+
					'color: '+to+';'+
				'}'+
                '</style>';

            el = $('.custom-preview-text-color');
            if ( el.length ) {
                el.replaceWith( style ); // style element already exists, so replace it
            } else {
                $( 'head' ).append( style ); // style element doesn't exist so add it
            }
        });
    });


} )( jQuery );
