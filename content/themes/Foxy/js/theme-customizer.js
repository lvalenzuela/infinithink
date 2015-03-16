/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	wp.customize( 'et_foxy[link_color]', function( value ) {
		value.bind( function( to ) {
			$( 'a' ).css( 'color', to );
		} );
	} );

	wp.customize( 'et_foxy[font_color]', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).css( 'color', to );
		} );
	} );

	wp.customize( 'et_foxy[slider_bg]', function( value ) {
		value.bind( function( to ) {
			$( '#featured' ).css( 'background-color', to );
		} );
	} );

	wp.customize( 'et_foxy[slider_shadow]', function( value ) {
		value.bind( function( to ) {
			$( '#featured' ).css( 'box-shadow', 'inset 0 0 250px ' + to );
		} );
	} );

	wp.customize( 'et_foxy[button_bg]', function( value ) {
		value.bind( function( to ) {
			$( '#top-navigation > ul > li.sfHover > a, #top-navigation > ul > li > a:hover, .mobile_nav, #home-tab-area > ul > li.home-tab-active, #footer-bottom li a:hover, .et-product:hover .et-price-button, .et-products li:hover .et-price-button, #callout' ).css( 'background-color', to );
		} );
	} );

	wp.customize( 'et_foxy[button_shadow]', function( value ) {
		value.bind( function( to ) {
			$( '#top-navigation > ul > li.sfHover > a, #top-navigation > ul > li > a:hover, #home-tab-area > ul > li.home-tab-active, #footer-bottom li a:hover, .mobile_nav, #callout' ).css( 'box-shadow', 'inset 0 0 30px ' + to );
		} );
	} );

	wp.customize( 'et_foxy[widget_highlight]', function( value ) {
		value.bind( function( to ) {
			$( '#progress-time' ).css( 'background-color', to );
			$( '#home-tab-area > ul, .widget h4.widgettitle' ).css( 'border-bottom-color', to );
		} );
	} );

	wp.customize( 'et_foxy[color_schemes]', function( value ) {
		value.bind( function( to ) {
			var $body = $( 'body' ),
				body_classes = $body.attr( 'class' ),
				et_customizer_color_scheme_prefix = 'et_color_scheme_',
				body_class;

			body_class = body_classes.replace( /et_color_scheme_[^\s]+/, '' );
			$body.attr( 'class', $.trim( body_class ) );

			if ( 'none' !== to  )
				$body.addClass( et_customizer_color_scheme_prefix + to );
		} );
	} );
} )( jQuery );