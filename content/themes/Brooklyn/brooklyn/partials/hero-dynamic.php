<?php
/**
 * The Template for displaying dynamic content inside the Hero
 *
 * @author 		United Themes
 * @package 	Brooklyn
 * @version     1.0
 */

/* template config */
$ut_hero_dynamic_content = ut_return_hero_config('ut_hero_dynamic_content'); 

?>

<!-- hero section -->
<section class="ha-waypoint" data-animate-up="ha-header-hide" data-animate-down="ha-header-hide">

     <?php echo apply_filters( 'the_content' , $ut_hero_dynamic_content ); ?>

</section>
<!-- end hero section -->