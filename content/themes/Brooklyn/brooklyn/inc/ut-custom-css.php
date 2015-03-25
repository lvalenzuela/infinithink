<?php

/*
 * Custom CSS from Option Panel
 * by www.unitedthemes.com
 */


/*
|--------------------------------------------------------------------------
| Custom CSS Minifier
|--------------------------------------------------------------------------
*/

add_filter( 'ut-custom-css' , 'ut_minify_css' );

if ( !function_exists( 'ut_minify_css' ) ) {
    
    function ut_minify_css($buffer) { 
        
        $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
        $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
        return $buffer;
        
    }
    
}


/*
|--------------------------------------------------------------------------
| Changes HEX to RGB
|--------------------------------------------------------------------------
*/
if( !function_exists('ut_hex_to_rgb') ) :

    function ut_hex_to_rgb($hex) {
        
        if( empty($hex) ) {
            return;
        }
                
        $hex = preg_replace("/#/", "", $hex);
        $color = array();
     
        if(strlen($hex) == 3) {
            $color['r'] = hexdec(substr($hex, 0, 1) . $r);
            $color['g'] = hexdec(substr($hex, 1, 1) . $g);
            $color['b'] = hexdec(substr($hex, 2, 1) . $b);
        }
        else if(strlen($hex) == 6) {
            $color['r'] = hexdec(substr($hex, 0, 2));
            $color['g'] = hexdec(substr($hex, 2, 2));
            $color['b'] = hexdec(substr($hex, 4, 2));
        }
        
        $color = implode(',', $color);
        
        return $color;
    }

endif;


/*
|--------------------------------------------------------------------------
| Create Custom Button
|--------------------------------------------------------------------------
*/

if( !function_exists('ut_create_button_style') ) :
    
    function ut_create_button_style( $div = '' , $button_settings = array() ) {
        
        if( empty($div) || empty($button_settings) ) {
            
            // nothing to do here, let's leave
            return;
            
        }
        
        $button = $div . '{';
            
            if( !empty($button_settings['font-size'] ) ) {
            
                $button.= 'font-size:' . $button_settings['font-size'] . ' !important;';
            
            }
            
            if( !empty($button_settings['text-transform'] ) ) {
            
                $button.= 'text-transform:' . $button_settings['text-transform'] . ' !important;';
            
            }
                        
            if( !empty($button_settings['color'] ) ) {
            
                $button.= 'background:' . $button_settings['color'] . ' !important;';
            
            }
            
            if( !empty($button_settings['text_color'] ) ) {
            
                $button.= 'color:' . $button_settings['text_color'] . ' !important;';
            
            }
            
            if( !empty($button_settings['border_radius'] ) ) {
            
                $button.= 'border-radius:' . $button_settings['border_radius'] . 'px !important;';
            
            }
            
            if( !empty($button_settings['border_color'] ) ) {
            
                $button.= 'border-color:' . $button_settings['border_color'] . ' !important;';
            
            } else {
            
                $button.= 'border: none !important;';
            
            }
            
            $button.= 'padding:0.8em 1em;';
            $button.= 'letter-spacing: 1px;';                    
            $button.= '-webkit-transition:0.2s all linear; -moz-transition:0.2s all linear; transition:0.2s all linear;';
            
            
        $button.= '}';
        
        $button.= $div.':hover {';
            
            if( !empty($button_settings['hover_color'] ) ) {
            
                $button.= 'background:' . $button_settings['hover_color'] . ' !important;';
            
            } 
            
            if( !empty($button_settings['text_hover_color'] ) ) {
            
                $button.= 'color:' . $button_settings['text_hover_color'] . ' !important;';
            
            }  
            
            if( !empty($button_settings['border_hover_color'] ) ) {
            
                $button.= 'border-color:' . $button_settings['border_hover_color'] . ' !important;';
            
            } 
            
        $button.= '}';
        
        return $button;
        
    }    

endif;

/*
|--------------------------------------------------------------------------
| Create Section Headline Style
|--------------------------------------------------------------------------
*/
if( !function_exists('create_section_headline_style') ) :

    function create_section_headline_style( $div = '',  $style = 'pt-style-1' , $color = '' , $shadow = '' ) {
        
        if( empty($div) || empty($color) ) {
            
            // nothing to do here, let's leave
            return;
            
        }
                
        switch ( $style ) {
            
            case 'pt-style-1':
                return;
            break;
            
            case 'pt-style-2':
                
                return '
                '.$div.' .pt-style-2 .page-title:after, 
                '.$div.' .pt-style-2 .parallax-title:after, 
                '.$div.' .pt-style-2 .section-title:after {
                    background-color: ' . $color . ';
                }';
                
            break;
            
            case 'pt-style-3':
                
                return '
                    '.$div.' .pt-style-3 .page-title span, 
                    '.$div.' .pt-style-3 .parallax-title span, 
                    '.$div.' .pt-style-3 .section-title span { 
                        background:' . $color . ';            
                        -webkit-box-shadow:0 0 0 3px' . $color . '; 
                        -moz-box-shadow:0 0 0 3px' . $color . '; 
                        box-shadow:0 0 0 3px' . $color . '; 
                    }
                ';                
                
            break;
            
            case 'pt-style-4':
                
                return '
                '.$div.' .pt-style-4 .page-title span, 
                '.$div.' .pt-style-4 .parallax-title span, 
                '.$div.' .pt-style-4 .section-title span {
                    border:3px solid ' . $color . ';
                }';
                
            break;
            
            case 'pt-style-5':
                
                return '
                '.$div.' .pt-style-5 .page-title span, 
                '.$div.' .pt-style-5 .parallax-title span, 
                '.$div.' .pt-style-5 .section-title span {
                    background:' . $color . ';            
                    -webkit-box-shadow:0 0 0 3px' . $color . '; 
                    -moz-box-shadow:0 0 0 3px' . $color . '; 
                    box-shadow:0 0 0 3px' . $color . '; 
                }';
                
            break;
            
            
            case 'pt-style-6':
                
                return '
                '.$div.' .pt-style-6 .page-title:after, 
                '.$div.' .pt-style-6 .parallax-title:after, 
                '.$div.' .pt-style-6 .section-title:after {
                    border-bottom: 1px dotted ' . $color . ';
                }';
            
            break;
            
            
        }
        
    }

endif;


/*
|--------------------------------------------------------------------------
| Create Custom Background
|--------------------------------------------------------------------------
*/

if ( !function_exists( 'ut_create_css_background' ) ) {
    
    function ut_create_css_background( $object , $background_settings ) { 
        
        global $detect;
        
        /* no settings array or html object = leave here */    
        if( !is_array($background_settings) || empty($object) ) {
            return NULL;
        }
                
        $skipfixed = false;
        
        $css = $object . '{';
        
        $key_exceptions = array( 'background-color' , 'background-image' , 'background-size' );
        
        /* exception for mobiles and tablets */
        if( $detect->isMobile() && ( isset($background_settings['background-size']) && $background_settings['background-size'] == 'cover' ) && ( isset($background_settings['background-attachment']) && $background_settings['background-attachment'] == 'fixed' ) ) {
            $skipfixed = true;
        }
        
        foreach( $background_settings as $key => $value) {            
            
            if( in_array( $key , $key_exceptions ) ) {
                
                switch( $key ) {
                    
                    case 'background-color' : $css .= 'background: '.$value.';';
                    break;
                    
                    case 'background-image' : $css .= $key . ':' . 'url("'.$value.'");';
                    break;
                    
                    case 'background-size' : $css .= $key . ':' . $value . ' !important;';
                    
                }
                
            } else {
                
                if($skipfixed && $key == 'background-attachment') {    
                   
                   continue; 
                
                } else {
                
                    $css .= $key . ':' . $value . ' !important;';
                
                }
                
            }
            
        }
        
        $css .= '}';
        
        return $css;
                    
    }
    
}

/*
|--------------------------------------------------------------------------
| Create Global Headline Style ( Fallback Function )
|--------------------------------------------------------------------------
*/
if ( !function_exists( 'ut_create_global_headline_font_style' ) ) {

    function ut_create_global_headline_font_style( $object = '', $font_style = '' ) {
        
        if( empty($object) ) {
            return;
        }
    
        $font = NULL;
        $google_fonts = ut_recognized_google_fonts();
        $ut_recognized_font_styles = ut_recognized_font_styles();
        
        $font_styles = array(
            'regular' => 'normal',
            'normal'  => 'normal',
            'italic'  => 'italic'
        );
        
        if( !empty( $font_style ) && $font_style != 'global' ) {
        
            return $object . '{ font-family: ' . $ut_recognized_font_styles[$font_style] . ', "Helvetica Neue", Helvetica, Arial, sans-serif; }'. "\n";
        
        } else {
            
            if( ot_get_option('ut_global_headline_font_type' , 'ut-font') == 'ut-google' ) {
            
                $ut_global_google_headline_font_style = ot_get_option('ut_global_google_headline_font_style');                
                
                if( !empty($google_fonts[$ut_global_google_headline_font_style['font-id']]['family']) ) {
                
                    $font .= $object . ' {';
                        
                        $font .= 'font-family:"'.$google_fonts[$ut_global_google_headline_font_style['font-id']]['family'].'", "Helvetica Neue", Helvetica, Arial, sans-serif;';                    
                        
                        if( !empty($ut_global_google_headline_font_style['font-weight']) ) {
                            $font .= ' font-weight: ' . $ut_global_google_headline_font_style['font-weight'] . ';';    
                        }
                        
                        if( !empty($ut_global_google_headline_font_style['font-size']) ) {
                            $font .= ' font-size: ' . $ut_global_google_headline_font_style['font-size'] . ';';    
                        }
                        
                        if( !empty($ut_global_google_headline_font_style['font-style']) && isset($font_styles[$ut_global_google_headline_font_style['font-style']]) ) {
                            $font .= ' font-style: ' . $font_styles[$ut_global_google_headline_font_style['font-style']] . ';';    
                        }
                        
                        if( !empty($ut_global_google_headline_font_style['line-height']) ) {
                            $font .= ' line-height: ' . $ut_global_google_headline_font_style['line-height'] . ';';    
                        }
                        
                        if( !empty($ut_global_google_headline_font_style['text-transform']) ) {
                            $font .= ' text-transform: ' . $ut_global_google_headline_font_style['text-transform'] . ';';    
                        }
                        
                    $font .= '}';
                    
                    return $font;
                
                } else {
                    
                    /* fallback if user has not chosen a google font yet */
                    $font_style = ot_get_option('ut_global_headline_font_style' , 'semibold');
                    return $object . '{ font-family: ' . $ut_recognized_font_styles[$font_style] . ', "Helvetica Neue", Helvetica, Arial, sans-serif; }'. "\n";
                    
                }
                
            
            } else {
            
                $font_style = ot_get_option('ut_global_headline_font_style' , 'semibold');
                return $object . '{ font-family: ' . $ut_recognized_font_styles[$font_style] . ', "Helvetica Neue", Helvetica, Arial, sans-serif; }'. "\n";
            
            }
            
        }
        
    }

}

