/**
 * Azuma Custom JS
 *
 * @package Azuma
 *
 * Distributed under the MIT license - http://opensource.org/licenses/MIT
 */
jQuery(document).ready(function($){
    // Defining a function to adjust mobile menu and search icons position if we have a large Top Bar widget area
    function fullscreen(){

        if ( $('#wpadminbar').length ) {
            var adminbarheight = parseInt( $('#wpadminbar').outerHeight() );
            $('#masthead').css({'top' : adminbarheight + 'px'});
        }

        if ( $('#masthead.full').length ) {
            var mastfullheight = parseInt( $('#masthead').outerHeight() );
            $('.entry-header.full .title-meta-wrapper, .archive-header.full .title-meta-wrapper').css({'padding-top' : mastfullheight + 'px'});
        }

        var footerheight = parseInt( $('#colophon').height() );
        footerheight = footerheight - 1;
        $('#page.sticky-footer').css({'padding-bottom' : footerheight + 'px'});

        if ( ! $('#primary-menu').length ) {
            $('.toggle-nav').css({'display' : 'none'});
        }

        var windowWidth = parseInt( $('body').width() );
        var heroTitleFontSize = parseInt(windowWidth / 25);
        var heroCaptionFontSize = parseInt(windowWidth / 70);
        if (heroTitleFontSize < 10) {
            heroTitleFontSize = 10;
        }
        if (heroCaptionFontSize < 10) {
            heroCaptionFontSize = 10;
        }
        $('#home-hero-section .widget_media_image .hero-widget-title').css({'font-size' : heroTitleFontSize + 'px'});
        $('#home-hero-section .widget_media_image .wp-caption .wp-caption-text').css({'font-size' : heroCaptionFontSize + 'px'});

        $('#home-hero-section').find('.widget_media_image').each(function(){
            var heroTitleMar = false;
            if ( $('#masthead.full').length && $('.hero-widget-title', this).length ) {
                var mastheadHeight = parseInt( $('#masthead').outerHeight() );
                var heroTitleMarginTop = parseInt(mastheadHeight / 2);
                $('.hero-widget-title', this).css({'margin-top' : heroTitleMarginTop + 'px'});
                heroTitleMar = true;
            }
            var heroTitleHeight = parseInt( $('.hero-widget-title', this).height() );
            var captionMargin = parseInt( ( heroTitleHeight / 2 ) + heroCaptionFontSize );
            if ( heroTitleMar == true ) {
                captionMargin = captionMargin + heroTitleMarginTop;
            }
            $('.wp-caption-text', this).css({'margin-top' : captionMargin + 'px'});
        });

        jQuery('ul.products').imagesLoaded(function () {
            $('ul.products').find('li.product .product-wrap').each(function(){
                var imageHeight = parseInt( $('> a > img', this).height() );
                $('.product-excerpt-wrap', this).css({'height' : imageHeight + 'px'});
            });
        });

        jQuery('.edd_downloads_list').imagesLoaded(function () {
            $('.edd_downloads_list').find('.edd_download .edd_download_inner').each(function(){
                var imageHeight = parseInt( $('> .edd_download_image > a > img', this).height() );
                $('.edd_download_excerpt', this).css({'height' : imageHeight + 'px'});
            });
        });

    }
  
    fullscreen();

    // Run the function in case of window resize
    jQuery(window).resize(function() {
        fullscreen();         
    });

});

