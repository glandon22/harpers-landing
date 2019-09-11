/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */

(function ($) {

    "use strict";

    var body, masthead, menuToggle, siteNavigation, socialNavigation, siteHeaderMenu, resizeTimer;

    function initMainNavigation(container) {
        // Add dropdown toggle that displays child menu items.
        var dropdownToggle = $('<button />', {
            'class': 'dropdown-toggle',
            'aria-expanded': false
        });

        container.find('.menu-item-has-children > a').after(dropdownToggle);

        // Toggle buttons and submenu items with active children menu items.
        container.find('.current-menu-ancestor > button').addClass('toggled-on');
        container.find('.current-menu-ancestor > .sub-menu').addClass('toggled-on');

        // Add menu items with submenus to aria-haspopup="true".
        container.find('.menu-item-has-children').attr('aria-haspopup', 'true');

        container.find('.dropdown-toggle').click(function (e) {
            var _this = $(this);
            // screenReaderSpan = _this.find('.screen-reader-text');

            e.preventDefault();

            _this.toggleClass('toggled-on');
            _this.next('.children, .sub-menu').toggleClass('toggled-on');

            // jscs:disable
            _this.attr('aria-expanded', _this.attr('aria-expanded') === 'false' ? 'true' : 'false');
            // jscs:enable
            // screenReaderSpan.text(screenReaderSpan.text() === screenReaderText.expand ? screenReaderText.collapse : screenReaderText.expand);
        });
    }

    $(document).ready(function (e) {
        initMainNavigation($('.main-navigation'));
    });

    $(document).ready(function (e) {
        masthead = $('#masthead');
        menuToggle = masthead.find('.menu-toggle');
        // Return early if menuToggle is missing.
        // console.log(1);
        if (!menuToggle.length) {
            return;
        }

        // console.log(1);
        // Add an initial values for the attribute.
        menuToggle.add(siteNavigation).add(socialNavigation).attr('aria-expanded', 'false');

        menuToggle.on('click', function () {
            // console.log('test');
            $(this).add(siteHeaderMenu).toggleClass('toggled-on');
            $('.header-menu').toggleClass('menu-opened');
            //
            // // jscs:disable
            $(this).add(siteNavigation).add(socialNavigation).attr('aria-expanded', $(this).add(siteNavigation).add(socialNavigation).attr('aria-expanded') === 'false' ? 'true' : 'false');
            // // jscs:enable
        });
    })


    function subMenuPosition() {
        $('.sub-menu').each(function () {
            $(this).removeClass('toleft');
            if (($(this).parent().offset().left + $(this).parent().width() - $(window).width() + 178) > 0) {
                $(this).addClass('toleft');
            }
        });
    }


    subMenuPosition();
    /*
     *Search modal
     */

    $(window).resize(function () {
        subMenuPosition();
    });


    (function () {
        $(window).load(function () {
            $('.jetpack-testimonial-shortcode').each(function () {
                $('.textwidget').flexslider({
                    animation: "slide",
                    directionNav:true,
                    controlNav: false,
                    //smoothHeight:true,
                    keyboard:false,
                    slideshow:false,
                    selector:'.jetpack-testimonial-shortcode > .testimonial-entry',
                    start: function(){
                        $('.textwidget .jetpack-testimonial-shortcode a').attr('tabindex',"-1")
                        // absoluteBackgroundPosition();
                    }

                });
            });

        });

    })();

})(jQuery);