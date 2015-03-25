<?php


if ( ! function_exists( 'ut_recognized_sections' ) ) :

    function ut_recognized_sections() {
        
        return array(
            
            'demo_1'  => array(
                'title'     => 'Demo 1',
                'url'       => 'http://themeforest.unitedthemes.com/wpversions/brooklyn/basic/',
                'sections'  => array(
                    1 => array(
                        'title' => 'ABOUT BROOKLYN',
                        'url'   => '#section-about-brooklyn',
                    ),
                    2 => array(
                        'title' => 'PASSION LEADS TO DESIGN',
                        'url'   => '#section-our-philosophy-is',
                    ),
                    3 => array(
                        'title' => 'OUR TEAM',
                        'url'   => '#section-our-team',
                    ),
                    4 => array(
                        'title' => 'SOME FUN FACTS',
                        'url'   => '#section-some-fun-facts',
                    ),
                    5 => array(
                        'title' => 'DROP US A LINE',
                        'url'   => '#section-drop-us-a-line',
                    ),
                    6 => array(
                        'title' => 'OUR SERVICE',
                        'url'   => '#section-our-service',
                    ),
                    7 => array(
                        'title' => 'OUR WORK',
                        'url'   => '#section-work',
                    ),
                    8 => array(
                        'title' => 'GET CONNECTED',
                        'url'   => '#section-get-connected',
                    ),
                    9 => array(
                        'title' => 'HAPPY CLIENTS',
                        'url'   => '#section-happy-clients-2',
                    ),
                    10 => array(
                        'title' => 'CLIENTS',
                        'url'   => '#section-clients',
                    ),
                ),
            ),
            'demo_2'  => array(
                'title'     => 'Demo 2',
                'url'       => 'http://themeforest.unitedthemes.com/wpversions/brooklyn/extended/'
            ),
            'demo_3'  => array(
                'title'     => 'Demo 3',
                'url'       => 'http://themeforest.unitedthemes.com/wpversions/brooklyn/elegant/'
            ),
            'demo_4'  => array(
                'title'     => 'Demo 4',
                'url'       => 'http://themeforest.unitedthemes.com/wpversions/brooklyn/business/'
            ),
            'demo_5'  => array(
                'title'     => 'Demo 5',
                'url'       => 'http://themeforest.unitedthemes.com/wpversions/brooklyn/demo5/'
            ),
            'demo_6'  => array(
                'title'     => 'Demo 6',
                'url'       => 'http://themeforest.unitedthemes.com/wpversions/brooklyn/demo6/'
            ),
            'demo_7'  => array(
                'title'     => 'Demo 7',
                'url'       => 'http://themeforest.unitedthemes.com/wpversions/brooklyn/demo7/'
            ),
            'demo_8'  => array(
                'title'     => 'Demo 8',
                'url'       => 'http://themeforest.unitedthemes.com/wpversions/brooklyn/landing/'
            ),
            'demo_9'  => array(
                'title'     => 'Demo 9',
                'url'       => 'http://themeforest.unitedthemes.com/wpversions/brooklyn/demo9/'
            ),
            'demo_10' => array(
                'title'     => 'Demo 10',
                'url'       => 'http://themeforest.unitedthemes.com/wpversions/brooklyn/demo10/'
            ),
            'demo_11' => array(
                'title'     => 'Demo 11',
                'url'       => 'http://themeforest.unitedthemes.com/wpversions/brooklyn/demo11/'
            ),
            'demo_12' => array(
                'title'     => 'Demo 12',
                'url'       => 'http://themeforest.unitedthemes.com/wpversions/brooklyn/demo12/'
            ),
            'demo_13' => array(
                'title'     => 'Demo 13',
                'url'       => 'http://themeforest.unitedthemes.com/wpversions/brooklyn/demo13/'
            ),
            
        );
    
    }
    
endif;


/*
|--------------------------------------------------------------------------
| Section Loader
|--------------------------------------------------------------------------
*/
if ( ! function_exists( 'ut_section_loader' ) ) :

    function ut_section_loader() {
        
        echo '<div id="ut-section-loader-popup" style="display:none;">';
            
            echo '<h2>Load Section Preset</h2>';
            
            echo '<div>';
                
                foreach( ut_recognized_sections() as $section ) {
                    
                    echo '<h3>' . $section['title'] . '</h3>';    
                    echo '<p>';
                        
                        echo '<a target="_blank" href="', $section['url'] ,'">' , esc_html__( 'Preview this Demo' , 'unitedthemes' ) , '</a>';
                    
                    echo '</p>';
                
                }
            
            echo '</div>';
            
        echo '</div>';
    
    }
    
    add_action('admin_footer', 'ut_section_loader');
     
endif;

if ( ! function_exists( 'ut_section_loader_button' ) ) :

    function ut_section_loader_button($context) {
                
        echo '<a style="padding: 4px 12px; font-size: 13px; margin-top: 1px;" class="thickbox option-tree-ui-button blue light" title="' . esc_html__( 'Section Loader' , 'unitedthemes' ) . '" href="#TB_inline?width=500&inlineId=ut-section-loader-popup"> ' . esc_html__( 'Load Section Preset' , 'unitedthemes' ) . '</a>';
    
    }
    
    add_action('media_buttons', 'ut_section_loader_button', 15);
    
endif;


/*
|--------------------------------------------------------------------------
| Load Demo Content on request
|--------------------------------------------------------------------------
*/
if ( !function_exists( 'ut_load_demo_section' ) ) {
	
	function ut_load_demo_section( $data , $postarr ) {
        
        echo '<pre>';
        print_r( $data );
        echo '</pre>';
    
    }
    
    //add_filter( 'wp_insert_post_data' , 'ut_load_demo_section' , '99', 2 );
        
}


?>