jQuery(function($){

    $(window).scroll(function(){
        var scrollTop = $(this).scrollTop();
        var masthead = parseInt( $('#masthead').height() );
        if ( $('#home-hero-section').length ) {
            var contentElement = '#hero-above-wrapper';
        } else {
            var contentElement = '.site-content';
        }
        if( scrollTop > 0 ){
            $('#masthead').addClass('scrolled');
            if ( $('#masthead.not-full').length ) {
                $(contentElement).css({'padding-top' : masthead + 'px'});
            }
        }else{
            $('#masthead').removeClass('scrolled');
            if ( $('#masthead.not-full').length ) {
                $(contentElement).css({'padding-top' : '0'});
            }
        }
    });

    var count_hero_images = $('#home-hero-section .widget_media_image').length;
    if ( count_hero_images > 1 ) {
        $('#home-hero-section').addClass('bx-slider');
    }

    $('.bx-slider').bxSlider({
        'pager': true,
        'auto' : true,
        'mode' : 'fade',
        'pause' : 7000,
        'controls' : false,
        'adaptiveHeight' : true,
    });

    $('#home-hero-section .widget_media_image').each(function(){
        var MediaWidgetTitle = $('.hero-widget-title', this).html();
        var MediaWidgetHref = $('a', this).attr('href');
        if ( MediaWidgetHref ) {
            $('.hero-widget-title', this).html('<a href="' + MediaWidgetHref + '">' + MediaWidgetTitle + '</a>');
        }
    });

    if ( $('#home-hero-section').length ) {
        var siteContentHeight = parseInt( $('.site-content').height() );
        if ( siteContentHeight < 1 ) {
            $('.site-content').css({'margin-top' : '0'});
        }
    }

    // WooCommerce sticky add-to-cart panel
    if ( $('.woocommerce div.product form.cart').length ) {
    
        $(window).scroll(function(){
            var scrollTop = $(this).scrollTop();
            var targetTop = $(".woocommerce div.product form.cart").offset().top;
            if( scrollTop > targetTop ){
                var mastheadHeight = parseInt( $('#masthead').outerHeight() );
                $('#wc-sticky-addtocart').addClass('active');
                jQuery('#wc-sticky-addtocart').css({
                    'top' : mastheadHeight + 'px'
                });
            }else{
                $('#wc-sticky-addtocart').removeClass('active');
            }
        });

        $( '#wc-sticky-addtocart .options-button' ).click( function() {
            $( '#wc-sticky-addtocart table.variations' ).toggleClass( 'active' );
            $( this ).toggleClass( 'active' );
        });
    
    }

    // WooCommerce quantity buttons
    jQuery('div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)').addClass('buttons_added').append('<input type="button" value="+" class="plus" />').prepend('<input type="button" value="-" class="minus" />');

    // Target quantity inputs on product pages
    jQuery('input.qty:not(.product-quantity input.qty)').each( function() {
        var min = parseFloat( jQuery( this ).attr('min') );

        if ( min && min > 0 && parseFloat( jQuery( this ).val() ) < min ) {
            jQuery( this ).val( min );
        }
    });

    jQuery( document ).on('click', '.plus, .minus', function() {

        // Get values
        var $qty        = jQuery( this ).closest('.quantity').find('.qty'),
            currentVal  = parseFloat( $qty.val() ),
            max         = parseFloat( $qty.attr('max') ),
            min         = parseFloat( $qty.attr('min') ),
            step        = $qty.attr('step');

        // Format values
        if ( ! currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
        if ( max === '' || max === 'NaN') max = '';
        if ( min === '' || min === 'NaN') min = 0;
        if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN') step = 1;

        // Change the value
        if ( jQuery( this ).is('.plus') ) {

            if ( max && ( max == currentVal || currentVal > max ) ) {
                $qty.val( max );
            } else {
                $qty.val( currentVal + parseFloat( step ) );
            }

        } else {

            if ( min && ( min == currentVal || currentVal < min ) ) {
                $qty.val( min );
            } else if ( currentVal > 0 ) {
                $qty.val( currentVal - parseFloat( step ) );
            }

        }

        // Trigger change event
        $qty.trigger('change');
    });

    if ( $('.mini-account p.username-wrap').length ) {
        $('.mini-account p.username-wrap').html($('.mini-account p.username-wrap').html().replace('(','<br>('));
    }

    $( '.top-search .azuma-icon-search' ).on( 'click', function(e) {
        $( '.top-search' ).toggleClass( 'search-open' );
    });

    // Mobile Menu
    $('#primary-menu .menu-item-has-children').prepend('<span class="sub-trigger"></span>');

    $( '.toggle-nav' ).click( function() {
        $( this ).toggleClass( 'menu-open' );
        $( '#site-navigation' ).toggleClass( 'menu-open' );
    });
    $( '.sub-trigger' ).click( function() {
        $( this ).toggleClass( 'is-open' );
        $( this ).siblings( '.sub-menu' ).toggle( 300 );
    });

    $( '.shop-filter-wrap .shop-filter-toggle' ).click( function() {
        $( '.shop-filter-wrap #shop-filters' ).toggleClass( 'active' );
        $( this ).toggleClass( 'active' );
    });

    $( '.top-account .mini-account input' ).focusin( function() {
        $( '.top-account .mini-account' ).addClass( 'locked' );
    }).add( '.top-account .mini-account' ).focusout( function() {
        if ( !$( '.top-account .mini-account' ).is( ':focus' ) ) {
            $( '.top-account .mini-account' ).removeClass( 'locked' );
        }
    });

    $( '#primary-menu li.menu-item-has-children' ).focusin( function() {
        $( this ).addClass( 'locked' );
    }).add( this ).focusout( function() {
        if ( !$( this ).is( ':focus' ) ) {
            $( this ).removeClass( 'locked' );
        }
    });

    $( '.top-account #customer_login .u-column2 h2' ).click( function() {
        $( '.top-account #customer_login .u-column2' ).toggleClass( 'open' );
    });

    $( '.top-account #edd_register_form legend' ).click( function() {
        $( '.top-account #edd_register_form' ).toggleClass( 'open' );
    });

});

jQuery( document ).ready( function( $ ){
    $(document).on( 'added_to_wishlist removed_from_wishlist', function(){
        var counter = $('.wishlist_products_counter_number');

        $.ajax({
            url: yith_wcwl_l10n.ajax_url,
            data: {
                action: 'yith_wcwl_update_wishlist_count'
            },
            dataType: 'json',
            success: function( data ){
                counter.html( data.count );
            }
        })
    } )
});

jQuery( document ).ready( function( $ ){

    $('ul#primary-menu.demo-menu li').find('ul').each(function(){
        if( $(this).hasClass('children') ){
            $(this).parent().addClass('menu-item-has-children');
            $('#primary-menu .menu-item-has-children').prepend('<span class="sub-trigger"></span>');

            $( '.sub-trigger' ).click( function() {
                $( this ).toggleClass( 'is-open' );
                $( this ).siblings( 'ul#primary-menu.demo-menu > li > ul.children' ).toggle( 300 );
            });

        }
    });
});