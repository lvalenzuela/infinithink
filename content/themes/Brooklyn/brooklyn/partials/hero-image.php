<?php
/**
 * The Template for displaying Single Background Image
 *
 * @author 		United Themes
 * @package 	Brooklyn
 * @version     1.0
 */

/* template config: content */
$ut_custom_slogan           = ut_return_hero_config('ut_custom_slogan');
$ut_expertise_slogan 	    = ut_return_hero_config('ut_expertise_slogan');
$ut_company_slogan 	    	= ut_return_hero_config('ut_company_slogan');
$ut_catchphrase 		    = ut_return_hero_config('ut_catchphrase');

/* template config: effects */
$ut_company_slogan_glow = ut_return_hero_config('ut_company_slogan_glow' , 'off') == 'on' ? 'ut-glow' : '';

/* template config: canvas color */
$ut_accentcolor             = get_option('ut_accentcolor' , '#F1C40F');
$ut_effect_color            = ut_return_hero_config('ut_hero_overlay_effect_color');
$ut_effect_color            = !empty($ut_effect_color) ? $ut_effect_color : $ut_accentcolor;

/* template config: image */
$ut_hero_image              = ut_return_hero_config('ut_hero_image');
$ut_hero_image              = is_array($ut_hero_image) && !empty( $ut_hero_image['background-image'] ) ? $ut_hero_image['background-image'] : $ut_hero_image;

/* template config: pattern */
$ut_hero_overlay_pattern    = ut_return_hero_config('ut_hero_overlay_pattern' , 'on') == 'on' ? 'parallax-overlay-pattern' : '';

/* template config: main button */
$ut_main_hero_button = ut_return_hero_config('ut_main_hero_button');
if( !empty( $ut_main_hero_button ) ) {
    $ut_main_hero_button_url_type    = ut_return_hero_config('ut_main_hero_button_url_type', 'section');    
    $ut_main_hero_button_target	     = ut_return_hero_config('ut_main_hero_button_target' , '#ut-to-first-section');
    $ut_main_hero_button_link_target = ut_return_hero_config('ut_main_hero_button_link_target');
    $ut_main_hero_button_style       = ut_return_hero_config('ut_main_hero_button_style' , 'default');
    $ut_main_hero_button_settings    = ut_return_hero_config('ut_main_hero_button_settings');
}

/* template config: second button */ 
$ut_second_hero_button = ut_return_hero_config('ut_second_hero_button' , 'off');
if( $ut_second_hero_button == 'on' ) {    
    $ut_second_hero_button_text     = ut_return_hero_config('ut_second_hero_button_text');
    $ut_second_hero_button_url_type = ut_return_hero_config('ut_second_hero_button_url_type', 'section');
    $ut_second_hero_button_target   = ut_return_hero_config('ut_second_hero_button_target');
    $ut_second_hero_button_url      = ut_return_hero_config('ut_second_hero_button_url');
    $ut_second_hero_button_style    = ut_return_hero_config('ut_second_hero_button_style' , 'default'); 
    $ut_second_hero_button_settings = ut_return_hero_config('ut_second_hero_button_settings');	
}
?>

