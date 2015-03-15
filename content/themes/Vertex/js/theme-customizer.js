/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	wp.customize( 'et_vertex[link_color]', function( value ) {
		value.bind( function( to ) {
			$( 'a' ).css( 'color', to );
		} );
	} );

	wp.customize( 'et_vertex[font_color]', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).css( 'color', to );
		} );
	} );

	wp.customize( 'et_vertex[accent_color_1]', function( value ) {
		value.bind( function( to ) {
			$( 'body, #top-menu, a.action-button, .skills li, .nav li ul, .et_mobile_menu, .description h2, .alt-description h2' ).css( 'background-color', to );
		} );
	} );

	wp.customize( 'et_vertex[accent_color_2]', function( value ) {
		value.bind( function( to ) {
			$( '.tagline, .et-zoom, a.more, .skill-amount, .description p.meta-info, .alt-description p.meta-info, #content-area .wp-pagenavi span.current, #content-area .wp-pagenavi a:hover, .comment-reply-link, .form-submit #submit' ).css( 'background-color', to );
			$( '.footer-widget li:before, .widget li:before' ).css( 'border-left-color', to );
		} );
	} );

	wp.customize( 'et_vertex[menu_link]', function( value ) {
		value.bind( function( to ) {
			$( '#top-menu a, .et_mobile_menu a' ).css( 'color', to );
		} );
	} );

	wp.customize( 'et_vertex[menu_link_active]', function( value ) {
		value.bind( function( to ) {
			$( '#top-menu li.current-menu-item > a, .et_mobile_menu li.current-menu-item > a' ).css( 'color', to );
		} );
	} );

	wp.customize( 'et_vertex[color_schemes]', function( value ) {
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