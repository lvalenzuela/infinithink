<?php
add_theme_support( 'post-thumbnails' );

global $et_theme_image_sizes;

$et_theme_image_sizes = array(
	'220x9999' 	=> 'et-home-product-thumb',
	'75x75' 	=> 'et-testimonials-thumb',
	'960x295' 	=> 'et-slider-post-thumb',
	'720x320' 	=> 'et-entry-post-thumb',
	'1280x420' 	=> 'et-single-thumb',
	'187x9999' 	=> 'et-index-product-thumb',
	'453x9999' 	=> 'et-single-product-thumb',
);

$et_page_templates_image_sizes = array(
	'184x184' 	=> 'et-blog-page-thumb',
	'207x136' 	=> 'et-gallery-page-thumb',
	'260x170' 	=> 'et-portfolio-medium-page-thumb',
	'260x315' 	=> 'et-portfolio-medium-portrait-page-thumb',
	'140x94' 	=> 'et-portfolio-small-page-thumb',
	'140x170' 	=> 'et-portfolio-small-portrait-page-thumb',
	'430x283' 	=> 'et-portfolio-large-page-thumb',
	'430x860' 	=> 'et-portfolio-large-portrait-page-thumb',
);

$et_theme_image_sizes = array_merge( $et_theme_image_sizes, $et_page_templates_image_sizes );

$et_theme_image_sizes = apply_filters( 'et_theme_image_sizes', $et_theme_image_sizes );
$crop = apply_filters( 'et_post_thumbnails_crop', true );

if ( is_array( $et_theme_image_sizes ) ){
	foreach ( $et_theme_image_sizes as $image_size_dimensions => $image_size_name ){
		$dimensions = explode( 'x', $image_size_dimensions );

		if ( in_array( $image_size_name, array( 'et-home-product-thumb', 'et-index-product-thumb', 'et-single-product-thumb' ) ) )
			$crop = false;

		add_image_size( $image_size_name, $dimensions[0], $dimensions[1], $crop );

		$crop = apply_filters( 'et_post_thumbnails_crop', true );
	}
}