/*
|--------------------------------------------------------------------------
| Start Custom CSS
|--------------------------------------------------------------------------
*/
if ( !function_exists( 'unitedthemes_custom_css' ) ) {
       
    function unitedthemes_custom_css() {
        
        global $detect , $post;
                
        /* check for css cache */
        if( ot_get_option('ut_use_cache' , 'off') == 'on' && is_front_page() ) {
            
            $transient_prefix = $detect->isMobile() ? '_mobile' : '_desktop';
            $css = get_transient('ut_css_cache' . $transient_prefix);
            
            if( !empty($css) ) {
                echo apply_filters( 'ut-custom-css', $css );
                return;
            }
        
        }
        
        /* some needed variables first */
        $accentcolor      = get_option('ut_accentcolor' , '#F1C40F');
        $sitelogo         = get_theme_mod( 'ut_site_logo' );
        $google_fonts     = ut_recognized_google_fonts();
        $ut_recognized_font_styles = ut_recognized_font_styles();
        $font_styles = array(
            'regular' => 'normal',
            'normal'  => 'normal',
            'italic'  => 'italic'
        );
        
        /* styleswitcher */
        if( !empty( $_GET['color'] ) ) {
            $accentcolor = '#'.$_GET['color'];
        }
        
        /* start css */
        $css  = '<style type="text/css">'. "\n";
            
            /* sidebar align */
            if( is_single() || is_home() ) {
                
                $contentalign = ot_get_option('ut_sidebar_align' , 'right') == 'right' ? 'left' : 'right';
                $css .= '#primary { float: ' . $contentalign . '}';
                
            }
            
            /* themecolor / accentcolor elements */                      
            $css .= '::-moz-selection  { background: ' . $accentcolor . '; }' . "\n";
            $css .= '::selection { background:' . $accentcolor . '; }' . "\n" ;
            $css .= 'a, .ha-transparent #navigation ul li a:hover { color: ' . $accentcolor . '; }' . "\n";
            $css .= '.ut-language-selector a:hover { color: ' . $accentcolor . '; }' . "\n";
            $css .= '.ut-custom-icon-link:hover i { color: ' . $accentcolor . ' !important; }' . "\n";    
            $css .= '.ut-hide-member-details:hover, #ut-blog-navigation a:hover, .light .ut-hide-member-details, .ut-mm-button:hover:before, .ut-mm-trigger.active .ut-mm-button:before, .ut-mobile-menu a:after { color: ' . $accentcolor . '; }'. "\n";            
            $css .= '.ut-header-light .ut-mm-button:before { color: ' . $accentcolor . '; }';
            $css .= '.lead span, .entry-title span, #cancel-comment-reply-link, .member-description-style-3 .ut-member-title,  .ut-twitter-rotator h2 a, .themecolor  { color: ' . $accentcolor . '; }'. "\n";            
            $css .= '.icons-ul i, .comments-title span, .member-social a:hover, .ut-parallax-quote-title span, .ut-member-style-2 .member-description .ut-member-title { color:' . $accentcolor . '; }'. "\n";        
            $css .= '.about-icon, .ut-skill-overlay, .ut-dropcap-one, .ut-dropcap-two, .ut-mobile-menu a:hover, .themecolor-bg, .ut-btn.ut-pt-btn:hover, .ut-btn.dark:hover { background:' . $accentcolor . '; }'. "\n";
            $css .= 'blockquote, div.wpcf7-validation-errors, .ut-hero-style-5 .hero-description, #navigation ul.sub-menu, .ut-member-style-3 .member-social a:hover { border-color:' . $accentcolor . '; }'. "\n";
            $css .= '.cta-section, .ut-btn.theme-btn, .ut-social-link:hover .ut-social-icon, .ut-member-style-2 .ut-so-link:hover { background:' . $accentcolor . ' !important; }'. "\n";
            $css .= '.ut-social-title, .ut-service-column h3 span, .ut-rq-icon  { color:' . $accentcolor . '; }'. "\n";
            $css .= '.count, .ut-icon-list i { color:' . $accentcolor . '; }'. "\n";
            $css .= '.client-section, .ut-portfolio-pagination.style_two a.selected:hover, .ut-portfolio-pagination.style_two a.selected, .ut-portfolio-pagination.style_two a:hover, .ut-pt-featured { background:' . $accentcolor . ' !important; }'. "\n";
            $css .= 'ins, mark, .ut-alert.themecolor, .ut-portfolio-menu.style_two li a:hover, .ut-portfolio-menu.style_two li a.selected, .light .ut-portfolio-menu.style_two li a.selected:hover { background:' . $accentcolor . '; }'. "\n";
            $css .= '.footer-content i { color:' . $accentcolor . '; }'. "\n";
            $css .= '.copyright a:hover, .footer-content a:hover, .toTop:hover, .ut-footer-dark a.toTop:hover { color:' . $accentcolor . '; }'. "\n";
            $css .= 'blockquote span { color:' . $accentcolor . '; }'. "\n";
            $css .= '.entry-meta a:hover, #secondary a:hover, .page-template-templatestemplate-archive-php a:hover { color:' . $accentcolor . '; }'. "\n";
            $css .= 'h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover, .ut-header-dark .site-logo .logo a:hover { color:' . $accentcolor . '; }'. "\n";    
            $css .= 'a.more-link:hover, .fa-ul li .fa  { color:' . $accentcolor . '; }'. "\n";    
            $css .= '.ut-pt-featured-table .ut-pt-info .fa-li  { color: ' . $accentcolor . ' !important; }' . "\n";            
            $css .= '.button, input[type="submit"], input[type="button"], .dark button, .dark input[type="submit"], .dark input[type="button"], .light .button, .light input[type="submit"], .light input[type="button"] { background:' . $accentcolor . '; }'. "\n";
            $css .= '.img-hover { background:rgb(' . ut_hex_to_rgb($accentcolor) . ');    background:rgba(' . ut_hex_to_rgb($accentcolor) . ', 0.85); }'. "\n";
            $css .= '.portfolio-caption { background:rgb(' . ut_hex_to_rgb($accentcolor) . ');    background:rgba(' . ut_hex_to_rgb($accentcolor) . ', 0.85); }'. "\n";
            $css .= '.team-member-details { background:rgba(' . ut_hex_to_rgb($accentcolor) . ', 0.85 ); }'. "\n";
            $css .= '.ut-avatar-overlay { background:rgb(' . ut_hex_to_rgb($accentcolor) . '); background:rgba(' . ut_hex_to_rgb($accentcolor) . ', 0.85 ); }'. "\n";
            $css .= '.mejs-controls .mejs-time-rail .mejs-time-current, .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .format-link .entry-header a { background:' . $accentcolor . ' !important; }'. "\n";                        
            $css .= '.light .ut-portfolio-menu li a:hover, .light .ut-portfolio-pagination a:hover, .light .ut-nav-tabs li a:hover, .light .ut-accordion-heading a:hover { border-color:' . $accentcolor . ' !important; }'. "\n";
            $css .= '.light .ut-portfolio-menu li a:hover, .light .ut-portfolio-pagination a:hover, .ut-portfolio-list li strong, .light .ut-nav-tabs li a:hover, .light .ut-accordion-heading a:hover, .ut-custom-icon a:hover i:first-child { color:' . $accentcolor . ' !important; }'. "\n";            
            $css .= '.ut-portfolio-gallery-slider .flex-direction-nav a, .ut-gallery-slider .flex-direction-nav a, .ut-rotate-quote-alt .flex-direction-nav a, .ut-rotate-quote .flex-direction-nav a  { background:rgb(' . ut_hex_to_rgb($accentcolor) . '); background:rgba(' . ut_hex_to_rgb($accentcolor) . ', 0.85); }'. "\n";            
            $css .= '.light .ut-bs-wrap .entry-title a:hover, .light .ut-bs-wrap a:hover .entry-title  { color: ' . $accentcolor . '; }'. "\n";                
            $css .= '.ut-rated i { color: ' . $accentcolor . '; }'. "\n";
            $css .= '.ut-footer-area ul.sidebar a:hover { color: ' . $accentcolor . '; }'. "\n";  
            $css .= '.ut-footer-dark .ut-footer-area .widget_tag_cloud a:hover { color: ' . $accentcolor . '!important; }'. "\n";
            $css .= '.ut-footer-dark .ut-footer-area .widget_tag_cloud a:hover { border-color: ' . $accentcolor . '; }'. "\n";
            $css .= '.elastislide-wrapper nav span:hover { border-color: ' . $accentcolor . '; }'. "\n";
            $css .= '.elastislide-wrapper nav span:hover { color: ' . $accentcolor . '; }'. "\n";            
            $css .= '.ut-footer-so li a:hover { border-color: ' . $accentcolor . '; }'. "\n";
            $css .= '.ut-footer-so li a:hover i { color: ' . $accentcolor . '!important; }'. "\n";
            $css .= '.ut-pt-wrap.ut-pt-wrap-style-2 .ut-pt-featured-table .ut-pt-header { background:' . $accentcolor . '; }'. "\n";
            $css .= '.ut-pt-wrap-style-3 .ut-pt-info ul li, .ut-pt-wrap-style-3 .ut-pt-info ul, .ut-pt-wrap-style-3 .ut-pt-header, .ut-pt-wrap-style-3 .ut-btn.ut-pt-btn, .ut-pt-wrap-style-3 .ut-custom-row, .ut-pt-wrap-style-3 .ut-pt-featured-table .ut-btn { border-color:rgba(' . ut_hex_to_rgb($accentcolor) . ', 0.1); }'. "\n";  
            
            $css .= '.ut-pt-wrap-style-3 .ut-btn { color:' . $accentcolor . ' !important; }'. "\n";
            $css .= '.ut-pt-wrap-style-3 .ut-btn { text-shadow: 0 0 40px ' . $accentcolor . ', 2px 2px 3px black; }'. "\n";
            $css .= '.ut-pt-wrap-style-3 .ut-pt-featured-table .ut-btn { color:' . $accentcolor . ' !important; }'. "\n";
            $css .= '.ut-pt-wrap-style-3 .ut-pt-featured-table .ut-btn { text-shadow: 0 0 40px ' . $accentcolor . ', 2px 2px 3px black; }'. "\n";
            
            $css .= '.ut-pt-wrap-style-3 .ut-pt-featured-table .ut-pt-title { color:' . $accentcolor . ' !important; }'. "\n";
            $css .= '.ut-pt-wrap-style-3 .ut-pt-featured-table .ut-pt-title { text-shadow: 0 0 40px ' . $accentcolor . ', 2px 2px 3px black; }'. "\n";
            
            /*
            |--------------------------------------------------------------------------
            | Glow Effect
            |--------------------------------------------------------------------------
            */
            $css .= '.ut-glow {
                color:'.$accentcolor.';
                text-shadow:0 0 40px '.$accentcolor.', 2px 2px 3px black; 
            }';
            
            /*
            |--------------------------------------------------------------------------
            | NEW Video Shortcode
            |--------------------------------------------------------------------------
            */
            
            $css .= '.light .ut-shortcode-video-wrap .ut-video-caption { border-color:rgba(' . ut_hex_to_rgb($accentcolor) . ', 1); }'. "\n";  
            $css .= '.light .ut-shortcode-video-wrap .ut-video-caption i { border-color:rgba(' . ut_hex_to_rgb($accentcolor) . ', 0.3); }'. "\n";
            $css .= '.light .ut-shortcode-video-wrap .ut-video-caption i { color:rgba(' . ut_hex_to_rgb($accentcolor) . ', 0.3); }'. "\n";
            
            $css .= '.light .ut-shortcode-video-wrap .ut-video-caption:hover i { border-color:rgba(' . ut_hex_to_rgb($accentcolor) . ', 1); }'. "\n";
            
            $css .= '.light .ut-shortcode-video-wrap .ut-video-caption:hover i { color:' . $accentcolor . ' !important; }'. "\n";
            $css .= '.light .ut-shortcode-video-wrap .ut-video-caption:hover i { text-shadow: 0 0 40px ' . $accentcolor . ', 2px 2px 3px black; }'. "\n";
            
            $css .= '.light .ut-video-loading { color:' . $accentcolor . ' !important; }'. "\n";
            $css .= '.light .ut-video-loading { text-shadow: 0 0 40px ' . $accentcolor . ', 2px 2px 3px black; }'. "\n";
            
            $css .= '.light .ut-video-caption-text { border-color:rgba(' . ut_hex_to_rgb($accentcolor) . ', 1); }'. "\n";
           
                      
            
            /*
            |--------------------------------------------------------------------------
            | Section animation
            |--------------------------------------------------------------------------
            */
            
            if( !$detect->isMobile() && ot_get_option('ut_animate_sections' , 'on') == 'on' ) :
            
                    $css .= '
                    .js #main-content section .section-content,
                    .js #main-content section .section-header-holder {
                        opacity:0;
                    }';
                    
            endif;
            
            /*
            |--------------------------------------------------------------------------
            | Main Navigation 
            |--------------------------------------------------------------------------
            */
            $ut_navigation_padding_top      = ot_get_option( 'ut_navigation_padding_top' );
            $ut_navigation_padding_bottom   = ot_get_option( 'ut_navigation_padding_bottom' );
            
            /* header / navigation padding top */
            if( !empty($ut_navigation_padding_top) ) {
            
                $css .= '#header-section { padding-top: ' . $ut_navigation_padding_top . '; }';
            
            }
            
            /* header / navigation padding bottom*/
            if( !empty($ut_navigation_padding_bottom) ) {
                
                $css .= '#header-section { padding-bottom: ' . $ut_navigation_padding_bottom . '; }';
            
            }
            
            if( ot_get_option('ut_navigation_skin' , 'ut-header-light' ) == 'ut-header-light' ) {
                
                $ut_navigation_skin_light_bgcolor = ot_get_option('ut_navigation_skin_light_bgcolor');
                
                if( !empty( $ut_navigation_skin_light_bgcolor ) ) {
                    
                    /* add to CSS */
                    $css .= '
                    #header-section.ut-header-light,
                    .ha-header.ha-transparent:hover,
                    .ha-header.ha-transparent:hover #navigation ul.sub-menu li > a,
                    #header-section.ut-header-light #navigation ul.sub-menu li > a {
                        background: rgba(' . ut_hex_to_rgb( $ut_navigation_skin_light_bgcolor ) . ' , 0.95 ) ; 
                    }'; 
                    
                }
                
            } else {
                
                $ut_navigation_skin_dark_bgcolor = ot_get_option('ut_navigation_skin_dark_bgcolor');
                
                if( !empty( $ut_navigation_skin_dark_bgcolor ) ) {
                    
                    /* add to CSS */
                    $css .= '
                    #header-section.ut-header-dark,
                    .ha-header.ha-transparent:hover,
                    .ha-header.ha-transparent:hover #navigation ul.sub-menu li > a,
                    #header-section.ut-header-dark #navigation ul.sub-menu li > a {
                        background: rgba(' . ut_hex_to_rgb( $ut_navigation_skin_dark_bgcolor ) . ' , 0.95 ) ; 
                    }'; 
                    
                }
                    
            }
            
            
            
            
            if(  ot_get_option('ut_navigation_font_weight' , 'normal') == 'bold' ) {
            
                $css .= '#navigation { font-family: "ralewaysemibold", Helvetica, Arial, sans-serif !important; }';
                
            }
            
            /* custom colors for first level color */
            if( ot_get_option('ut_navigation_level_one_color') ) {
                
                if(ot_get_option('ut_navigation_skin' , 'ut-header-light') == 'ut-header-light') {                
                    $css .= '#navigation ul li a { color: ' . ot_get_option('ut_navigation_level_one_color') . ' }';
                } else {
                    $css .= '.ut-header-dark #navigation ul li a { color: ' . ot_get_option('ut_navigation_level_one_color') . ' }';
                }
                
            }
            
            /* custom colors for first level dot color */
            if( ot_get_option('ut_navigation_level_one_icon_color') ) {
                
                if(ot_get_option('ut_navigation_skin' , 'ut-header-light') == 'ut-header-light') {  
                    $css .= '#navigation ul li a:after { color: ' . ot_get_option('ut_navigation_level_one_icon_color') . ' }';
                } else {
                    $css .= '.ut-header-dark #navigation ul li a:after { color: ' . ot_get_option('ut_navigation_level_one_icon_color') . ' }';
                }
                
            }
            
            /* main navigation light */
            $css .= '#navigation li a:hover { color:' . $accentcolor . '; }'. "\n";
            
            /* main navigation parents and ancestor */
            $css .= '#navigation .selected,
                     #navigation ul li.current_page_parent a.active,
                     #navigation ul li.current-menu-ancestor a.active { color: ' . $accentcolor . '; }'. "\n";
                         
            $css .= '#navigation ul li a:hover, 
                     #navigation ul.sub-menu li a:hover { color: ' . $accentcolor . '; }'. "\n";      
            
            /* main navigation current page */
            $css .= '#navigation ul.sub-menu li > a { color: #999999; }';
            
            $css .= '#navigation ul li.current-menu-item:not(.current_page_parent) a,
                     #navigation ul li.current_page_item:not(.current_page_parent) a { color: ' . $accentcolor . '; }';
            
            $css .= '#navigation ul li.current-menu-item:not(.current_page_parent) .sub-menu li a { color: #999999; }';
            
            
            /* main navigation dark */
            $css .= '.ut-header-dark #navigation li a:hover { color:' . $accentcolor . '; }'. "\n";
            
            /* main navigation parents and ancestor */
            $css .= '.ut-header-dark #navigation .selected, 
                     .ut-header-dark #navigation ul li.current_page_parent a.active,
                     .ut-header-dark #navigation ul li.current-menu-ancestor a.active { color: ' . $accentcolor . '; }'. "\n";
                         
            $css .= '.ut-header-dark #navigation ul li a:hover, 
                     .ut-header-dark #navigation ul.sub-menu li a:hover { color: ' . $accentcolor . '; }'. "\n";      
            
            /* main navigation current page */
            $css .= '.ut-header-dark #navigation ul.sub-menu li > a { color: #999999; }';
            
            $css .= '.ut-header-dark #navigation ul li.current-menu-item:not(.current_page_parent) a,
                     .ut-header-dark #navigation ul li.current_page_item:not(.current_page_parent) a { color: ' . $accentcolor . '; }';
            
            $css .= '.ut-header-dark #navigation ul li.current-menu-item:not(.current_page_parent) .sub-menu li a { color: #999999; }';
            
            
            /* preloader */
            if( ot_get_option('ut_use_image_loader') == 'on' ) {
                
                $css .= '.ut-loader-overlay { background: '.ot_get_option('ut_image_loader_background' , '#FFF').'}'. "\n";                
        
            }
            
            /*
            |--------------------------------------------------------------------------
            | Hero Settings
            |--------------------------------------------------------------------------
            */
                        
            /* hero global settings */
            $ut_hero_type  = ut_return_hero_config('ut_hero_type');
            $ut_hero_style = ut_return_hero_config('ut_hero_style' , 'ut-hero-style-1');
            
            /* hero color settings */
            $css .= '.hero-title span:not(.ut-word-rotator) { color:' . $accentcolor . ' !important; }'. "\n";
            $css .= '.hero-title.ut-glow span { text-shadow: 0 0 40px ' . $accentcolor . ', 2px 2px 3px black; }'. "\n";
            
            $ut_company_slogan_color = ut_return_hero_config('ut_company_slogan_color');
            if( !empty($ut_company_slogan_color) ) { 
            
                $css .= '.hero-title.ut-glow { 
                    color: '.$ut_company_slogan_color.';
                    text-shadow: 0 0 40px ' . $ut_company_slogan_color . ', 2px 2px 3px black; 
                }'. "\n";            
            
            }           
            
            /* hero font size */
            $ut_hero_font_size = ut_return_hero_config('ut_hero_font_size');            
            
                /* add to CSS */
                if( !empty($ut_hero_font_size) && $ut_hero_style != 'ut-hero-style-11' ) {
                    $css .= '@media screen and (min-width: 1025px) { .hero-title { font-size: '.$ut_hero_font_size.'; } }';            
                }
                        
            /* hero primary button style for all pages  */            
            if( ut_return_hero_config('ut_main_hero_button_style' , 'default' ) == 'custom') {
                
                $button_settings = ut_return_hero_config('ut_main_hero_button_settings');
                
                /* add to CSS */
                $css.= ut_create_button_style('.hero-btn' , $button_settings );
                
            }
            
            /* hero second button style for all pages */            
            if( ut_return_hero_config('ut_second_hero_button_style' , 'default' ) == 'custom') {
                
                $button_settings = ut_return_hero_config('ut_second_hero_button_settings');
                
                /* add to CSS */
                $css.= ut_create_button_style('.hero-second-btn' , $button_settings );
                
            }            
            
            /* hero border bottom */
            if( ut_return_hero_config('ut_hero_border_bottom' , 'off' ) == 'on') {
               
                /* add to CSS */
                $css.= '#ut-hero { border-bottom: '.ut_return_hero_config('ut_hero_border_bottom_width' , 1 ).'px '.ut_return_hero_config('ut_hero_border_bottom_style' , 'solid' ).' '.ut_return_hero_config('ut_hero_border_bottom_color' , $accentcolor ).'; }';
               
            }
            
            /* body font style */
            if( ot_get_option('ut_body_font_type' , 'ut-font') == 'ut-google' ) {
                
                $ut_google_body_font_style = ot_get_option('ut_google_body_font_style');
                
                if( !empty($google_fonts[$ut_google_body_font_style['font-id']]['family']) ) {
                
                    $css .= 'body {';
                        /* familiy */
                        $css .= 'font-family:"'.$google_fonts[$ut_google_body_font_style['font-id']]['family'].'", "Helvetica Neue", Helvetica, Arial, sans-serif !important;';                    
                        
                        if( !empty($ut_google_body_font_style['font-weight']) ) {
                            $css .= ' font-weight: ' . $ut_google_body_font_style['font-weight'] . ';';    
                        }
                        
                        if( !empty($ut_google_body_font_style['font-size']) ) {
                            $css .= ' font-size: ' . $ut_google_body_font_style['font-size'] . ';';    
                        }
                        
                        if( !empty($ut_google_body_font_style['font-style']) && isset($font_styles[$ut_google_body_font_style['font-style']]) ) {
                            $css .= ' font-style: ' . $font_styles[$ut_google_body_font_style['font-style']] . ';';    
                        }
                        
                        if( !empty($ut_google_body_font_style['line-height']) ) {
                            $css .= ' line-height: ' . $ut_google_body_font_style['line-height'] . ';';    
                        }
                        
                        if( !empty($ut_google_body_font_style['text-transform']) ) {
                            $css .= ' text-transform: ' . $ut_google_body_font_style['text-transform'] . ';';    
                        }
                        
                    $css .= '}';
                
                } else {
                    
                    /* fallback if user has not chosen a google font yet */
                    $ut_body_font_style = ot_get_option('ut_body_font_style' , 'regular');
                    $css .= 'body { font-family: ' . $ut_recognized_font_styles[$ut_body_font_style] . ', "Helvetica Neue", Helvetica, Arial, sans-serif; }'. "\n";
                    
                }
                
            } else {
                
                /* out for theme font */
                $ut_body_font_style = ot_get_option('ut_body_font_style' , 'regular');
                $css .= 'body { font-family: ' . $ut_recognized_font_styles[$ut_body_font_style] . ', "Helvetica Neue", Helvetica, Arial, sans-serif; }'. "\n";
                            
            }
            
            
            /* global headline font style */
            $headlines = array("h1","h2","h3","h4","h5","h6");
            
            foreach( $headlines as $headline ) {
                
                if( ot_get_option('ut_global_'.$headline.'_font_type' , 'ut-font') == 'ut-google' ) {
                    
                    $headline_style = ot_get_option('ut_'.$headline.'_google_font_style');
                    
                    if( !empty($google_fonts[$headline_style['font-id']]['family']) ) {
                        
                        $css .= $headline . ' {';
                        
                            /* familiy */
                            $css .= 'font-family:"'.$google_fonts[$headline_style['font-id']]['family'].'", "Helvetica Neue", Helvetica, Arial, sans-serif;';                    
                        
                        if( !empty($$headline_style['font-weight']) ) {
                            $css .= ' font-weight: ' . $headline_style['font-weight'] . ';';    
                        }
                        
                        if( !empty($headline_style['font-size']) ) {
                            $css .= ' font-size: ' . $headline_style['font-size'] . ';';    
                        }
                        
                        if( !empty($headline_style['font-style']) ) {
                            $css .= ' font-style: ' . $font_styles[$headline_style['font-style']] . ';';    
                        }
                        
                        if( !empty($headline_style['line-height']) ) {
                            $css .= ' line-height: ' . $headline_style['line-height'] . ';';    
                        }
                        
                        if( !empty($headline_style['text-transform']) ) {
                            $css .= ' text-transform: ' . $headline_style['text-transform'] . ';';    
                        }
                        
                        $css .= '}';
                        
                        
                    } else {
                        
                        /* fallback if user has not chosen a google font yet */
                        $headline_style = ot_get_option('ut_'.$headline.'_font_style' , 'semibold');
                        $css .= $headline . ' { font-family: ' . $ut_recognized_font_styles[$headline_style] . ', "Helvetica Neue", Helvetica, Arial, sans-serif; }'. "\n";
                        
                    }
                    
                
                } else {
                    
                    /* output for theme font */
                    $headline_style = ot_get_option('ut_'.$headline.'_font_style' , 'semibold');
                    $css .= $headline . ' { font-family: ' . $ut_recognized_font_styles[$headline_style] . ', "Helvetica Neue", Helvetica, Arial, sans-serif; }'. "\n";
                
                }
                
            }
            
            /*
            |--------------------------------------------------------------------------
            | Single Page and Portfolio Styling
            |--------------------------------------------------------------------------
            */
            if( !is_front_page() && ( is_page() || is_singular('portfolio') ) ) {
                
                /* hero active or not */
                if ( is_page() && get_post_meta( $post->ID , 'ut_activate_page_hero' , true ) == 'on' || is_singular('portfolio') && get_post_meta( $post->ID , 'ut_activate_page_hero' , true ) != 'off' ) {
                    $css .= '#primary { padding-top:80px; }';
                }               
                
                /* hero color styling */
                $ut_hero_caption_description_color = get_post_meta( $post->ID ,'ut_page_caption_description_color' , true);
                $ut_hero_caption_slogan_color = get_post_meta( $post->ID ,'ut_page_caption_slogan_color' , true);
                
                    /* add to CSS */
                    if( !empty($ut_hero_caption_description_color) ) {                    
                        $css.='.hero-description-bottom { color: ' . $ut_hero_caption_description_color . '}'. "\n";                    
                    }
                    
                    /* add to CSS */
                    if( !empty($ut_hero_caption_slogan_color) ) {
                        $css.='.hero-title { color: ' . $ut_hero_caption_slogan_color . ' }'. "\n";                    
                    }
                
                /* headlines */
                $ut_h1_font_style = get_post_meta( $post->ID , 'ut_section_header_font_style' , true );
                $css .= ut_create_global_headline_font_style('.page-title' , $ut_h1_font_style );
                
                $ut_page_header_style = get_post_meta( $post->ID , 'ut_section_header_style', true );
                $ut_page_header_style = ( !empty($ut_page_header_style) && $ut_page_header_style != 'global' ) ? $ut_page_header_style : ot_get_option('ut_global_headline_style');
                
                $ut_page_title_color = get_post_meta( $post->ID , 'ut_section_title_color' , true);
                $ut_section_title_shadow_color = get_post_meta( $post->ID , 'ut_section_shadow_color' , true); 
                
                /* pt style 3 needs a fallback */
                if( empty($ut_page_title_color) && $ut_page_header_style == 'pt-style-3') {
                    $ut_page_title_color = $accentcolor;
                }
                                
                    /* add to CSS */
                    if( !empty($ut_page_title_color) ) {
                        $css.= ( is_page() ? '.page-id-' : '.postid-' ) . $post->ID . ' #primary .page-title { color: ' . $ut_page_title_color . '; }'. "\n";
                        $css.= create_section_headline_style( ( is_page() ? '.page-id-' : '.postid-' ) . $post->ID . ' #primary' , $ut_page_header_style , $ut_page_title_color , $ut_section_title_shadow_color);                    
                    }
                
                /* content background */
                $ut_page_background_color = get_post_meta( $post->ID , 'ut_section_background_color' , true);
                
                    /* add to CSS */
                    if( !empty($ut_page_background_color) ) {
                        $css.= '.main-content-background { background-color: ' . $ut_page_background_color . '; }'. "\n";
                        $css.= '.main-content-background .page-header.pt-style-1 .page-title span  { background-color: ' . $ut_page_background_color . '; }'. "\n";
                    }
                
                /* header glow */
                if( get_post_meta( $post->ID , 'ut_section_title_glow' , true) == 'on' ) {
                                
                    $ut_page_title_color      = get_post_meta( $post->ID , 'ut_section_title_color' , true);
                    $ut_page_title_glow_color = get_post_meta( $post->ID , 'ut_section_title_glow_color' , true);
                    
                    if( !empty($ut_page_title_color) ) {                                
                    
                        $css.= ( is_page() ? '.page-id-' : '.postid-' ) . $post->ID . ' #primary .page-title.ut-glow { 
                            text-shadow: 0 0 40px ' . $ut_page_title_color . ', 2px 2px 3px black ; 
                        }'. "\n";
                    
                    }
                    
                    if( !empty($ut_page_title_glow_color) ) {                                
                    
                        $css.= ( is_page() ? '.page-id-' : '.postid-' ) . $post->ID . ' #primary .page-title.ut-glow { 
                            text-shadow: 0 0 40px ' . $ut_page_title_glow_color . ', 2px 2px 3px black ; 
                        }'. "\n";
                    
                    }
                                                
                }
                
                /* header margin */
                $ut_page_header_margin_left  = get_post_meta( $post->ID , 'ut_section_header_margin_left' , true);
                $ut_page_header_margin_right = get_post_meta( $post->ID , 'ut_section_header_margin_right' , true);
                
                    /* add to CSS */
                    if( !empty($ut_page_header_margin_left) ) {
                        $css.= '#primary header.page-header { margin-left:'.$ut_page_header_margin_left.'; }'. "\n";
                    }
                     
                    /* add to CSS */ 
                    if( !empty($ut_page_header_margin_right) ) {
                        $css.= '#primary header.page-header { margin-right:'.$ut_page_header_margin_right.'; }'. "\n";
                    }
                
                /* page slogan upperase */
                $ut_page_caption_slogan_uppercase = get_post_meta( $post->ID ,'ut_page_caption_slogan_uppercase' , true);
                
                    /* add to CSS */
                    if( $ut_page_caption_slogan_uppercase == 'on' ) {                    
                        $css.='.hero-title { text-transform: uppercase; }';                
                    }
                
                /* page slogan color */
                $ut_page_slogan_color = get_post_meta( $post->ID , 'ut_section_slogan_color' , true);
                
                    /* add to CSS */
                    if( !empty($ut_page_slogan_color) ) {
                        $css.= '#primary .lead { color: ' . $ut_page_slogan_color . '; }'. "\n"; 
                    }
                
                /* page slogan padding bottom */
                $ut_page_slogan_padding = get_post_meta( $post->ID , 'ut_section_slogan_padding' , true);
                $ut_page_slogan_padding = !empty($ut_page_slogan_padding) ? $ut_page_slogan_padding : '';
                
                    /* add to CSS */
                    if(!empty($ut_page_slogan_padding)) { 
                        $css .= '#primary .page-header { padding-bottom:' . $ut_page_slogan_padding . '; }'. "\n";
                    }
                
                /* page slogan padding left and right */
                $ut_section_slogan_padding_left  = get_post_meta( $post->ID , 'ut_section_slogan_padding_left' , true);
                $ut_section_slogan_padding_right = get_post_meta( $post->ID , 'ut_section_slogan_padding_right' , true);
                
                    /* add to CSS */
                    if( !empty($ut_section_slogan_padding_left) ) {
                        $css.= '#primary .lead { padding-left: ' . $ut_section_slogan_padding_left . '; }'. "\n"; 
                    }
                    
                    /* add to CSS */
                    if( !empty($ut_section_slogan_padding_right) ) {
                        $css.= '#primary .lead { padding-right: ' . $ut_section_slogan_padding_right . '; }'. "\n"; 
                    }                
                
                /* page text color */
                $ut_page_text_color = get_post_meta( $post->ID , 'ut_section_text_color' , true);
                
                    /* add to CSS */
                    if( !empty($ut_page_text_color) ) {
                        $css.= '#primary .entry-content { color: ' . $ut_page_text_color . '; }'. "\n"; 
                    }
                
                /* page headlines text color */
                $ut_page_heading_color = get_post_meta( $post->ID , 'ut_section_heading_color' , true);
                
                    /* add to CSS */
                    if( !empty($ut_page_heading_color) ) {
                        
                        /* add to CSS */
                        $css.= '#primary .entry-content h1 { color: ' . $ut_page_heading_color . ' !important; }'. "\n";
                        $css.= '#primary .entry-content h2 { color: ' . $ut_page_heading_color . ' !important; }'. "\n"; 
                        $css.= '#primary .entry-content h3 { color: ' . $ut_page_heading_color . ' !important; }'. "\n"; 
                        $css.= '#primary .entry-content h4 { color: ' . $ut_page_heading_color . ' !important; }'. "\n"; 
                        $css.= '#primary .entry-content h5 { color: ' . $ut_page_heading_color . ' !important; }'. "\n"; 
                        $css.= '#primary .entry-content h6 { color: ' . $ut_page_heading_color . ' !important; }'. "\n";
                          
                    }
                
                
            }
            
            /*
            |--------------------------------------------------------------------------
            | Front Page
            |--------------------------------------------------------------------------
            */
            
            if( is_front_page() ) {
            
                /* front page hero header styling */
                $ut_front_expertise_slogan_color = ot_get_option('ut_front_expertise_slogan_color');
                $ut_front_company_slogan_color = ot_get_option('ut_front_company_slogan_color');
                
                    /* add to CSS */            
                    if( !empty( $ut_front_expertise_slogan_color ) ) {                    
                        $css.='.hero-description-bottom { color: ' . $ut_front_expertise_slogan_color . '}'. "\n";                    
                    }
                    
                    /* add to CSS */
                    if( !empty( $ut_front_company_slogan_color ) ) {                    
                        $css.='.hero-title { color: ' . $ut_front_company_slogan_color . ' }'. "\n";                    
                    }
                
                $ut_front_company_slogan_uppercase = ot_get_option('ut_front_company_slogan_uppercase' , 'on');
                
                    /* add to CSS */                
                    if( !empty( $ut_front_company_slogan_uppercase ) && $ut_front_company_slogan_uppercase == 'on' ) {
                        
                        $css.='.hero-title { text-transform: uppercase; }';
                    
                    }
            
            }
                        
            /* hero holder adjustment when navigation is visible */
            if( (ot_get_option('ut_navigation_state') == 'on_transparent' || ot_get_option('ut_navigation_state') == 'on') && ( $ut_hero_type == 'splithero' && ut_return_hero_config('ut_hero_split_content_type' , 'image') == 'image' )) {
                $css.= '#ut-hero .hero-holder { margin-top:80px; }';
            }
            
            /* header hero font style for front and blog */
            if( is_front_page() || is_singular('portfolio') || is_page() ) {                
                
                if( ot_get_option('ut_front_hero_font_type' , 'ut-font') == 'ut-google' ) {
                
                    $ut_google_front_page_hero_font_style = ot_get_option('ut_google_front_page_hero_font_style');
                    
                    if( !empty($google_fonts[$ut_google_front_page_hero_font_style['font-id']]['family']) ) {
                                                
                        if( $ut_hero_style == 'ut-hero-style-11') {
                            $css.= '#ut-hero .hdh .hero-description,';
                        }
                        
                        $css .= '.hero-title {';
                            
                            /* familiy */
                            $css .= 'font-family:"'.$google_fonts[$ut_google_front_page_hero_font_style['font-id']]['family'].'", "Helvetica Neue", Helvetica, Arial, sans-serif;';                    
                            
                            if( !empty($ut_google_front_page_hero_font_style['font-weight']) ) {
                                $css .= ' font-weight: ' . $ut_google_front_page_hero_font_style['font-weight'] . ';';    
                            }
                            
                            if( !empty($ut_google_front_page_hero_font_style['font-size']) ) {
                                $css .= ' font-size: ' . $ut_google_front_page_hero_font_style['font-size'] . ';';    
                            }
                            
                            if( !empty($ut_google_front_page_hero_font_style['font-style']) ) {
                                $css .= ' font-style: ' . $font_styles[$ut_google_front_page_hero_font_style['font-style']] . ';';    
                            }
                            
                            if( !empty($ut_google_front_page_hero_font_style['line-height']) ) {
                                $css .= ' line-height: ' . $ut_google_front_page_hero_font_style['line-height'] . ';';    
                            }
                            
                            if( !empty($ut_google_front_page_hero_font_style['text-transform']) ) {
                                $css .= ' text-transform: ' . $ut_google_front_page_hero_font_style['text-transform'] . ';';    
                            }
                            
                        $css .= '}';
                    
                    } else {
                        
                        /* fallback if user has not chosen a google font yet */
                        $ut_header_hero_font_style = ot_get_option('ut_front_page_hero_font_style' , 'semibold');
                        
                        if( $ut_hero_style == 'ut-hero-style-11') {
                            $css.= '#ut-hero .hdh .hero-description,';
                        }                        
                        
                        $css .= '.hero-title { font-family: ' . $ut_recognized_font_styles[$ut_header_hero_font_style] . ', "Helvetica Neue", Helvetica, Arial, sans-serif; }'. "\n";
                        
                    }
                    
                } else {
                    
                    /* out for theme font */
                    $ut_hero_font_style = ut_return_hero_config('ut_hero_font_style' , 'semibold');
                    
                    /* design exception for hero */ 
                    if( $ut_hero_style == 'ut-hero-style-11') {
                        $css.= '#ut-hero .hdh .hero-description,';
                    }
                    
                    $css .= '.hero-title { font-family: ' . $ut_recognized_font_styles[$ut_hero_font_style] . ', "Helvetica Neue", Helvetica, Arial, sans-serif; }'. "\n";
                                
                }

                
            }
            
            if( is_home() ) {
                
                if( ot_get_option('ut_blog_hero_font_type' , 'ut-font') == 'ut-google' ) {
            
                    $ut_google_blog_hero_font_style = ot_get_option('ut_google_blog_hero_font_style');
                    
                    if( !empty($google_fonts[$ut_google_blog_hero_font_style['font-id']]['family']) ) {
                        
                        /* design exception for hero */
                        if( $ut_hero_style == 'ut-hero-style-11') {
                            $css.= '#ut-hero .hdh .hero-description,';
                        }
                        
                        $css .= '.hero-title {';
                            /* familiy */
                            $css .= 'font-family:"'.$google_fonts[$ut_google_blog_hero_font_style['font-id']]['family'].'", "Helvetica Neue", Helvetica, Arial, sans-serif;';                    
                            
                            if( !empty($ut_google_blog_hero_font_style['font-weight']) ) {
                                $css .= ' font-weight: ' . $ut_google_blog_hero_font_style['font-weight'] . ';';    
                            }
                            
                            if( !empty($ut_google_blog_hero_font_style['font-size']) ) {
                                $css .= ' font-size: ' . $ut_google_blog_hero_font_style['font-size'] . ';';    
                            }
                            
                            if( !empty($ut_google_blog_hero_font_style['font-style']) ) {
                                $css .= ' font-style: ' . $font_styles[$ut_google_blog_hero_font_style['font-style']] . ';';    
                            }
                            
                            if( !empty($ut_google_blog_hero_font_style['line-height']) ) {
                                $css .= ' font-style: ' . $ut_google_blog_hero_font_style['line-height'] . ';';    
                            }
                            
                            if( !empty($ut_google_blog_hero_font_style['text-transform']) ) {
                                $css .= ' text-transform: ' . $ut_google_blog_hero_font_style['text-transform'] . ';';    
                            }
                            
                        $css .= '}';
                    
                    } else {
                        
                        /* fallback if user has not chosen a google font yet */
                        $ut_header_hero_font_style = ot_get_option('ut_blog_hero_font_style' , 'semibold');    
                        $css .= '.hero-title { font-family: ' . $ut_recognized_font_styles[$ut_header_hero_font_style] . ', "Helvetica Neue", Helvetica, Arial, sans-serif; }'. "\n";
                        
                    }
                    
                } else {
                    
                    /* out for theme font */
                    $ut_header_hero_font_style = ot_get_option('ut_blog_hero_font_style' , 'semibold');    
                    $css .= '.hero-title { font-family: ' . $ut_recognized_font_styles[$ut_header_hero_font_style] . ', "Helvetica Neue", Helvetica, Arial, sans-serif; }'. "\n";
                                
                }

            }
            
            
            /* hero header background image for tablet slider */
            if( $ut_hero_type == 'tabs' ) {
                
                $ut_tabs_headline_style = ut_return_hero_config('ut_tabs_headline_style' , 'semibold');
                $css .= ut_create_global_headline_font_style('.ut-tablets-title' , $ut_tabs_headline_style);
                
                /* hero type tabs uses a different header image */            
                $css .= ut_create_css_background( '.hero' , ut_return_hero_config('ut_hero_image' , '' , true ));
                
            }
            
            /* hero header background image for image hero */
            if( $ut_hero_type == 'image' || $ut_hero_type == 'splithero' ) {
                
                $ut_hero_image = ut_return_hero_config('ut_hero_image');                            
                
                if( is_array($ut_hero_image) && !empty( $ut_hero_image['background-image'] ) ) {
                    
                    /*no background if rain effect is active */
                    $css .= ut_create_css_background( '.hero' , $ut_hero_image );
                    
                } elseif( !empty($ut_hero_image) && !is_array($ut_hero_image) ) {
                    
                    /* fallback to version 1.0 */
                    $css .= '.hero { background-image: url(' . esc_url( $ut_hero_image ) . '); }'. "\n";
                
                }                
            
            }
            
            /* video poster */
            if( $detect->isMobile() && $ut_hero_type == 'video' ) :
                
                /* video poster image for mobile devices */
                $ut_video_poster = ut_return_hero_config('ut_video_poster');                                     
                
                /* hero can be an image , so we need to check the hero type */
                if( !empty($ut_video_poster) ) {
                    $css .= '.hero { 
                        background-image: url(' . esc_url( $ut_video_poster ) . ');
                        background-size: cover !important;
                        background-attachment: scroll !important;
                    }'. "\n";                    
                }
                                    
                $css .= '.ut-video-control {
                    display:none !important;
                }';                    
                
            endif;            
            
            /* video position for selfhosted video */
            if( ut_return_hero_config('ut_video_source' , 'youtube') == 'selfhosted' && !$detect->isMobile() && ut_return_hero_config('ut_video_containment' , 'hero') == 'body' && is_front_page() ) {                
                $css .= '.ut-video-container { position:fixed; }';                               
            }
                        
            /* split hero */
            if( $ut_hero_type == 'splithero' ) {
                
                $split_image_max_width = ut_return_hero_config('ut_hero_split_image_width');
                
                /* check if value is available */
                $split_image_max_width = empty($split_image_max_width) ? '60' : $split_image_max_width;
                
                $css .= '#ut-hero .ut-split-image { max-width: ' . $split_image_max_width . '% !important; }';
                
            
            }
            
            /* hero header background image for animated image hero */
            if( $ut_hero_type == 'animatedimage' ) {
                
                $header_image = ut_return_hero_config('ut_hero_animated_image');
                
                if( !empty($header_image) ) {
                
                    /* get image ID by url*/
                    $imageID = ut_get_image_id( $header_image );
                    
                    /* grab image imnformation */                    
                    $imageinfo = wp_get_attachment_image_src( $imageID , 'full' );                    
                                        
                    /* background */
                    $css .= '.hero { 
                            background-position: 0px 0px;
                            background-repeat: repeat-x;
                            background-image: url(' . esc_url( $header_image ) . '); 
                            -webkit-animation: animatedBackground 60s linear infinite;
                            -moz-animation: animatedBackground 60s linear infinite;
                            animation: animatedBackground 60s linear infinite;
                        }'. "\n";
                    
                    $css .= '@media screen and (max-width: 1024px) {
                        
                        .hero {
                            -webkit-animation: none !important;
                            -moz-animation: none !important;
                            animation: none !important;
                        }
                        
                    }';
                    
                    $css .= '@keyframes animatedBackground {
                                from { background-position: 0 0; }
                                to { background-position: '.$imageinfo[1].'px 0; }
                            }
                            @-webkit-keyframes animatedBackground {
                                from { background-position: 0 0; }
                                to { background-position: '.$imageinfo[1].'px 0; }
                            }
                            @-moz-keyframe animatedBackground {
                                from { background-position: 0 0; }
                                to { background-position: '.$imageinfo[1].'px 0; }
                            }';
                    
                    }
                    
            }
            
            /* fancy slider */
            $fancy_slider_height = $ut_hero_type == 'transition' ? ut_return_hero_config('ut_fancy_slider_height' , '600px') : '';
            if ( !empty( $fancy_slider_height ) ) {
                $css .= '.ut-fancy-slider-fullwidth { height: ' . $fancy_slider_height . '; }';
                $css .= '.ut-fancy-slider-fullwidth .hero-inner { height: ' . $fancy_slider_height . '; }';
            }
            
            /* header overlay styling */
            $ut_hero_overlay_color = ut_return_hero_config('ut_hero_overlay_color');
            $ut_hero_overlay_color_opacity = ut_return_hero_config('ut_hero_overlay_color_opacity' , '0.8');
                                    
            if( !empty($ut_hero_overlay_color) ) {
                $css.= '.hero .parallax-overlay { background-color: rgba(' . ut_hex_to_rgb( $ut_hero_overlay_color ) . ' , ' . $ut_hero_overlay_color_opacity . ' ); }'. "\n";
            }
            
            
            /* blog hero header styling */
            $ut_blog_expertise_slogan_color = ot_get_option('ut_blog_expertise_slogan_color');
            $ut_blog_company_slogan_color     = ot_get_option('ut_blog_company_slogan_color');
            
            if( !empty( $ut_blog_expertise_slogan_color ) && is_home() ) {
                
                $css.='.hero-description-bottom { color: ' . $ut_blog_expertise_slogan_color . '}'. "\n";
                
            }
            
            if( !empty( $ut_blog_company_slogan_color ) && is_home() ) {
                
                $css.='.hero-title { color: ' . $ut_blog_company_slogan_color . ' }'. "\n";
                
            }
            
            $ut_blog_company_slogan_uppercase = ot_get_option('ut_blog_company_slogan_uppercase' , 'on');
            
            if( !empty( $ut_blog_company_slogan_uppercase ) && is_home() && $ut_blog_company_slogan_uppercase == 'on' ) {
                
                $css.='.hero-title { text-transform: uppercase; }';
            
            }
            
            /* check if contact section is active*/
            $ut_activate_csection = ut_return_csection_config('ut_activate_csection');
            
            /* only get contact section styles if footer is active */
            if( $ut_activate_csection == 'on' ) {
                                        
                /* contact section header styling */
                $ut_csection_header_slogan_color = ot_get_option('ut_csection_header_slogan_color');
                $ut_csection_header_expertise_slogan_color = ot_get_option('ut_csection_header_expertise_slogan_color');
                
                $ut_csection_header_style = ot_get_option('ut_csection_header_style' , 'pt-style-1');
                $ut_csection_header_style = $ut_csection_header_style == 'global' ? ot_get_option('ut_global_headline_style') : $ut_csection_header_style;
                
                /* pt style 3 needs a fallback */
                if( empty($ut_csection_header_slogan_color) && $ut_csection_header_style == 'pt-style-3') {
                    $ut_csection_header_slogan_color = $accentcolor;
                }
                
                if( !empty( $ut_csection_header_slogan_color ) ) {
                    
                    $css.='#contact-section .parallax-title { color: ' . $ut_csection_header_slogan_color . '}'. "\n";
                    $css.= create_section_headline_style('#contact-section' , $ut_csection_header_style , $ut_csection_header_slogan_color);
                    
                }
                
                if( !empty( $ut_csection_header_expertise_slogan_color ) ) {
                    
                    $css.='#contact-section .lead { color: ' . $ut_csection_header_expertise_slogan_color . ' }'. "\n";
                    
                }
                
                if( ot_get_option('ut_csection_title_uppercase' , 'off') == 'on' ) {
                    $css.='#contact-section .parallax-title { text-transform: uppercase; }';
                }
                
                $css .= '#contact-section .parallax-title span span { color:' . $accentcolor . '; }'. "\n";                
                                
                /* contact section section styles */
                $csection_background = null;
                $csection_background_type = ot_get_option('ut_csection_background_type' , 'image');
            
                /* contact section styling */
                if($csection_background_type=='image') {
                    
                    $ut_csection_background_image = ut_return_csection_config('ut_csection_background_image');                
                    
                    if( is_array($ut_csection_background_image) && !empty($ut_csection_background_image['background-image'] ) ) {                    
                        
                        $csection_background .= ut_create_css_background( '#contact-section' , $ut_csection_background_image );                        
                        $ut_csection_background_image = $ut_csection_background_image['background-image'];
                    
                    } elseif( !is_array($ut_csection_background_image) ) {
                        
                        $csection_background .= !empty( $ut_csection_background_image ) ? '#contact-section { background-image: url(' . esc_url( $ut_csection_background_image ) . '); }'. "\n" : '';                        
                    
                    }
                    
                }
                /* video poster image */
                if( $csection_background_type == 'video' && $detect->isMobile() || $detect->isMobile() && ot_get_option('ut_front_video_containment' ,'hero') == 'body' ) {
                    
                    $ut_csection_video_poster = ot_get_option('ut_csection_video_poster');    
                    
                    /* video poster image for mobile devices */    
                    $css .= '#contact-section { 
                          background-image: url(' . esc_url( $ut_csection_video_poster ) . '); 
                          background-size: cover !important;
                          background-attachment: scroll !important;
                    }'. "\n";
                
                }
                
                /* there is no image, so we check if a background color has been set */
                $ut_csection_background_color = ot_get_option('ut_csection_background_color');
                if( empty( $ut_csection_background_image ) ) {
                    
                    $csection_background .= !empty( $ut_csection_background_color ) ? '#contact-section { background: ' . $ut_csection_background_color . '; }'. "\n" : '';
                
                }
                                    
                /* add to CSS */
                $css .= $csection_background;
                
                /* contact section header font style */
                if( ot_get_option('ut_csection_header_font_type' , 'ut-font') == 'ut-google' ) :
                 
                        $ut_csection_header_google_font_style = ot_get_option('ut_csection_header_google_font_style');                
                    
                        if( !empty($google_fonts[ $ut_csection_header_google_font_style['font-id']]['family']) ) {
                        
                            $font = '#contact-section .parallax-title {';
                                
                                $font .= 'font-family:"'.$google_fonts[$ut_csection_header_google_font_style['font-id']]['family'].'", "Helvetica Neue", Helvetica, Arial, sans-serif;';                    
                                
                                if( !empty( $ut_csection_header_google_font_style['font-weight']) ) {
                                    $font .= ' font-weight: ' .  $ut_csection_header_google_font_style['font-weight'] . ';';    
                                }
                                
                                if( !empty( $ut_csection_header_google_font_style['font-size']) ) {
                                    $font .= ' font-size: ' .  $ut_csection_header_google_font_style['font-size'] . ';';    
                                }
                                
                                if( !empty( $ut_csection_header_google_font_style['font-style']) && isset($font_styles[ $ut_csection_header_google_font_style['font-style']]) ) {
                                    $font .= ' font-style: ' . $font_styles[ $ut_csection_header_google_font_style['font-style']] . ';';    
                                }
                                
                                if( !empty( $ut_csection_header_google_font_style['line-height']) ) {
                                    $font .= ' line-height: ' .  $ut_csection_header_google_font_style['line-height'] . ';';    
                                }
                                
                                if( !empty( $ut_csection_header_google_font_style['text-transform']) ) {
                                    $font .= ' text-transform: ' .  $ut_csection_header_google_font_style['text-transform'] . ';';    
                                }
                                
                            $font .= '}';
                            
                            $css .= $font;
                        
                        } else {
                        
                            /* fallback if user has not chosen a google font yet */
                            $font_style = ot_get_option('ut_csection_header_font_style' , 'semibold');
                            if( isset($ut_recognized_font_styles[$font_style]) ) {
                                $css .= '#contact-section .parallax-title { font-family: ' . $ut_recognized_font_styles[$font_style] . ', "Helvetica Neue", Helvetica, Arial, sans-serif;}'. "\n";
                            }
                        }
                    
                else :
                    
                    $font_style = ot_get_option('ut_csection_header_font_style' , 'semibold');
                    if( isset($ut_recognized_font_styles[$font_style]) ) {
                        $css .= '#contact-section .parallax-title { font-family: ' . $ut_recognized_font_styles[$font_style] . ', "Helvetica Neue", Helvetica, Arial, sans-serif;}'. "\n";                     
                    }
                    
                endif;
                
                
                
                 /* contact section border styling */
                if( ot_get_option('ut_activate_csection_border' , 'off') == 'on' ) {
                    
                    /* border settings */
                    $ut_csection_border_color = ot_get_option('ut_csection_border_color');                                
                    $ut_csection_border_color = !empty($ut_csection_border_color) ? $ut_csection_border_color : $accentcolor;                                
                    $ut_csection_border_width = ot_get_option('ut_csection_border_width'); 
                    $ut_csection_border_width = !empty( $ut_csection_border_width) ?  $ut_csection_border_width : '1'; 
                    $ut_csection_border_style =  ot_get_option('ut_csection_border_style'); 
                    $ut_csection_border_style = !empty( $ut_csection_border_style) ?  $ut_csection_border_style : 'solid';                               
                   
                    /* add to CSS */
                    $css.= '#contact-section { border-top: '.$ut_csection_border_width.'px '.$ut_csection_border_style.' '.$ut_csection_border_color.'; }';
                
                }
                
                
                /* contact section box styling */
                $ut_left_csection_content_area_color = ot_get_option('ut_left_csection_content_area_color');
                $ut_right_csection_content_area_color = ot_get_option('ut_right_csection_content_area_color');
                
                $ut_left_csection_content_area_opacity = ot_get_option('ut_left_csection_content_area_opacity' , '0.8' );
                $ut_right_csection_content_area_opacity = ot_get_option('ut_right_csection_content_area_opacity', '0.8' );
                
                    $css .= !empty( $ut_left_csection_content_area_color )  ? '#contact-section .ut-left-footer-area { background: rgb(' . ut_hex_to_rgb( $ut_left_csection_content_area_color ) . ',' . $ut_left_csection_content_area_opacity . '); }'. "\n" : '';
                    $css .= !empty( $ut_left_csection_content_area_color )  ? '#contact-section .ut-left-footer-area { background: rgba(' . ut_hex_to_rgb( $ut_left_csection_content_area_color ) . ',' . $ut_left_csection_content_area_opacity . '); }'. "\n" : '';
                    $css .= !empty( $ut_right_csection_content_area_color ) ? '#contact-section .ut-right-footer-area { background: rgb(' . ut_hex_to_rgb( $ut_right_csection_content_area_color ) . ',' . $ut_right_csection_content_area_opacity . '); }'. "\n" : '';
                    $css .= !empty( $ut_right_csection_content_area_color ) ? '#contact-section .ut-right-footer-area { background: rgba(' . ut_hex_to_rgb( $ut_right_csection_content_area_color ) . ',' . $ut_right_csection_content_area_opacity . '); }'. "\n" : '';
                
                /* contact section overlay color */
                $ut_csection_overlay = ut_return_csection_config('ut_csection_overlay', 'on');
                $ut_csection_overlay_color = ut_return_csection_config('ut_csection_overlay_color');
                $ut_csection_overlay_opacity = ut_return_csection_config('ut_csection_overlay_opacity' , '0.8');
                
                    $css .= !empty( $ut_csection_overlay_color )  ? '#contact-section .parallax-overlay { background: rgb(' . ut_hex_to_rgb( $ut_csection_overlay_color ) . ',' . $ut_csection_overlay_opacity . '); }'. "\n" : '';
                    $css .= !empty( $ut_csection_overlay_color )  ? '#contact-section .parallax-overlay { background: rgba(' . ut_hex_to_rgb( $ut_csection_overlay_color ) . ',' . $ut_csection_overlay_opacity . '); }'. "\n" : '';
                
                /* contact section section padding */
                $ut_csection_padding_top = ot_get_option('ut_csection_padding_top');
                $ut_csection_padding_bottom = ot_get_option('ut_csection_padding_bottom');
                
                    /* fallback if there is no entry */
                    $ut_csection_padding_top = empty($ut_csection_padding_top) ? '80px' : $ut_csection_padding_top;
                    $ut_csection_padding_bottom = empty($ut_csection_padding_bottom) ? '60px' : $ut_csection_padding_bottom;
                    
                    if( $ut_csection_overlay == 'on' ) {
                    
                        $css .= '#contact-section .parallax-overlay { padding-top:' . $ut_csection_padding_top . '; padding-bottom:' . $ut_csection_padding_bottom . '; }'. "\n";                        
                        $css .= '#contact-section .ut-offset-anchor { top:-' . ( 79 + str_replace("px" , "" , $ut_navigation_padding_top) + str_replace("px" , "" , $ut_navigation_padding_bottom) ) . 'px; }'. "\n";
                        
                    } else {
                        
                        $css .= '#contact-section { padding-top:' . $ut_csection_padding_top . '; padding-bottom:' . $ut_csection_padding_bottom . '; }'. "\n";
                        $css .= '#contact-section .ut-offset-anchor { top:-' . ( 79 + str_replace("px" , "" , $ut_csection_padding_top) + str_replace("px" , "" , $ut_navigation_padding_top) + str_replace("px" , "" , $ut_navigation_padding_bottom) ) . 'px; }'. "\n";
                        
                    }
                    
                
            } /* end $ut_activate_csection */
            
            /* copyright */
            if(  ot_get_option('ut_footer_font_weight' , 'normal') == 'bold' ) {
                
                $css .= '.copyright { font-family: "ralewaysemibold", Helvetica, Arial, sans-serif !important; }';
                
            }
            
            /* theme options misc settings */
            if( ot_get_option('ut_blockquote_font_type' , 'ut-font') == 'ut-google' ) {
            
                    $ut_google_blockquote_font_style = ot_get_option('ut_google_blockquote_font_style');
                    
                    if( !empty($google_fonts[$ut_google_blockquote_font_style['font-id']]['family']) ) {
                    
                        $css .= 'blockquote {';
                            /* familiy */
                            $css .= 'font-family:"'.$google_fonts[$ut_google_blockquote_font_style['font-id']]['family'].'", "Helvetica Neue", Helvetica, Arial, sans-serif;';                    
                            
                            if( !empty($ut_google_blockquote_font_style['font-weight']) ) {
                                $css .= ' font-weight: ' . $ut_google_blockquote_font_style['font-weight'] . ';';    
                            }
                            
                            if( !empty($ut_google_blockquote_font_style['font-size']) ) {
                                $css .= ' font-size: ' . $ut_google_blockquote_font_style['font-size'] . ';';    
                            }
                            
                            if( !empty($ut_google_blockquote_font_style['font-style']) ) {
                                $css .= ' font-style: ' . $font_styles[$ut_google_blockquote_font_style['font-style']] . ';';    
                            }
                            
                            if( !empty($ut_google_blockquote_font_style['text-transform']) ) {
                                $css .= ' text-transform: ' . $ut_google_blockquote_font_style['text-transform'] . ';';    
                            }
                            
                        $css .= '}';
                    
                    } else {
                        
                        /* fallback if user has not chosen a google font yet */
                        $ut_blockquote_font_style = ot_get_option('ut_blockquote_font_style' , 'semibold');    
                        $css .= 'blockquote { font-family: ' . $ut_recognized_font_styles[$ut_blockquote_font_style] . ', "Helvetica Neue", Helvetica, Arial, sans-serif; }'. "\n";
                        
                    }
                    
                } else {
                    
                    /* out for theme font */
                    $ut_blockquote_font_style = ot_get_option('ut_blockquote_font_style' , 'semibold');    
                    $css .= 'blockquote { font-family: ' . $ut_recognized_font_styles[$ut_blockquote_font_style] . ', "Helvetica Neue", Helvetica, Arial, sans-serif; }'. "\n";
                                
            }
            
            if( ot_get_option('ut_global_lead_font_type' , 'ut-font') == 'ut-google' ) {
            
                    $ut_google_lead_font_style = ot_get_option('ut_google_lead_font_style');
                    
                    if( !empty($google_fonts[$ut_google_lead_font_style['font-id']]['family']) ) {
                    
                        $css .= '.lead, .taxonomy-description {';
                            /* familiy */
                            $css .= 'font-family:"'.$google_fonts[$ut_google_lead_font_style['font-id']]['family'].'", "Helvetica Neue", Helvetica, Arial, sans-serif;';                    
                            
                            if( !empty($ut_google_lead_font_style['font-weight']) ) {
                                $css .= ' font-weight: ' . $ut_google_lead_font_style['font-weight'] . ';';    
                            }
                            
                            if( !empty($ut_google_lead_font_style['font-size']) ) {
                                $css .= ' font-size: ' . $ut_google_lead_font_style['font-size'] . ';';    
                            }
                            
                            if( !empty($ut_google_lead_font_style['font-style']) ) {
                                $css .= ' font-style: ' . $font_styles[$ut_google_lead_font_style['font-style']] . ';';    
                            }
                            
                            if( !empty($ut_google_lead_font_style['text-transform']) ) {
                                $css .= ' text-transform: ' . $ut_google_lead_font_style['text-transform'] . ';';    
                            }
                            
                        $css .= '}';
                    
                    } else {
                        
                        /* fallback if user has not chosen a google font yet */
                        $ut_lead_font_style = ot_get_option('ut_lead_font_style' , 'semibold');    
                        $css .= '.lead, .taxonomy-description { font-family: ' . $ut_recognized_font_styles[$ut_lead_font_style] . ', "Helvetica Neue", Helvetica, Arial, sans-serif; }'. "\n";
                        
                    }
                    
                } else {
                    
                    /* out for theme font */
                    $ut_lead_font_style = ot_get_option('ut_lead_font_style' , 'semibold');    
                    $css .= '.lead, .taxonomy-description { font-family: ' . $ut_recognized_font_styles[$ut_lead_font_style] . ', "Helvetica Neue", Helvetica, Arial, sans-serif; }'. "\n";
                                
            }
            
            /* loader logo */
            $ut_site_logo = get_theme_mod( 'ut_site_logo' );
            $loader_logo = ot_get_option('ut_image_loader_logo' , $ut_site_logo );
            
            if ( !empty($loader_logo) ) {
                $css .= '#ut-loader-logo { background-image: url(' . esc_url( $loader_logo ) . '); background-position: center center; background-repeat: no-repeat; }'. "\n";
            }
                        
            /*
            |--------------------------------------------------------------------------
            | Footer Skin & Border
            |--------------------------------------------------------------------------
            */
            
            if( ot_get_option('ut_footer_skin' , 'ut-footer-light' ) == 'ut-footer-light' ) {
                
                $ut_footer_skin_light_bgcolor = ot_get_option('ut_footer_skin_light_bgcolor');
                
                if( !empty( $ut_footer_skin_light_bgcolor ) ) {
                    
                    /* add to CSS */
                    $css .= '.footer, a.toTop {
                        background: '.$ut_footer_skin_light_bgcolor.' ;
                    }'; 
                    
                }
                
            } else {
                
                $ut_footer_skin_dark_bgcolor = ot_get_option('ut_footer_skin_dark_bgcolor');
                
                if( !empty( $ut_footer_skin_dark_bgcolor ) ) {
                    
                   /* add to CSS */ 
                   $css .= '.footer.ut-footer-dark, .ut-footer-dark a.toTop {
                        background: '.$ut_footer_skin_dark_bgcolor.' ;
                   }'; 
                    
                }
                    
            }
            
            /* footer border */
            $ut_footer_skin_border = ot_get_option('ut_footer_skin_border');
            
                /* add to CSS */            
                if( !empty($ut_footer_skin_border) ) {
                    
                    $css .= '.footer { border-top: 1px solid '.$ut_footer_skin_border.'; }';
                    $css .= 'a.toTop { border: 1px solid '.$ut_footer_skin_border.'; border-bottom: none; }';
                } 
            
            /* subfooter backgroundcolor  */
            $ut_subfooter_bgcolor = ot_get_option('ut_subfooter_bgcolor');
            
                /* add to CSS */            
                if( !empty($ut_subfooter_bgcolor) ) {
                    
                   /* add to CSS */ 
                   $css .= '.footer .footer-content {
                        background: '.$ut_subfooter_bgcolor.' ;
                   }';
                    
                }
                         
            /* subfooter paddingtop  */
            $ut_subfooter_padding_top = ot_get_option('ut_subfooter_padding_top');
            
                /* add to CSS */            
                if( !empty($ut_subfooter_padding_top) ) {
                    
                   /* add to CSS */ 
                   $css .= '.footer .footer-content {
                        padding-top: '.$ut_subfooter_padding_top.';
                   }';
                    
                }          
                                        
            /* individual section styles , only run this query for front page */            
            if( is_front_page() ) {
                
                /* retrieve query arguements */
                $pagequery = ut_prepare_front_query();                            
                
                if( !empty( $pagequery ) ) {
            
                    $css_query = new WP_Query( $pagequery );
                    
                    if ( $css_query->have_posts() ) :
                    
                        while ( $css_query->have_posts() ) : $css_query->the_post();
                            
                            global $detect;
                            
                            $ut_section_video_state = get_post_meta( $css_query->post->ID , 'ut_section_video_state' , true );
                            
                                /* 
                                 * split section
                                 */
                                $ut_section_width = get_post_meta( $css_query->post->ID , 'ut_section_width' , true);
                                if( $ut_section_width == 'split' ) {
                                    
                                    /* try to get featured image */
                                    $fullsize = wp_get_attachment_url( get_post_thumbnail_id( $css_query->post->ID ) );
                                    
                                    if( !empty( $fullsize ) ) {
                                        $css .= '#' . ut_clean_section_id($css_query->post->post_name) . ' .ut-split-screen-poster{ background: url("' . $fullsize . '") }';
                                    }
                                    
                                    /* padding settings */
                                    $ut_split_section_margin_top = get_post_meta( $css_query->post->ID , 'ut_split_section_margin_top' , true);
                                    $ut_split_section_margin_bottom = get_post_meta( $css_query->post->ID , 'ut_split_section_margin_bottom' , true);
                                    
                                    /* fallback if there is no entry */
                                    $ut_split_section_margin_top = empty($ut_split_section_margin_top) ? '' : $ut_split_section_margin_top;
                                    $ut_split_section_margin_bottom = empty($ut_split_section_margin_bottom) ? '' : $ut_split_section_margin_bottom;
                                    
                                    $ut_split_content_align = get_post_meta( $css_query->post->ID , 'ut_split_content_align' , true);
                                    
                                    if( !empty( $ut_split_content_align ) && $ut_split_content_align == 'right' ) {
                                        $css .= '#' . ut_clean_section_id($css_query->post->post_name) . ' .ut-split-content-right { margin-top:' . $ut_split_section_margin_top . '; }'. "\n";
                                        $css .= '#' . ut_clean_section_id($css_query->post->post_name) . ' .ut-split-content-right { margin-bottom:' . $ut_split_section_margin_bottom . '; }'. "\n";
                                    }
                                    
                                    if( !empty( $ut_split_content_align ) && $ut_split_content_align == 'left' ) {                                    
                                        $css .= '#' . ut_clean_section_id($css_query->post->post_name) . ' .ut-split-content-left  { margin-top:' . $ut_split_section_margin_top . ';  }'. "\n";
                                        $css .= '#' . ut_clean_section_id($css_query->post->post_name) . ' .ut-split-content-left  { margin-bottom:' . $ut_split_section_margin_bottom . ';  }'. "\n";
                                    }
                                  
                                }                          
                            
                                /* 
                                 * section padding
                                 */
                                
                                /* get overlay settings */
                                $ut_overlay_section = get_post_meta( $css_query->post->ID , 'ut_overlay_section' , true);                                
                                
                                /* padding settings */
                                $ut_section_padding_top = get_post_meta( $css_query->post->ID , 'ut_section_padding_top' , true);
                                $ut_section_padding_bottom = get_post_meta( $css_query->post->ID , 'ut_section_padding_bottom' , true);
                                $ut_section_slogan_padding = get_post_meta( $css_query->post->ID , 'ut_section_slogan_padding' , true );
                        
                                /* fallback if there is no entry */
                                $ut_section_padding_top = empty($ut_section_padding_top) ? '80px' : $ut_section_padding_top;
                                $ut_section_padding_bottom = empty($ut_section_padding_bottom) ? '60px' : $ut_section_padding_bottom;
                                $ut_section_slogan_padding = empty($ut_section_slogan_padding) ? '30px' : $ut_section_slogan_padding;    
                                
                                    /* add to CSS */
                                    if( $ut_overlay_section == 'on' ) {                                        
                                        $css .= '#' . ut_clean_section_id($css_query->post->post_name) . ' .parallax-overlay { padding-top:' . $ut_section_padding_top . '; padding-bottom:' . $ut_section_padding_bottom . '; }'. "\n";
                                        $css .= '#' . ut_clean_section_id($css_query->post->post_name) . ' .ut-offset-anchor { top:-' . ( 79 + str_replace("px" , "" , $ut_navigation_padding_top) + str_replace("px" , "" , $ut_navigation_padding_bottom) ) . 'px; }'. "\n"; 
                                    } else {                                        
                                        $css .= '#' . ut_clean_section_id($css_query->post->post_name) . '{ padding-top:' . $ut_section_padding_top . '; padding-bottom:' . $ut_section_padding_bottom . '; }'. "\n";
                                        $css .= '#' . ut_clean_section_id($css_query->post->post_name) . ' .ut-offset-anchor { top:-' . ( 79 + str_replace("px" , "" , $ut_section_padding_top) + str_replace("px" , "" , $ut_navigation_padding_top) + str_replace("px" , "" , $ut_navigation_padding_bottom) ) . 'px; }'. "\n"; 
                                    }
                                    
                                    $css .= '#' . ut_clean_section_id($css_query->post->post_name) . ' .parallax-header { padding-bottom:' . $ut_section_slogan_padding . '; }'. "\n";
                                    $css .= '#' . ut_clean_section_id($css_query->post->post_name) . ' .section-header { padding-bottom:' . $ut_section_slogan_padding . '; }'. "\n";                                    
                            
                                /* 
                                 * section header font
                                 */
                                
                                /* get font style */
                                $ut_section_header_font_style = get_post_meta( $css_query->post->ID , 'ut_section_header_font_style' , true );
                                
                                /* fallback if there is no entry */
                                $ut_section_header_font_style = empty($ut_section_header_font_style) ? 'semibold' : $ut_section_header_font_style;
                                
                                    /* add to CSS */
                                    $css .= ut_create_global_headline_font_style('#' . ut_clean_section_id($css_query->post->post_name) . ' .parallax-title' , $ut_section_header_font_style);
                                    $css .= ut_create_global_headline_font_style('#' . ut_clean_section_id($css_query->post->post_name) . ' .section-title' , $ut_section_header_font_style);                                
                                    
                                if($ut_section_video_state != 'on') {
                                
                                /* 
                                 * section parallax image
                                 */ 
                                    
                                /* get parallax settings*/
                                $ut_parallax_image = get_post_meta( $css_query->post->ID , 'ut_parallax_image' , true );
                                $ut_parallax_section = get_post_meta( $css_query->post->ID , 'ut_parallax_section' , true);
                                
                                /* image fallback to version 1.0 */
                                if( is_array($ut_parallax_image) && !empty($ut_parallax_image['background-image'] ) ) {
                                    
                                    if( !empty( $ut_parallax_image ) && $ut_parallax_section == 'on' ) {
                                        
                                        $css .= ut_create_css_background( '#' . ut_clean_section_id($css_query->post->post_name) . '.parallax-section' , $ut_parallax_image );
                                        
                                    } else {
                                        
                                        $css .= ut_create_css_background( '#' . ut_clean_section_id($css_query->post->post_name) , $ut_parallax_image );
                                        
                                    }
                                                                
                                } elseif( !is_array($ut_parallax_image) ) {
                                
                                    if( !empty( $ut_parallax_image ) && $ut_parallax_section == 'on' ) { 
                                        
                                        $css .= '#' . ut_clean_section_id($css_query->post->post_name) . '.parallax-section { background-image: url(' . esc_url( $ut_parallax_image ) . '); }'. "\n";
                                    
                                    } else {  
                                        
                                        $css .= '#' . ut_clean_section_id($css_query->post->post_name) . ' { background-image: url(' . esc_url( $ut_parallax_image ) . '); }'. "\n";
                                    
                                    }; 
                                
                                }                               
                                                                
                                /* 
                                 * section background color 
                                 */                            
                                $ut_section_background_color = get_post_meta( $css_query->post->ID , 'ut_section_background_color' , true);
                                
                                if(!empty($ut_section_background_color)) {
                                    /* add to CSS */
                                    $css.= '#' . ut_clean_section_id($css_query->post->post_name) . '{ background-color: ' . $ut_section_background_color . '; }'. "\n";
                                    $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .section-header.pt-style-1 .section-title span  { background-color: ' . $ut_section_background_color . '; }'. "\n";                            
                                }
                            }
                            
                            /* video poster for section */
                            if( $detect->isMobile() && $ut_section_video_state != 'off' || $detect->isMobile() && ot_get_option('ut_front_video_containment' ,'hero') == 'body' ) :
                                    
                                $ut_video_poster = get_post_meta( $css_query->post->ID , 'ut_section_video_poster' , true);
                                
                                if( !empty($ut_video_poster) ) {
                                    
                                    /* video poster image for mobile devices */    
                                    $css .= '#' . ut_clean_section_id($css_query->post->post_name) . ' { 
                                        background-image: url(' . esc_url( $ut_video_poster ) . '); 
                                        background-size: cover !important;
                                        background-attachment: scroll !important;
                                    }'. "\n";
                                    
                                } else {
                                    
                                    $ut_section_video_bgcolor = get_post_meta( $css_query->post->ID , 'ut_section_video_bgcolor' , true); 
                                    
                                    if( !empty($ut_section_video_bgcolor) ) {
                                        /* add to CSS */
                                        $css.= '#' . ut_clean_section_id($css_query->post->post_name) . '{ background-color: ' . $ut_section_video_bgcolor . '; }'. "\n";
                                        $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .section-header.pt-style-1 .section-title span  { background-color: ' . $ut_section_video_bgcolor . '; }'. "\n"; 
                                    }
                                }                                               
                                
                            endif; 
                            
                            /* 
                             * section title , text , heading and lead color 
                             */
                            
                            $ut_section_text_color = get_post_meta( $css_query->post->ID , 'ut_section_text_color' , true);
                            if(!empty($ut_section_text_color)) {
                                
                                /* add to CSS */
                                $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .section-content { color: ' . $ut_section_text_color . '; }'. "\n"; 
                                
                            }
                            
                            $ut_section_heading_color = get_post_meta( $css_query->post->ID , 'ut_section_heading_color' , true);
                            if( !empty($ut_section_heading_color) ) {
                                
                                /* add to CSS */
                                $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .section-content h1 { color: ' . $ut_section_heading_color . ' !important; }'. "\n";
                                $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .section-content h2 { color: ' . $ut_section_heading_color . ' !important; }'. "\n"; 
                                $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .section-content h3 { color: ' . $ut_section_heading_color . ' !important; }'. "\n"; 
                                $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .section-content h4 { color: ' . $ut_section_heading_color . ' !important; }'. "\n"; 
                                $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .section-content h5 { color: ' . $ut_section_heading_color . ' !important; }'. "\n"; 
                                $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .section-content h6 { color: ' . $ut_section_heading_color . ' !important; }'. "\n";  
                            }  

                            $ut_section_header_style = get_post_meta( $css_query->post->ID , 'ut_section_header_style', true );
                            $ut_section_header_style = ( !empty($ut_section_header_style) && $ut_section_header_style != 'global' ) ? $ut_section_header_style : ot_get_option('ut_global_headline_style');                             
                            
                            $ut_section_title_color = get_post_meta( $css_query->post->ID , 'ut_section_title_color' , true);                            
                            
                            /* pt style 3 needs a fallback */
                            if( empty($ut_section_title_color) && $ut_section_header_style == 'pt-style-3') {
                                $ut_section_title_color = $accentcolor;
                            }
                            
                            if( !empty($ut_section_title_color) ) {
                                
                                /* add to CSS */
                                $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .parallax-title { color: ' . $ut_section_title_color . '; }'. "\n";
                                $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .section-title { color: ' . $ut_section_title_color . '; }'. "\n";
                                
                                $css.= create_section_headline_style( '#' . ut_clean_section_id($css_query->post->post_name) , $ut_section_header_style , $ut_section_title_color );
             
                            }
                            
                            /* 
                             * section title shadow
                             */
                            
                            if( get_post_meta( $css_query->post->ID , 'ut_section_title_glow' , true) == 'on' ) {
                                
                                $ut_section_title_color      = get_post_meta( $css_query->post->ID , 'ut_section_title_color' , true);
                                $ut_section_title_glow_color = get_post_meta( $css_query->post->ID , 'ut_section_title_glow_color' , true);
                                
                                if( !empty($ut_section_title_color) ) {                                
                                     
                                    /* add to CSS */ 
                                    $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .parallax-title.ut-glow { 
                                        text-shadow: 0 0 40px ' . $ut_section_title_color . ', 2px 2px 3px black ; 
                                    }'. "\n";
                                    
                                    $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .section-title.ut-glow { 
                                        text-shadow: 0 0 40px ' . $ut_section_title_color . ', 2px 2px 3px black; 
                                    }'. "\n";
                                
                                }
                                
                                if( !empty($ut_section_title_glow_color) ) {                                
                                    
                                    /* add to CSS */
                                    $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .parallax-title.ut-glow { 
                                        text-shadow: 0 0 40px ' . $ut_section_title_glow_color . ', 2px 2px 3px black ; 
                                    }'. "\n";
                                    
                                    $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .section-title.ut-glow { 
                                        text-shadow: 0 0 40px ' . $ut_section_title_glow_color . ', 2px 2px 3px black; 
                                    }'. "\n";
                                
                                }
                                                            
                            }
                            
                            
                            /* 
                             * section header spacing
                             */
                            $ut_section_header_margin_left  = get_post_meta( $css_query->post->ID , 'ut_section_header_margin_left' , true);
                            $ut_section_header_margin_right = get_post_meta( $css_query->post->ID , 'ut_section_header_margin_right' , true);
                                
                                /* add to CSS */
                                if( !empty($ut_section_header_margin_left) ) {
                                    $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' header.section-header { margin-left:'.$ut_section_header_margin_left.'; }'. "\n";
                                    $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' header.parallax-header { margin-left:'.$ut_section_header_margin_left.'; }'. "\n";
                                }
                                
                                /* add to CSS */ 
                                if( !empty($ut_section_header_margin_right) ) {
                                    $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' header.section-header { margin-right:'.$ut_section_header_margin_right.'; }'. "\n";
                                    $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' header.parallax-header { margin-right:'.$ut_section_header_margin_right.'; }'. "\n";
                                }
                            
                            /* 
                             * section p lead padding
                             */
                            $ut_section_slogan_padding_left  = get_post_meta( $css_query->post->ID , 'ut_section_slogan_padding_left' , true);
                            $ut_section_slogan_padding_right = get_post_meta( $css_query->post->ID , 'ut_section_slogan_padding_right' , true);
                                
                                /* add to CSS */
                                if( !empty($ut_section_slogan_padding_left) ) {                                    
                                    $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .lead { padding-left: ' . $ut_section_slogan_padding_left . '; }'. "\n";                                    
                                }
                                
                                /* add to CSS */
                                if( !empty($ut_section_slogan_padding_right) ) {                                    
                                    $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .lead { padding-right: ' . $ut_section_slogan_padding_right . '; }'. "\n";                                    
                                }
                            
                            /* 
                             * section lead color
                             */
                            $ut_section_slogan_color = get_post_meta( $css_query->post->ID , 'ut_section_slogan_color' , true);
                            
                                /* add to CSS */
                                if( !empty($ut_section_slogan_color) ) {
                                    $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .lead, #' . ut_clean_section_id($css_query->post->post_name) . ' .lead p { color: ' . $ut_section_slogan_color . '; }'. "\n"; 
                                }
                            
                            
                            /* 
                             * overlay color
                             */
                             
                            if( $ut_overlay_section == 'on') {
                                
                                $ut_overlay_color = get_post_meta( $css_query->post->ID , 'ut_overlay_color' , true);
                                $ut_overlay_color_opacity = get_post_meta( $css_query->post->ID , 'ut_overlay_color_opacity' , true);
                                $ut_overlay_color_opacity = !empty($ut_overlay_color_opacity) ? $ut_overlay_color_opacity : '0.8';

                                
                                /* add to CSS */
                                $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .parallax-overlay { background-color: rgb(' . ut_hex_to_rgb($ut_overlay_color) . '); }'. "\n";
                                $css.= '#' . ut_clean_section_id($css_query->post->post_name) . ' .parallax-overlay { background-color: rgba(' . ut_hex_to_rgb($ut_overlay_color) . ' , ' . $ut_overlay_color_opacity . ' ); }'. "\n";
                                
                            } 
                            
                            /* 
                             * section border bottom 
                             */
                            if( get_post_meta( $css_query->post->ID , 'ut_section_border_bottom' , true) == 'on' ) {
                                
                                /* border settings */
                                $ut_section_border_bottom_color = get_post_meta( $css_query->post->ID , 'ut_section_border_bottom_color' , true);                                
                                $ut_section_border_bottom_color = !empty($ut_section_border_bottom_color) ? $ut_section_border_bottom_color : $accentcolor;                                
                                $ut_section_border_bottom_width = get_post_meta( $css_query->post->ID , 'ut_section_border_bottom_width' , true); 
                                $ut_section_border_bottom_width = !empty( $ut_section_border_bottom_width) ?  $ut_section_border_bottom_width : '1'; 
                                $ut_section_border_bottom_style = get_post_meta( $css_query->post->ID , 'ut_section_border_bottom_style' , true); 
                                $ut_section_border_bottom_style = !empty( $ut_section_border_bottom_style) ?  $ut_section_border_bottom_style : 'solid';                               
                               
                                /* add to CSS */
                                $css.= '#' . ut_clean_section_id($css_query->post->post_name) . '{ border-bottom: '.$ut_section_border_bottom_width.'px '.$ut_section_border_bottom_style.' '.$ut_section_border_bottom_color.'; }';
                            
                            }
                            
                                                        
                        endwhile;
                    
                    endif;
                    
                    wp_reset_postdata();
                    
                }
            
            } /* end front page styling */
            
            $css .= '.parallax-overlay-pattern.style_one { background-image: url(" '. THEME_WEB_ROOT .'/images/overlay-pattern.png") !important; }'. "\n";
            $css .= '.parallax-overlay-pattern.style_two { background-image: url(" '. THEME_WEB_ROOT .'/images/overlay-pattern2.png") !important; }'. "\n";
            
            /* custom css from theme option panel */
            $css .= ot_get_option('ut_custom_css');
            
            
        /* end css */    
        $css .= '</style>';
        
        /* check for css cache */
        if( ot_get_option('ut_use_cache' , 'off') == 'on' && is_front_page() ) {
            
            $transient_prefix = $detect->isMobile() ? '_mobile' : '_desktop';            
            $cacheTime = ot_get_option('ut_cache_ltime' , '10');            
            set_transient('ut_css_cache'. $transient_prefix, $css, 60 * $cacheTime);
        
        }
                
        echo apply_filters( 'ut-custom-css', $css );        
        
    }
    
    add_action('wp_head' , 'unitedthemes_custom_css');
    
} 

?>