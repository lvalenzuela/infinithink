(function($){
	$.et_simple_slider = function(el, options) {
		var settings = $.extend( {
			slide         			: '.et-slide',				 	// slide class
			arrows					: '.et-slider-arrows',			// arrows container class
			prev_arrow				: '.et-arrow-prev',				// left arrow class
			next_arrow				: '.et-arrow-next',				// right arrow class
			controls 				: '.et-controllers a',			// control selector
			control_active_class	: 'et-active-control',			// active control class name
			previous_text			: 'Previous',					// previous arrow text
			next_text				: 'Next',						// next arrow text
			fade_speed				: 500,							// fade effect speed
			use_arrows				: true,							// use arrows?
			use_controls			: true,							// use controls?
			manual_arrows			: '',							// html code for custom arrows
			append_controls_to		: '',							// controls are appended to the slider element by default, here you can specify the element it should append to
			controls_class			: 'et-controllers',				// controls container class name
			slideshow				: false,						// automattic animation?
			slideshow_speed			: 7000,							// automattic animation speed
			show_progress_bar		: true,							// show progress bar if automattic animation is active
			tabs_animation			: false
		}, options );

		var $et_slider 			= $(el),
			$et_slide			= $et_slider.find( settings.slide ),
			et_slides_number	= $et_slide.length,
			et_fade_speed		= settings.fade_speed,
			et_active_slide		= 0,
			$et_slider_arrows,
			$et_slider_prev,
			$et_slider_next,
			$et_slider_controls,
			et_slider_timer,
			controls_html = '',
			$progress_bar = null,
			progress_timer_count = 0;

			$et_slider.et_animation_running = false;

			$.data(el, "et_simple_slider", $et_slider);

			$et_slide.eq(0).addClass( 'et-active-slide' );

			if ( settings.use_arrows && et_slides_number > 1 ) {
				if ( settings.manual_arrows == '' )
					$et_slider.append( '<div class="et-slider-arrows"><a class="et-arrow-prev" href="#">' + settings.previous_text + '</a><a class="et-arrow-next" href="#">' + settings.next_text + '</a></div>' );
				else
					$et_slider.append( settings.manual_arrows );

				$et_slider_arrows 	= $( settings.arrows );
				$et_slider_prev 	= $et_slider.find( settings.prev_arrow );
				$et_slider_next 	= $et_slider.find( settings.next_arrow );

				$et_slider_next.click( function(){
					if ( $et_slider.et_animation_running )	return false;

					$et_slider.et_slider_move_to( 'next' );

					return false;
				} );

				$et_slider_prev.click( function(){
					if ( $et_slider.et_animation_running )	return false;

					$et_slider.et_slider_move_to( 'previous' );

					return false;
				} );
			}

			if ( settings.use_controls && et_slides_number > 1 ) {
				for ( var i = 1; i <= et_slides_number; i++ ) {
					controls_html += '<a href="#"' + ( i == 1 ? ' class="' + settings.control_active_class + '"' : '' ) + '>' + i + '</a>';
				}

				controls_html =
					'<div class="' + settings.controls_class + '">' +
						controls_html +
					'</div>';

				if ( settings.append_controls_to == '' )
					$et_slider.append( controls_html );
				else
					$( settings.append_controls_to ).append( controls_html );

				$et_slider_controls	= $et_slider.find( settings.controls ),

				$et_slider_controls.click( function(){
					if ( $et_slider.et_animation_running )	return false;

					$et_slider.et_slider_move_to( $(this).index() );

					return false;
				} );
			}

			if ( settings.slideshow && et_slides_number > 1 && settings.show_progress_bar ) {
				$et_slider.append( '<div id="featured-progress-bar"><div id="progress-time"></div></div>' );
				$progress_bar = $( '#progress-time' );

				$et_slider.hover( function() {
					$et_slider.addClass( 'et_slider_hovered' );
				}, function() {
					$et_slider.removeClass( 'et_slider_hovered' );
					$progress_bar.animate( { 'width' : '100%' }, parseInt( settings.slideshow_speed - progress_timer_count ) );
				} );
			}

			et_slider_auto_rotate();

			function et_slider_auto_rotate(){
				if ( settings.slideshow && et_slides_number > 1 ) {
					et_slider_timer = setTimeout( function() {
						$et_slider.et_slider_move_to( 'next' );
					}, settings.slideshow_speed );
				}
			}

			$et_slider.et_slider_move_to = function ( direction ) {
				var $active_slide = $et_slide.eq( et_active_slide ),
					$next_slide;

				$et_slider.et_animation_running = true;

				if ( direction == 'next' || direction == 'previous' ){

					if ( direction == 'next' )
						et_active_slide = ( et_active_slide + 1 ) < et_slides_number ? et_active_slide + 1 : 0;
					else
						et_active_slide = ( et_active_slide - 1 ) >= 0 ? et_active_slide - 1 : et_slides_number - 1;

				} else {

					if ( et_active_slide == direction ) {
						$et_slider.et_animation_running = false;
						return;
					}

					et_active_slide = direction;

				}

				if ( typeof et_slider_timer != 'undefined' )
					clearInterval( et_slider_timer );

				if ( $progress_bar !== null && $progress_bar.length != 0 ) {
					progress_timer_count = 0;
					$progress_bar.stop( true ).css( 'width', '0%' );
				}

				$next_slide	= $et_slide.eq( et_active_slide );

				$et_slide.each( function(){
					$(this).css( 'zIndex', 1 );
				} );
				$active_slide.css( 'zIndex', 2 ).removeClass( 'et-active-slide' );
				$next_slide.css( { 'display' : 'block', opacity : 0 } ).addClass( 'et-active-slide' );

				if ( settings.use_controls )
					$et_slider_controls.removeClass( settings.control_active_class ).eq( et_active_slide ).addClass( settings.control_active_class );

				if ( ! settings.tabs_animation ) {
					$next_slide.delay(400).animate( { opacity : 1 }, et_fade_speed );
					$active_slide.addClass( 'et_slide_transition' ).css( { 'display' : 'block', 'opacity' : 1 } ).delay(400).animate( { opacity : 0 }, et_fade_speed, function(){
						$(this).css('display', 'none').removeClass( 'et_slide_transition' );
						$et_slider.et_animation_running = false;
					} );
				} else {
					$next_slide.css( { 'display' : 'none', opacity : 0 } );

					$active_slide.addClass( 'et_slide_transition' ).css( { 'display' : 'block', 'opacity' : 1 } ).animate( { opacity : 0 }, et_fade_speed, function(){
								$(this).css('display', 'none').removeClass( 'et_slide_transition' );

								$next_slide.css( { 'display' : 'block', 'opacity' : 0 } ).animate( { opacity : 1 }, et_fade_speed, function() {
									$et_slider.et_animation_running = false;
								} );
							} );
				}

				et_slider_auto_rotate();
			}
	}

	$.fn.et_simple_slider = function( options ) {
		return this.each(function() {
			new $.et_simple_slider(this, options);
		});
	}

	$.fn.et_animation_delay = function( options ) {
		var settings = $.extend( {
				elements : 'li',
				speed    : 0.3
			}, options );

		return this.each( function() {
			var $this = $(this),
				delay = 0;

			$this.find( settings.elements ).each( function() {
				// Animates elements one at a time
				$(this).css( {
					'-webkit-transition-delay' : delay + 's',
					'-moz-transition-delay'    : delay + 's',
					'-ms-transition-delay'     : delay + 's',
					'-o-transition-delay'      : delay + 's',
					'transition-delay'         : delay + 's'
				} );

				delay += settings.speed;
			} );
		} );
	}

	var $container,
		container_width,
		top_bar_height,
		$top_bar = $( '#top-menu' );

	$(document).ready( function(){
		var $et_top_menu         = $( 'ul.nav' ),
			$comment_form        = $( '#commentform' ),
			$testimonial         = $( '.et-home-testimonial' ),
			$testimonials_images = $( '#testimonials-authors li' ),
			$featured            = $( '#slider' );

		$container      = $( '.container' ),
		container_width = $container.width();

		$et_top_menu.superfish({
			delay		: 500, 										// one second delay on mouseout
			animation	: { opacity : 'show', height : 'show' },	// fade-in and slide-down animation
			speed		: 'fast', 									// faster animation speed
			autoArrows	: true, 									// disable generation of arrow mark-up
			dropShadows	: false										// disable drop shadows
		});

		if ( $('ul.et_disable_top_tier').length ) $("ul.et_disable_top_tier > li > ul").prev('a').attr('href','#');

		$testimonials_images.hover( function() {
			var $this          = $(this),
				active_class   = 'active-testimonial',
				image_index    = $this.index(),
				previous_index = $this.siblings( '.' + active_class ).index();

			if ( $this.hasClass( active_class ) ) return;

			$this
				.css( {
					'-webkit-transition-delay' : '0s',
					'-moz-transition-delay'    : '0s',
					'-ms-transition-delay'     : '0s',
					'-o-transition-delay'      : '0s',
					'transition-delay'         : '0s'
				} )
				.siblings('li').removeClass( active_class )
				.end()
				.addClass( active_class );

			$testimonial.eq( previous_index ).stop(true,true).animate( { opacity : 0 }, 100, function() {
				$(this).hide();

				$testimonial.eq( image_index ).css( { 'display' : 'block', 'opacity' : 0 } ).animate( { opacity : 1 }, 100 );
			} );
		} );

		if ( $featured.length ) {
			var et_slider_settings = {
				use_controls      : false,
				show_progress_bar : false
			}

			if ( $featured.hasClass('et_slider_auto') ) {
				var et_slider_autospeed_class_value = /et_slider_speed_(\d+)/g;

				et_slider_settings.slideshow = true;

				et_slider_autospeed = et_slider_autospeed_class_value.exec( $featured.attr('class') );

				et_slider_settings.slideshow_speed = et_slider_autospeed[1];
			}

			$featured.et_simple_slider( et_slider_settings );
		}

		et_duplicate_menu( $('ul.nav'), $('#top-menu .mobile_nav'), 'mobile_menu', 'et_mobile_menu' );

		function et_duplicate_menu( menu, append_to, menu_id, menu_class ){
			var $cloned_nav;

			menu.clone().attr('id',menu_id).removeClass().attr('class',menu_class).appendTo( append_to );
			$cloned_nav = append_to.find('> ul');
			$cloned_nav.find('.menu_slide').remove();
			$cloned_nav.find('li:first').addClass('et_first_mobile_item');

			append_to.click( function(){
				if ( $(this).hasClass('closed') ){
					$(this).removeClass( 'closed' ).addClass( 'opened' );
					$cloned_nav.slideDown( 500 );
				} else {
					$(this).removeClass( 'opened' ).addClass( 'closed' );
					$cloned_nav.slideUp( 500 );
				}
				return false;
			} );

			append_to.find('a').click( function(event){
				event.stopPropagation();
			} );
		}

		$comment_form.find('input:text, textarea').each(function(index,domEle){
			var $et_current_input = jQuery(domEle),
				$et_comment_label = $et_current_input.siblings('label'),
				et_comment_label_value = $et_current_input.siblings('label').text();
			if ( $et_comment_label.length ) {
				$et_comment_label.hide();
				if ( $et_current_input.siblings('span.required') ) {
					et_comment_label_value += $et_current_input.siblings('span.required').text();
					$et_current_input.siblings('span.required').hide();
				}
				$et_current_input.val(et_comment_label_value);
			}
		}).bind('focus',function(){
			var et_label_text = jQuery(this).siblings('label').text();
			if ( jQuery(this).siblings('span.required').length ) et_label_text += jQuery(this).siblings('span.required').text();
			if (jQuery(this).val() === et_label_text) jQuery(this).val("");
		}).bind('blur',function(){
			var et_label_text = jQuery(this).siblings('label').text();
			if ( jQuery(this).siblings('span.required').length ) et_label_text += jQuery(this).siblings('span.required').text();
			if (jQuery(this).val() === "") jQuery(this).val( et_label_text );
		});

		// remove placeholder text before form submission
		$comment_form.submit(function(){
			$comment_form.find('input:text, textarea').each(function(index,domEle){
				var $et_current_input = jQuery(domEle),
					$et_comment_label = $et_current_input.siblings('label'),
					et_comment_label_value = $et_current_input.siblings('label').text();

				if ( $et_comment_label.length && $et_comment_label.is(':hidden') ) {
					if ( $et_comment_label.text() == $et_current_input.val() )
						$et_current_input.val( '' );
				}
			});
		});
	});

	$(window).load( function() {
		if ( $.fn.waypoint ) {
			var delay       = 0,
				delay_speed = 0.3;

			top_bar_height = $top_bar.height();

			$( '#top-area, .home-block, .skills, #team-members, .single #et-projects' ).waypoint( {
				offset  : '67%',
				handler : function() {
					var $this        = $(this),
						active_slide = 0;

					$this.addClass( 'et-animated' );

					if ( $this.is( '.skills' ) ) {
						$this.find( 'li' ).each( function() {
							var $skill_amount = $(this).find( '.skill-amount' ),
								skill_number  = $skill_amount.data( 'skill' );

							$skill_amount.width( skill_number + '%' );
						} );
					}

					if ( $this.find( '#et-slides' ).length ) {
						$this.find( '.et-active-slide' ).show();
					}
				}
			} );

			$('#top-area').waypoint( {
				handler : function( direction ) {
					if ( container_width <= 728 ) {
						$top_bar.removeClass( 'et-fixed' );

						return;
					}

					if ( direction === 'down' ) {
						$('body').css( 'paddingTop', top_bar_height );

						$top_bar
							.addClass( 'et-fixed' )
							.css( {
								'height'  : 0
							} )
							.stop( true, true )
							.animate( { 'height' : top_bar_height }, 500 );
					} else {
						$top_bar
							.stop( true, true )
							.animate( { 'height' : 0 }, 500, function() {
								$('body').css( 'paddingTop', 0 );
								$(this).removeClass( 'et-fixed' ).css( { height : top_bar_height } );
							} );
					}
				},
				offset: function() {
					return -( $(this).innerHeight() - $top_bar.innerHeight() );
				}
			} );

			$('#top-area').waypoint( {
				handler : function( direction ) {
					if ( direction === 'up' ) {
						$('body').css( 'paddingTop', 0 );

						$top_bar.stop( true, true ).css( { height : top_bar_height } );
					}
				}
			} );

			$( '#et-projects, #testimonials-authors' ).et_animation_delay();
		}
	} );

	$(window).resize( function() {
		if ( container_width !== $container.width() ) {
			container_width = $container.width();

			top_bar_height = $top_bar.css( { 'height' : 'auto' } ).height();

			if ( container_width <= 728 ) {
				$top_bar.removeClass( 'et-fixed' );
			} else {
				$top_bar.addClass( 'et-fixed' );
			}
		}
	} );
})(jQuery)