<!-- hero section -->
<section id="ut-hero" class="hero ha-waypoint parallax-section parallax-background" data-animate-up="ha-header-hide" data-animate-down="ha-header-hide">
    
    <?php /* overlay animation effect for hero */ 
    if( ut_return_hero_config('ut_hero_overlay_effect') == 'on') : ?>
    
        <canvas data-strokecolor="<?php echo ut_hex_to_rgb($ut_effect_color); ?>" id="ut-animation-canvas"></canvas>        
    
    <?php endif; ?>
    
    
    <?php /* overlay effect for hero */ 
    if( ut_return_hero_config('ut_hero_overlay') == 'on') : ?>
        
        <div class="parallax-overlay <?php echo $ut_hero_overlay_pattern; ?> <?php echo ut_return_hero_config('ut_hero_overlay_pattern_style' , 'style_one'); ?>">
        
    <?php endif; ?>
    
    
    <?php /* rain effect for hero */ 
    if( ut_return_hero_config('ut_hero_rain_effect' , 'off') == 'on' ) : ?>
        
        <?php /* needed image */ ?>                    
        <img id="ut-rain-background" src="<?php echo $ut_hero_image; ?>" alt="rain" />
        
    <?php endif; ?>    
    
    <?php /* main output for hero */ ?>
    
    <div class="grid-container">
        <!-- hero holder -->
        <div class="hero-holder grid-100 mobile-grid-100 tablet-grid-100 <?php echo ut_return_hero_config('ut_hero_style' , 'ut-hero-style-1'); ?>">
            <div class="hero-inner" style="text-align:<?php echo ut_return_hero_config('ut_hero_align' , 'center'); ?>;">                
                
                <?php if( !empty($ut_custom_slogan) ) : ?>
                    <?php echo do_shortcode( ut_translate_meta($ut_custom_slogan) ); ?>
                <?php endif; ?>
                
                <?php if( !empty($ut_expertise_slogan) ) : ?>
                    <div class="hdh"><span class="hero-description"><?php echo do_shortcode( ut_translate_meta($ut_expertise_slogan) ); ?></span></div>
                <?php endif; ?>
                                
                <?php if( !empty($ut_company_slogan) ) : ?>
                    <div class="hth"><h1 class="hero-title <?php echo $ut_company_slogan_glow; ?>"><?php echo do_shortcode( ut_translate_meta($ut_company_slogan) ); ?></h1></div>
                <?php endif; ?>
                
                <?php if( !empty($ut_catchphrase) ) : ?>
                    <div class="hdb"><span class="hero-description-bottom"><?php echo do_shortcode( ut_translate_meta($ut_catchphrase) ); ?></span></div>
                <?php endif; ?>
                
                <?php if( !empty($ut_main_hero_button) ) : ?>
                    
                    <span class="hero-btn-holder">
                        
                        <a id="to-about-section" target="<?php echo $ut_main_hero_button_link_target; ?>" href="<?php echo $ut_main_hero_button_target; ?>" class="hero-btn <?php echo $ut_main_hero_button_style; ?>">
                        
                            <?php if( $ut_main_hero_button_style == 'custom' ) : ?>                                        
                                
                                <?php echo !empty($ut_main_hero_button_settings['icon']) ? '<i class="fa ' . $ut_main_hero_button_settings['icon'] . '"></i>' : ''; ?> 
                                
                            <?php endif; ?>
                            
                            <?php echo ut_translate_meta($ut_main_hero_button); ?>
                        
                        </a>
                        
                        <?php if( $ut_second_hero_button == 'on' ) : ?>
                    
                            <a href="<?php echo $ut_second_hero_button_url; ?>" class="hero-second-btn <?php echo $ut_second_hero_button_style; ?>" target="<?php echo $ut_second_hero_button_target; ?>">
                                
                                <?php if( $ut_second_hero_button_style == 'custom' ) : ?>                                        
                            
                                    <?php echo !empty($ut_second_hero_button_settings['icon']) ? '<i class="fa ' . $ut_second_hero_button_settings['icon'] . '"></i>' : ''; ?> 
                                    
                                <?php endif; ?>
                                
                                <?php echo ut_translate_meta($ut_second_hero_button_text); ?>                                        
                            
                            </a>
                    
                        <?php endif; ?> 
                    
                    </span>
                    
                <?php endif; ?>
                
            </div>
        </div><!-- close hero-holder -->
    </div>
    
    <?php /* rain sound effect for hero */ ?>
    
    <?php if( ut_return_hero_config('ut_hero_rain_effect' , 'off') == 'on' && ut_return_hero_config('ut_hero_rain_sound' , 'off')== 'on' ) : ?>
            
        <div id="ut-hero-audio" class="hero-audio-holder">
            <?php echo do_shortcode('[audio mp3="' . THEME_WEB_ROOT . '/sounds/heavyrain.mp3" wav="' . THEME_WEB_ROOT . '/sounds/heavyrain.wav" loop="on" autoplay=""]'); ?>
        </div>
        
        <a href="#ut-hero-audio" class="ut-audio-control ut-unmute">Unmute</a>
    
    <?php endif; ?>               
    
    <?php /* overlay effect for hero */ ?>
    
    <?php if( ut_return_hero_config('ut_hero_overlay') == 'on') : ?>
    
        </div> 
    
    <?php endif; ?>
    
    <div data-section="top" class="ut-scroll-up-waypoint"></div>
    
</section>
<!-- end hero section -->       