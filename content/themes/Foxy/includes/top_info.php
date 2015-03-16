<?php if ( ! is_front_page() && is_home() ) return; ?>
<div id="category-name">
<?php
	$et_tagline = '';
	if( is_tag() ) {
		$et_page_title = esc_html__('Posts Tagged &quot;','Foxy') . single_tag_title('',false) . '&quot;';
	} elseif (is_day()) {
		$et_page_title = esc_html__('Posts made in','Foxy') . ' ' . get_the_time('F jS, Y');
	} elseif (is_month()) {
		$et_page_title = esc_html__('Posts made in','Foxy') . ' ' . get_the_time('F, Y');
	} elseif (is_year()) {
		$et_page_title = esc_html__('Posts made in','Foxy') . ' ' . get_the_time('Y');
	} elseif (is_search()) {
		$et_page_title = esc_html__('Search results for','Foxy') . ' ' . get_search_query();
	} elseif (is_category()) {
		$et_page_title = single_cat_title('',false);
		$et_tagline = category_description();
	} elseif (is_author()) {
		global $wp_query;
		$curauth = $wp_query->get_queried_object();
		$et_page_title = esc_html__('Posts by ','Foxy') . $curauth->nickname;
	} elseif ( is_page() || is_single() ) {
		$et_page_title = get_the_title();
		if ( is_page() ) $et_tagline = get_post_meta(get_the_ID(),'Description',true) ? get_post_meta(get_the_ID(),'Description',true) : '';
	} elseif ( is_tax() ){
		$et_page_title = single_term_title( '', false );
		$et_tagline = term_description();
	} elseif ( is_post_type_archive() ) {
		$et_page_title = post_type_archive_title( '', false );
	}
?>
	<h1 class="category-title"><?php echo esc_html( $et_page_title ); ?></h1>
<?php if ( $et_tagline <> '' ) { ?>
	<p class="description"><?php echo esc_html( $et_tagline ); ?></p>
<?php } ?>

<?php
if ( is_single() && 'product' == get_post_type() && class_exists( 'woocommerce' ) && is_woocommerce() ) :
	while ( have_posts() ) : the_post();
		global $product, $woocommerce_loop;

		$et_price_before = 'variable' == $product->product_type ? $product->min_variation_regular_price : $product->regular_price;
		$product_ids_on_sale = et_woocommerce_get_product_on_sale_ids();
?>
<?php if ( ! in_array( get_the_ID(), array_map( 'intval', $product_ids_on_sale ) ) ) { ?>
	<?php if ( '' != $product->get_price_html() ) : ?>
	<div class="et-price-button">
		<span class="et-price-sale"><?php echo $product->get_price_html(); ?></span>
	</div>
	<?php endif; ?>
<?php } else { ?>
	<div class="et-price-button et-product-on-sale">
		<span class="et-price-before"><del><?php echo woocommerce_price( $et_price_before ); ?></del></span>
		<span class="et-price-sale"><?php echo woocommerce_price( $product->get_price() ); ?></span>
	</div>
<?php }
	endwhile;
	rewind_posts();
endif; ?>
</div> <!--#category-name -->