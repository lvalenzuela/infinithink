<?php

/**
 * Default Sidebar for Pages
 * by www.unitedthemes.com
 */

?>

<?php if( is_active_sidebar('page-widget-area') ) : ?>
    
    <div id="secondary" class="widget-area grid-25 mobile-grid-100 tablet-grid-25" role="complementary">
        <ul class="sidebar">
            <?php dynamic_sidebar('page-widget-area'); ?>
        </ul>
    </div>
    
<?php endif; ?>