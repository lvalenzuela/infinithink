<?php

$ut_page_skin = get_post_meta( $post->ID , 'ut_section_skin' , true);
$ut_page_class = get_post_meta( $post->ID , 'ut_section_class' , true);

?>

<?php get_header(); ?>
    
    <div class="grid-container">
    
        <?php $grid = ( is_active_sidebar('shop-widget-area') && ( is_shop() || is_product_category() || is_product_tag() ) ) ? 'grid-75 tablet-grid-75 mobile-grid-100' : 'grid-100 tablet-grid-100 mobile-grid-100'; ?>
        
        <div id="primary" class="grid-parent <?php echo $grid; ?> <?php echo $ut_page_skin; ?> <?php echo $ut_page_class; ?>">
            
            <?php woocommerce_content(); ?>
            
        </div>
        
        <?php if( is_shop() || is_product_category() || is_product_tag() ) : ?>
        
            <?php get_sidebar('shop'); ?>
        
        <?php endif; ?>
        
    </div><!-- close grid-container -->

<?php get_footer(); ?>