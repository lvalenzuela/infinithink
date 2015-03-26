<?php
class FusionSC_FullWidth {

	public static $args;
	public static $bg_type = 'image';

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_filter( 'fusion_attr_fullwidth-shortcode', array( $this, 'attr' ) );
		add_filter( 'fusion_attr_fullwidth-overlay', array( $this, 'overlay_attr' ) );
		add_filter( 'fusion_attr_fullwidth-faded', array( $this, 'faded_attr' ) );
		add_shortcode( 'fullwidth', array( $this, 'render' ) );

	}

	/**
	 * Render the shortcode
	 * 
	 * @param  array $args	 Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string		  HTML output
	 */
	function render( $args, $content = '') {
		global $smof_data;

		$defaults =	FusionCore_Plugin::set_shortcode_defaults(
			array(
				'class'						=> '',
				'id'						=> '',
				'backgroundattachment' 		=> 'scroll',				
				'backgroundcolor'			=> $smof_data['full_width_bg_color'],
				'backgroundimage' 			=> '',
				'backgroundposition' 		=> 'left top',				
				'backgroundrepeat' 			=> 'no-repeat',
				'bordercolor' 				=> $smof_data['full_width_border_color'],
				'bordersize' 				=> $smof_data['full_width_border_size'],
				'borderstyle' 				=> 'solid',
				'equal_height_columns'		=> 'no',
				'fade'						=> 'no',
				'hundred_percent'			=> 'no',
				'menu_anchor' 				=> '',
				'overlay_color'				=> '',
				'overlay_opacity'			=> '0.5',
				'paddingbottom' 			=> '20px',
				'paddingleft' 				=> '0px',
				'paddingright'				=> '0px',				
				'paddingtop'				=> '20px',
				'paddingBottom' 			=> '', // deprecated
				'paddingTop' 				=> '', // deprecated
				'video_loop'				=> 'yes',
				'video_mp4'					=> '',
				'video_mute'				=> 'yes',
				'video_ogv'					=> '',
				'video_preview_image'		=> '',
				'video_webm'				=> '',
			), $args
		);

		if( $defaults['hundred_percent'] == 'yes' ) {
			$defaults['paddingleft'] = '0px';
			$defaults['paddingright'] = '0px';
		}

		extract( $defaults );

		self::$args = $defaults;

		$this->depracted_args();

		$outer_html = '';

		self::$bg_type = 'image';

		if( $video_mp4 || $video_ogv || $video_webm ) {
			self::$bg_type = 'video';
		}

		if( $fade == 'yes' ) {
			self::$bg_type = 'faded';

			$outer_html .= sprintf( '<div %s></div>', FusionCore_Plugin::attributes( 'fullwidth-faded' ) );
		}

		if( self::$bg_type == 'video' ) {
			$video_attributes = 'preload="auto" autoplay';
			$video_src = '';

			if( $video_loop == 'yes' ) {
				$video_attributes .= ' loop';
			}

			if( $video_mute == 'yes' ) {
				$video_attributes .= ' muted';
			}

			if( $video_mp4 ) {
				$video_src .= sprintf( '<source src="%s" type="video/mp4">', $video_mp4 );
			}

			if( $video_ogv ) {
				$video_src .= sprintf( '<source src="%s" type="video/ogg">', $video_ogg );
			}

			if( $video_webm ) {
				$video_src .= sprintf( '<source src="%s" type="video/webm">', $video_webm );
			}

			if( $overlay_color ) {
				$outer_html .= sprintf( '<div %s></div>', FusionCore_Plugin::attributes( 'fullwidth-overlay' ) );
			}

			$outer_html .= sprintf( '<div class="%s"><video %s>%s</video></div>', 'fullwidth-video', $video_attributes, $video_src );

			if( $video_preview_image ) {
				$video_preview_image_style = sprintf('background-image:url(%s);', $video_preview_image );
				$outer_html .= sprintf( '<div class="%s" style="%s"></div>', 'fullwidth-video-image', $video_preview_image_style );
			}
		}

		if( $defaults['menu_anchor'] ) {
			$html = sprintf( '<div id="%s"><div %s>%s<div %s>%s</div></div></div>', $defaults['menu_anchor'], FusionCore_Plugin::attributes( 'fullwidth-shortcode' ), $outer_html, FusionCore_Plugin::attributes( 'avada-row' ), do_shortcode( $content ) );
		} else {
			$html = sprintf( '<div %s>%s<div %s>%s</div></div>', FusionCore_Plugin::attributes( 'fullwidth-shortcode' ), $outer_html, FusionCore_Plugin::attributes( 'avada-row' ), do_shortcode( $content ) );
		}

		return $html;

	}

	function attr() {

		$attr['class'] = 'fusion-fullwidth fullwidth-box';
		$attr['style'] = '';

		if( self::$args['hundred_percent'] == 'yes' ) {
			$attr['class'] .= ' hundred-percent-fullwidth';
		}

		if( self::$bg_type == 'video' ) {
			$attr['class'] .= ' video-background';
		} elseif( self::$bg_type == 'faded' ) {
			$attr['class'] .= ' faded-background';
		}
		
		if( self::$args['equal_height_columns'] == 'yes' ) {
			$attr['class'] .= ' equal-height-columns';
		}

		if( self::$args['backgroundcolor'] ) {
			$attr['style'] .= sprintf( 'background-color:%s;', self::$args['backgroundcolor'] );
		}

		if( self::$args['backgroundattachment'] ) {
			$attr['style'] .= sprintf( 'background-attachment:%s;', self::$args['backgroundattachment'] );
		}

		if( self::$bg_type != 'faded' ) {
			if( self::$args['backgroundimage'] ) {
				$attr['style'] .= sprintf( 'background-image: url(%s);', self::$args['backgroundimage'] );
			}
		}

		if( self::$args['backgroundposition'] ) {
			$attr['style'] .= sprintf( 'background-position:%s;', self::$args['backgroundposition'] );
		}

		if( self::$args['backgroundrepeat'] ) {
			$attr['style'] .= sprintf( 'background-repeat:%s;', self::$args['backgroundrepeat'] );
		}
		
		if( self::$args['backgroundrepeat'] == 'no-repeat') {
			$attr['style'] .= '-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;';
		}

		if( self::$args['bordercolor'] ) {
			$attr['style'] .= sprintf( 'border-color:%s;', self::$args['bordercolor'] );
		}

		if( self::$args['bordersize'] ) {
			$attr['style'] .= sprintf( 'border-bottom-width: %s;border-top-width: %s;', self::$args['bordersize'], self::$args['bordersize'] );
		}
		
		if( self::$args['borderstyle'] ) {
			$attr['style'] .= sprintf( 'border-bottom-style: %s;border-top-style: %s;', self::$args['borderstyle'], self::$args['borderstyle'] );
		}		

		if( self::$args['paddingbottom'] ) {
			$attr['style'] .= sprintf( 'padding-bottom:%s;', self::$args['paddingbottom'] );
		}
		
		if( self::$args['paddingleft'] ) {
			$attr['style'] .= sprintf( 'padding-left:%s;', self::$args['paddingleft'] );
		}

		if( self::$args['paddingright'] ) {
			$attr['style'] .= sprintf( 'padding-right:%s;', self::$args['paddingright'] );
		}		

		if( self::$args['paddingtop'] ) {
			$attr['style'] .= sprintf( 'padding-top:%s;', self::$args['paddingtop'] );
		}
		
		if( self::$args['id'] ) {
			$attr['id'] = self::$args['id'];
		}

		if( self::$args['class'] ) {
			$attr['class'] .= ' ' . self::$args['class'];
		}		

		return $attr;

	}

	function overlay_attr() {

		$attr['class'] = 'fullwidth-overlay';
		$attr['style'] = '';

		if( self::$args['overlay_color'] ) {
			$attr['style'] .= sprintf( 'background-color:%s;', self::$args['overlay_color'] );
		}

		if( self::$args['overlay_opacity'] ) {
			$attr['style'] .= sprintf( 'opacity:%s;', self::$args['overlay_opacity'] );
		}

		return $attr;

	}

	function faded_attr() {

		$attr['class'] = 'fullwidth-faded';
		$attr['style'] = '';

		if( self::$args['backgroundattachment'] ) {
			$attr['style'] .= sprintf( 'background-attachment:%s;', self::$args['backgroundattachment'] );
		}

		if( self::$args['backgroundcolor'] ) {
			$attr['style'] .= sprintf( 'background-color:%s;', self::$args['backgroundcolor'] );
		}

		if( self::$args['backgroundimage'] ) {
			$attr['style'] .= sprintf( 'background-image: url(%s);', self::$args['backgroundimage'] );
		}

		if( self::$args['backgroundposition'] ) {
			$attr['style'] .= sprintf( 'background-position:%s;', self::$args['backgroundposition'] );
		}

		if( self::$args['backgroundrepeat'] ) {
			$attr['style'] .= sprintf( 'background-repeat:%s;', self::$args['backgroundrepeat'] );
		}
		
		if( self::$args['backgroundrepeat'] == 'no-repeat') {
			$attr['style'] .= '-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;';
		}		

		return $attr;

	}
	
	private function depracted_args() {
		if( self::$args['paddingBottom'] ) {
			self::$args['paddingbottom'] = self::$args['paddingBottom'];
		}
		
		if( self::$args['paddingTop'] ) {
			self::$args['paddingtop'] = self::$args['paddingTop'];
		}		
	}

}

new FusionSC_FullWidth();
