<?php

if ( ! isset( $content_width ) ) $content_width = 545;

add_action( 'after_setup_theme', 'et_setup_theme' );
if ( ! function_exists( 'et_setup_theme' ) ){
	function et_setup_theme(){
		global $themename, $shortname, $et_store_options_in_one_row, $default_colorscheme;
		$themename = 'Foxy';
		$shortname = 'foxy';
		$et_store_options_in_one_row = true;

		$default_colorscheme = "Default";

		$template_directory = get_template_directory();

		require_once( $template_directory . '/epanel/custom_functions.php' );

		require_once( $template_directory . '/includes/functions/comments.php' );

		require_once( $template_directory . '/includes/functions/sidebars.php' );

		load_theme_textdomain( 'Foxy', $template_directory . '/lang' );

		require_once( $template_directory . '/epanel/core_functions.php' );

		require_once( $template_directory . '/epanel/post_thumbnails_foxy.php' );

		include( $template_directory . '/includes/widgets.php' );

		register_nav_menus( array(
			'primary-menu' => __( 'Primary Menu', 'Foxy' ),
			'footer-menu' => __( 'Footer Menu', 'Foxy' ),
		) );

		add_theme_support( 'woocommerce' );

		add_action( 'init', 'et_foxy_register_posttypes', 0 );

		add_action( 'wp_enqueue_scripts', 'et_foxy_load_scripts_styles' );

		add_action( 'wp_head', 'et_add_viewport_meta' );

		add_action( 'pre_get_posts', 'et_home_posts_query' );

		add_action( 'et_epanel_changing_options', 'et_delete_featured_ids_cache' );
		add_action( 'delete_post', 'et_delete_featured_ids_cache' );
		add_action( 'save_post', 'et_delete_featured_ids_cache' );

		add_filter( 'wp_page_menu_args', 'et_add_home_link' );

		add_filter( 'et_get_additional_color_scheme', 'et_remove_additional_stylesheet' );

		add_action( 'wp_enqueue_scripts', 'et_add_responsive_shortcodes_css', 11 );

		// don't display the empty title bar if the widget title is not set
		remove_filter( 'widget_title', 'et_widget_force_title' );

		add_action( 'et_header_top', 'et_add_mobile_navigation' );

		add_filter( 'woocommerce_currency_symbol', 'et_format_currency_symbol' );

		add_action( 'admin_enqueue_scripts', 'et_foxy_admin_scripts_styles' );

		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

		add_action( 'body_class', 'et_add_woocommerce_class_to_homepage' );

		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		add_action( 'woocommerce_before_main_content', 'et_foxy_output_content_wrapper', 10 );

		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
		add_action( 'woocommerce_after_main_content', 'et_foxy_output_content_wrapper_end', 10 );

		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	}
}

function et_add_home_link( $args ) {
	// add Home link to the custom menu WP-Admin page
	$args['show_home'] = true;
	return $args;
}

function et_foxy_load_scripts_styles(){
	$template_dir = get_template_directory_uri();
	$protocol = is_ssl() ? 'https' : 'http';

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );

	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'Foxy' ) ) {
		$subsets = 'latin,latin-ext';

		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'Foxy' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$query_args = array(
			'family' => 'Open+Sans:300italic,700italic,800italic,400,300,700,800',
			'subset' => $subsets,
		);

		wp_enqueue_style( 'foxy-fonts-open-sans', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}

	if ( 'off' !== _x( 'on', 'Raleway font: on or off', 'Foxy' ) ) {
		$subsets = 'latin';

		$subset = _x( 'no-subset', 'Raleway font: add cyrillic subset', 'Foxy' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$query_args = array(
			'family' => 'Raleway:400,100',
			'subset' => $subsets,
		);

		wp_enqueue_style( 'foxy-fonts-raleway', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}

	wp_enqueue_script( 'superfish', $template_dir . '/js/superfish.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'custom_script', $template_dir . '/js/custom.js', array( 'jquery' ), '1.0', true );
	wp_localize_script( 'custom_script', 'et_custom', array(
		'mobile_nav_text' 	=> esc_html__( 'Navigation Menu', 'Foxy' ),
	) );

	$et_gf_enqueue_fonts = array();
	$et_gf_heading_font = sanitize_text_field( et_get_option( 'heading_font', 'none' ) );
	$et_gf_body_font = sanitize_text_field( et_get_option( 'body_font', 'none' ) );

	if ( 'none' != $et_gf_heading_font ) $et_gf_enqueue_fonts[] = $et_gf_heading_font;
	if ( 'none' != $et_gf_body_font ) $et_gf_enqueue_fonts[] = $et_gf_body_font;

	if ( ! empty( $et_gf_enqueue_fonts ) ) et_gf_enqueue_fonts( $et_gf_enqueue_fonts );

	/*
	 * Loads the main stylesheet.
	 */
	wp_enqueue_style( 'foxy-style', get_stylesheet_uri() );
}

function et_add_mobile_navigation(){
	echo '<div id="et_mobile_nav_menu">' . '<a href="#" class="mobile_nav closed">' . esc_html__( 'Navigation Menu', 'Foxy' ) . '</a>' . '</div>';
}

/**
 * Filters the main query on homepage
 */
function et_home_posts_query( $query = false ) {
	/* Don't proceed if it's not homepage or the main query */
	if ( ! is_home() || ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() ) return;

	if ( ! class_exists( 'woocommerce' ) || 'on' == et_get_option( 'foxy_blog_style', 'false' ) || ( ! is_front_page() && is_home() ) ) {
		/* Exclude categories set in ePanel */
		$exclude_categories = et_get_option( 'foxy_exlcats_recent', false, 'category' );

		if ( $exclude_categories ) $query->set( 'category__not_in', array_map( 'intval', $exclude_categories ) );
	} elseif ( 'false' == et_get_option( 'foxy_blog_style', 'false' ) ) {
		/* Display WooCommerce products on homepage */
		$query->set( 'post_type', 'product' );
		$query->set( 'meta_query', array(
				array( 'key' => '_visibility', 'value' => array( 'catalog', 'visible' ),'compare' => 'IN' )
			)
		);

		$exclude_categories = et_get_option( 'foxy_exlcats_recent_products', false );

		if ( $exclude_categories ) {
			$query->set( 'tax_query', array(
					array(
						'taxonomy' 	=> 'product_cat',
						'field' 	=> 'id',
						'operator'	=> 'NOT IN',
						'terms'		=> (array) array_map( 'intval', $exclude_categories )
					)
				)
			);
		}
	}

	/* Exclude slider posts, if the slider is activated, pages are not featured and posts duplication is disabled in ePanel  */
	if ( 'on' == et_get_option( 'foxy_featured', 'on' ) && 'false' == et_get_option( 'foxy_use_pages', 'false' ) && 'false' == et_get_option( 'foxy_duplicate', 'on' ) )
		$query->set( 'post__not_in', et_get_featured_posts_ids() );
}

/**
 * Gets featured posts IDs from transient, if the transient doesn't exist - runs the query and stores IDs
 */
function et_get_featured_posts_ids(){
	if ( false === ( $et_featured_post_ids = get_transient( 'et_featured_post_ids' ) ) ) {
		$featured_query = new WP_Query( apply_filters( 'et_featured_post_args', array(
			'posts_per_page'	=> (int) et_get_option( 'foxy_featured_num' ),
			'cat'				=> (int) get_catId( et_get_option( 'foxy_feat_posts_cat' ) )
		) ) );

		if ( $featured_query->have_posts() ) {
			while ( $featured_query->have_posts() ) {
				$featured_query->the_post();

				$et_featured_post_ids[] = get_the_ID();
			}

			set_transient( 'et_featured_post_ids', $et_featured_post_ids );
		}

		wp_reset_postdata();
	}

	return $et_featured_post_ids;
}

/**
 * Deletes featured posts IDs transient, when the user saves, resets ePanel settings, creates or moves posts to trash in WP-Admin
 */
function et_delete_featured_ids_cache(){
	if ( false !== get_transient( 'et_featured_post_ids' ) ) delete_transient( 'et_featured_post_ids' );
}

function et_add_viewport_meta(){
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />';
}

function et_remove_additional_stylesheet( $stylesheet ){
	global $default_colorscheme;
	return $default_colorscheme;
}

if ( ! function_exists( 'et_list_pings' ) ){
	function et_list_pings($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?> - <?php comment_excerpt(); ?>
	<?php }
}

// flush permalinks on theme activation
add_action( 'after_switch_theme', 'et_rewrite_flush' );
function et_rewrite_flush() {
	flush_rewrite_rules();
}

if ( ! function_exists( 'et_get_the_author_posts_link' ) ){
	function et_get_the_author_posts_link(){
		global $authordata, $themename;

		$link = sprintf(
			'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
			esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ),
			esc_attr( sprintf( __( 'Posts by %s', $themename ), get_the_author() ) ),
			get_the_author()
		);
		return apply_filters( 'the_author_posts_link', $link );
	}
}

if ( ! function_exists( 'et_get_comments_popup_link' ) ){
	function et_get_comments_popup_link( $zero = false, $one = false, $more = false ){
		global $themename;

		$id = get_the_ID();
		$number = get_comments_number( $id );

		if ( 0 == $number && !comments_open() && !pings_open() ) return;

		if ( $number > 1 )
			$output = str_replace('%', number_format_i18n($number), ( false === $more ) ? __('% Comments', $themename) : $more);
		elseif ( $number == 0 )
			$output = ( false === $zero ) ? __('No Comments',$themename) : $zero;
		else // must be one
			$output = ( false === $one ) ? __('1 Comment', $themename) : $one;

		return '<span class="comments-number">' . '<a href="' . esc_url( get_permalink() . '#respond' ) . '">' . apply_filters('comments_number', $output, $number) . '</a>' . '</span>';
	}
}

if ( ! function_exists( 'et_postinfo_meta' ) ){
	function et_postinfo_meta( $postinfo, $date_format, $comment_zero, $comment_one, $comment_more ){
		global $themename;

		$postinfo_meta = '';

		if ( in_array( 'author', $postinfo ) ){
			$postinfo_meta .= ' ' . esc_html__('By',$themename) . ' ' . et_get_the_author_posts_link();
		}

		if ( in_array( 'date', $postinfo ) )
			$postinfo_meta .= ' ' . esc_html__('on',$themename) . ' ' . get_the_time( $date_format );

		if ( in_array( 'categories', $postinfo ) )
			$postinfo_meta .= ' ' . esc_html__('in',$themename) . ' ' . get_the_category_list(', ');

		if ( in_array( 'comments', $postinfo ) )
			$postinfo_meta .= ' | ' . et_get_comments_popup_link( $comment_zero, $comment_one, $comment_more );

		echo $postinfo_meta;
	}
}

function et_foxy_register_posttypes() {
	$labels = array(
		'name' 					=> _x( 'Testimonials', 'post type general name', 'Foxy' ),
		'singular_name' 		=> _x( 'Testimonial', 'post type singular name', 'Foxy' ),
		'add_new' 				=> _x( 'Add New', 'testimonial item', 'Foxy' ),
		'add_new_item'			=> __( 'Add New Testimonial', 'Foxy' ),
		'edit_item' 			=> __( 'Edit Testimonial', 'Foxy' ),
		'new_item' 				=> __( 'New Testimonial', 'Foxy' ),
		'all_items' 			=> __( 'All Testimonials', 'Foxy' ),
		'view_item' 			=> __( 'View Testimonial', 'Foxy' ),
		'search_items' 			=> __( 'Search Testimonials', 'Foxy' ),
		'not_found' 			=> __( 'Nothing found', 'Foxy' ),
		'not_found_in_trash' 	=> __( 'Nothing found in Trash', 'Foxy' ),
		'parent_item_colon' 	=> ''
	);

	$args = array(
		'labels' 				=> $labels,
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'can_export'			=> true,
		'show_in_nav_menus'		=> true,
		'query_var' 			=> true,
		'has_archive' 			=> true,
		'rewrite' 				=> apply_filters( 'et_testimonial_posttype_rewrite_args', array( 'slug' => 'testimonial', 'with_front' => false ) ),
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'supports' 				=> array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' )
	);

	register_post_type( 'testimonial' , apply_filters( 'et_testimonial_posttype_args', $args ) );
}

//add filter to ensure the text Listing is displayed when user updates a listing
add_filter( 'post_updated_messages', 'et_custom_post_type_updated_message' );
function et_custom_post_type_updated_message( $messages ) {
	global $post, $post_id;

	$messages['testimonial'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __( 'Testimonial updated. <a href="%s">View testimonial</a>', 'Foxy' ), esc_url( get_permalink( $post_id ) ) ),
		2 => __( 'Custom field updated.', 'Foxy' ),
		3 => __( 'Custom field deleted.', 'Foxy' ),
		4 => __( 'Testimonial updated.', 'Foxy' ),
		/* translators: %s: date and time of the revision */
		5 => isset( $_GET['revision'] ) ? sprintf( __( 'Testimonial restored to revision from %s', 'Foxy' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __( 'Testimonial published. <a href="%s">View testimonial</a>', 'Foxy' ), esc_url( get_permalink( $post_id ) ) ),
		7 => __( 'Testimonial saved.', 'Foxy' ),
		8 => sprintf( __( 'Testimonial submitted. <a target="_blank" href="%s">Preview testimonial</a>', 'Foxy' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_id ) ) ) ),
		9 => sprintf( __( 'Testimonial scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview testimonial</a>', 'Foxy' ),
		  // translators: Publish box date format, see http://php.net/date
		  date_i18n( __( 'M j, Y @ G:i', 'Foxy' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_id ) ) ),
		10 => sprintf( __( 'Testimonial draft updated. <a target="_blank" href="%s">Preview testimonial</a>', 'Foxy' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_id ) ) ) )
	);

	return $messages;
}

add_action( 'add_meta_boxes', 'et_listing_posttype_meta_box' );
function et_listing_posttype_meta_box() {
	add_meta_box( 'et_settings_meta_box', __( 'ET Testimonial Settings', 'Foxy' ), 'et_testimonial_settings_meta_box', 'testimonial', 'normal', 'high' );
	add_meta_box( 'et_settings_meta_box', __( 'ET Settings', 'Foxy' ), 'et_single_settings_meta_box', 'post', 'normal', 'high' );
	add_meta_box( 'et_settings_meta_box', __( 'ET Settings', 'Foxy' ), 'et_single_settings_meta_box', 'page', 'normal', 'high' );
}

function et_single_settings_meta_box( $post ) {
	$post_id = get_the_ID();
	wp_nonce_field( basename( __FILE__ ), 'et_settings_nonce' );
?>
	<p><?php esc_html_e( 'If this post is displayed in the featured slider on homepage, you can set options for it here.', 'Foxy' ); ?></p>

	<p>
		<label for="et_slide_title" style="min-width: 150px; display: inline-block;"><?php esc_html_e( 'Slide Title', 'Foxy' ); ?>: </label>
		<input type="text" name="et_slide_title" id="et_slide_title" class="regular-text" value="<?php echo esc_attr( get_post_meta( $post_id, '_et_slide_title', true ) ); ?>" />
	</p>

	<p>
		<label for="et_slide_description" style="min-width: 150px; display: inline-block;"><?php esc_html_e( 'Slide Description', 'Foxy' ); ?>: </label>
		<input type="text" name="et_slide_description" id="et_slide_description" class="regular-text" value="<?php echo esc_attr( get_post_meta( $post_id, '_et_slide_description', true ) ); ?>" />
	</p>

	<p>
		<label for="et_slide_more_link" style="min-width: 150px; display: inline-block;"><?php esc_html_e( 'Read More Custom Link', 'Foxy' ); ?>: </label>
		<input type="text" name="et_slide_more_link" id="et_slide_more_link" class="regular-text" value="<?php echo esc_attr( get_post_meta( $post_id, '_et_slide_more_link', true ) ); ?>" />

		<br/>
		<small><?php esc_html_e( 'Here you can provide a custom url, that will be used for the slide', 'Foxy' ); ?></small>
	</p>

<?php if ( 'page' == $post->post_type ) : ?>
	<p>
		<label for="et_blurb_icon" style="min-width: 150px; display: inline-block;"><?php esc_html_e( 'Blurb Icon Image', 'Foxy' ); ?>: </label>
		<input type="text" name="et_blurb_icon" id="et_blurb_icon" class="regular-text" value="<?php echo esc_attr( get_post_meta( $post_id, '_et_blurb_icon', true ) ); ?>" />
		<input class="upload_image_button" type="button" value="<?php esc_html_e( 'Upload Image', 'Foxy' ); ?>"  data-choose="<?php esc_html_e( 'Choose Blurb Icon Image', 'Foxy' ); ?>" data-update="<?php esc_html_e( 'Use For Blurb Icon', 'Foxy' ); ?>" /><br/>
		<small><?php esc_html_e( 'If this page is used for a blurb, you can upload the icon image here.', 'Foxy' ); ?></small>
	</p>
<?php endif; ?>
<?php
}

function et_testimonial_settings_meta_box() {
	$post_id = get_the_ID();
	wp_nonce_field( basename( __FILE__ ), 'et_settings_nonce' );
?>
	<p>
		<label for="et_testimonial_company"><?php esc_html_e( 'Company Name', 'Foxy' ); ?>: </label>
		<input type="text" name="et_testimonial_company" id="et_testimonial_company" class="regular-text" value="<?php echo esc_attr( get_post_meta( $post_id, '_et_testimonial_company', true ) ); ?>" />
	</p>
<?php
}

add_action( 'save_post', 'et_metabox_settings_save_details', 10, 2 );
function et_metabox_settings_save_details( $post_id, $post ){
	global $pagenow;

	if ( 'post.php' != $pagenow ) return $post_id;

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;

	$post_type = get_post_type_object( $post->post_type );
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	if ( !isset( $_POST['et_settings_nonce'] ) || ! wp_verify_nonce( $_POST['et_settings_nonce'], basename( __FILE__ ) ) )
        return $post_id;

	if ( in_array( $_POST['post_type'], array( 'post', 'page' ) ) ) {
		if ( isset( $_POST['et_slide_title'] ) )
			update_post_meta( $post_id, '_et_slide_title', sanitize_text_field( $_POST['et_slide_title'] ) );
		else
			delete_post_meta( $post_id, '_et_slide_title' );

		if ( isset( $_POST['et_slide_description'] ) )
			update_post_meta( $post_id, '_et_slide_description', sanitize_text_field( $_POST['et_slide_description'] ) );
		else
			delete_post_meta( $post_id, '_et_slide_description' );

		if ( isset( $_POST['et_slide_more_link'] ) )
			update_post_meta( $post_id, '_et_slide_more_link', esc_url_raw( $_POST['et_slide_more_link'] ) );
		else
			delete_post_meta( $post_id, '_et_slide_more_link' );

		if ( isset( $_POST['et_blurb_icon'] ) )
			update_post_meta( $post_id, '_et_blurb_icon', esc_url_raw( $_POST['et_blurb_icon'] ) );
		else
			delete_post_meta( $post_id, '_et_blurb_icon' );
	} else if ( 'testimonial' == $_POST['post_type'] ) {
		if ( isset( $_POST['et_testimonial_company'] ) )
			update_post_meta( $post_id, '_et_testimonial_company', sanitize_text_field( $_POST['et_testimonial_company'] ) );
		else
			delete_post_meta( $post_id, '_et_testimonial_company' );
	}
}

function et_foxy_admin_scripts_styles( $hook ) {
	global $typenow;

	if ( ! in_array( $hook, array( 'post-new.php', 'post.php' ) ) ) return;

	$template_dir = get_template_directory_uri();

	if ( ! isset( $typenow ) ) return;

	if ( 'page' == $typenow ) {
		wp_enqueue_script( 'et_image_upload_custom', $template_dir . '/js/admin_custom_uploader.js', array( 'jquery' ) );
	}
}

/**
 * Gets all on sale product IDs, stores it in the transient
 * Note: the code is taken from the onsale widget
 */
function et_woocommerce_get_product_on_sale_ids(){
	if ( false === ( $product_ids_on_sale = get_transient( 'wc_products_onsale' ) ) ) {
		$meta_query = array();

	    $meta_query[] = array(
	    	'key' => '_sale_price',
	        'value' 	=> 0,
			'compare' 	=> '>',
			'type'		=> 'NUMERIC'
	    );

		$on_sale = get_posts(array(
			'post_type' 		=> array('product', 'product_variation'),
			'posts_per_page' 	=> -1,
			'post_status' 		=> 'publish',
			'meta_query' 		=> $meta_query,
			'fields' 			=> 'id=>parent'
		));

		$product_ids 	= array_keys( $on_sale );
		$parent_ids		= array_values( $on_sale );

		// Check for scheduled sales which have not started
		foreach ( $product_ids as $key => $id )
			if ( get_post_meta( $id, '_sale_price_dates_from', true ) > current_time('timestamp') )
				unset( $product_ids[ $key ] );

		$product_ids_on_sale = array_unique( array_merge( $product_ids, $parent_ids ) );

		set_transient( 'wc_products_onsale', $product_ids_on_sale );
	}

	return $product_ids_on_sale;
}

function et_format_currency_symbol( $currency_symbol ) {
	return '<span>' . $currency_symbol . '</span>';
}

/**
 * Overrides the plugin function to modify breadcrumbs default settings
 */
function woocommerce_breadcrumb( $args = array() ) {
	$defaults = array(
		'delimiter'  => ' <span class="raquo">&raquo;</span> ',
		'wrap_before'  => '<div id="breadcrumbs" itemprop="breadcrumb">',
		'wrap_after' => '<span class="raquo">&raquo;</span></div>',
		'before'   => '',
		'after'   => '',
		'home'    => null
	);

	$args = wp_parse_args( $args, $defaults  );

	if ( function_exists( 'WC' ) ) {
		wc_get_template( 'global/breadcrumb.php', $args );
	} else {
		woocommerce_get_template( 'shop/breadcrumb.php', $args );
	}
}

function et_add_woocommerce_class_to_homepage( $classes ) {
	if ( is_home() ) $classes[] = 'woocommerce';

	return $classes;
}

function et_foxy_output_content_wrapper() {
	get_template_part( 'includes/breadcrumbs', 'index' );

	get_template_part( 'includes/top_info', 'index' );

	echo '
		<div id="content" class="clearfix">
			<div id="left-area">';
}

function et_foxy_output_content_wrapper_end() {
	echo '
			<div class="clear"></div>
		</div> <!-- #left-area -->';

		woocommerce_get_sidebar();

	echo '</div> <!-- #content -->';
}

function et_disable_woocommerce_title( $show_title ) {
	return false;
}
add_filter( 'woocommerce_show_page_title', 'et_disable_woocommerce_title' );

function et_foxy_loop_shop_columns( $columns ) {
	return 3;
}
add_filter( 'loop_shop_columns', 'et_foxy_loop_shop_columns' );

function woocommerce_template_loop_price() {
	global $product;

	$et_price_before = 'variable' == $product->product_type ? $product->min_variation_regular_price : $product->regular_price;
	$product_ids_on_sale = et_woocommerce_get_product_on_sale_ids();

	if ( ! in_array( get_the_ID(), array_map( 'intval', $product_ids_on_sale ) ) ) {
		if ( '' != $product->get_price_html() ) : ?>
		<div class="et-price-button">
			<span class="et-price-sale"><?php echo $product->get_price_html(); ?></span>
		</div>
		<?php endif;
	} else { ?>
		<div class="et-price-button et-product-on-sale">
			<span class="et-price-before"><del><?php echo woocommerce_price( $et_price_before ); ?></del></span>
			<span class="et-price-sale"><?php echo woocommerce_price( $product->get_price() ); ?></span>
		</div>
	<?php }
}

function woocommerce_output_product_data_tabs() {
	/**
	 * Single Product tabs
	 *
	 * @author 		WooThemes
	 * @package 	WooCommerce/Templates
	 * @version     2.0.0
	 */

	/**
	 * Filter tabs and allow third parties to add their own
	 *
	 * Each tab is an array containing title, callback and priority.
	 * @see woocommerce_default_product_tabs()
	 */
	$tabs = apply_filters( 'woocommerce_product_tabs', array() );

	if ( ! empty( $tabs ) ) : ?>

		<div class="clear"></div>

		<div id="home-tab-area">
			<ul class="tabs">
			<?php $i = 1; ?>
				<?php foreach ( $tabs as $key => $tab ) : ?>

					<li class="<?php echo $key ?>_tab<?php if ( 1 == $i ) echo ' home-tab-active'; ?>">
						<?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ); ?>
					</li>

					<?php $i++; ?>
				<?php endforeach; ?>
			</ul>
			<div id="home-tabs-content">
			<?php foreach ( $tabs as $key => $tab ) : ?>

				<div class="home-tab-slide" id="tab-<?php echo $key; ?>">
					<?php call_user_func( $tab['callback'], $key, $tab ); ?>
				</div>

			<?php endforeach; ?>
			</div>
		</div>

	<?php endif;
}

if ( function_exists( 'get_custom_header' ) ) {
	// compatibility with versions of WordPress prior to 3.4

	add_action( 'customize_register', 'et_foxy_customize_register' );
	function et_foxy_customize_register( $wp_customize ) {
		$google_fonts = et_get_google_fonts();

		$font_choices = array();
		$font_choices['none'] = 'Default Theme Font';
		foreach ( $google_fonts as $google_font_name => $google_font_properties ) {
			$font_choices[ $google_font_name ] = $google_font_name;
		}

		$wp_customize->remove_section( 'title_tagline' );
		$wp_customize->remove_section( 'background_image' );

		$wp_customize->add_section( 'et_google_fonts' , array(
			'title'		=> __( 'Fonts', 'Foxy' ),
			'priority'	=> 50,
		) );

		$wp_customize->add_section( 'et_color_schemes' , array(
			'title'       => __( 'Schemes', 'Foxy' ),
			'priority'    => 60,
			'description' => __( 'Note: Color settings set above should be applied to the Default color scheme.', 'Foxy' ),
		) );

		$wp_customize->add_setting( 'et_foxy[link_color]', array(
			'default'		=> '#4bb6f5',
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage'
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'et_foxy[link_color]', array(
			'label'		=> __( 'Link Color', 'Foxy' ),
			'section'	=> 'colors',
			'settings'	=> 'et_foxy[link_color]',
		) ) );

		$wp_customize->add_setting( 'et_foxy[font_color]', array(
			'default'		=> '#878787',
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage'
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'et_foxy[font_color]', array(
			'label'		=> __( 'Main Font Color', 'Foxy' ),
			'section'	=> 'colors',
			'settings'	=> 'et_foxy[font_color]',
		) ) );

		$wp_customize->add_setting( 'et_foxy[slider_bg]', array(
			'default'		=> '#f7a13c',
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage'
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'et_foxy[slider_bg]', array(
			'label'		=> __( 'Slider Background Color', 'Foxy' ),
			'section'	=> 'colors',
			'settings'	=> 'et_foxy[slider_bg]',
		) ) );

		$wp_customize->add_setting( 'et_foxy[slider_shadow]', array(
			'default'		=> '#bd3905',
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage'
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'et_foxy[slider_shadow]', array(
			'label'		=> __( 'Slider Shadow Color', 'Foxy' ),
			'section'	=> 'colors',
			'settings'	=> 'et_foxy[slider_shadow]',
		) ) );

		$wp_customize->add_setting( 'et_foxy[button_bg]', array(
			'default'		=> '#ff8a1d',
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage'
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'et_foxy[button_bg]', array(
			'label'		=> __( 'Button / Tab Background Color', 'Foxy' ),
			'section'	=> 'colors',
			'settings'	=> 'et_foxy[button_bg]',
		) ) );

		$wp_customize->add_setting( 'et_foxy[button_shadow]', array(
			'default'		=> '#d9531f',
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage'
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'et_foxy[button_shadow]', array(
			'label'		=> __( 'Button / Tab Shadow Color', 'Foxy' ),
			'section'	=> 'colors',
			'settings'	=> 'et_foxy[button_shadow]',
		) ) );

		$wp_customize->add_setting( 'et_foxy[widget_highlight]', array(
			'default'		=> '#ed6f1d',
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage'
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'et_foxy[widget_highlight]', array(
			'label'		=> __( 'Widget Hightlight Color / Progress Bar Color', 'Foxy' ),
			'section'	=> 'colors',
			'settings'	=> 'et_foxy[widget_highlight]',
		) ) );

		$wp_customize->add_setting( 'et_foxy[heading_font]', array(
			'default'		=> 'none',
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options'
		) );

		$wp_customize->add_control( 'et_foxy[heading_font]', array(
			'label'		=> __( 'Header Font', 'Foxy' ),
			'section'	=> 'et_google_fonts',
			'settings'	=> 'et_foxy[heading_font]',
			'type'		=> 'select',
			'choices'	=> $font_choices
		) );

		$wp_customize->add_setting( 'et_foxy[body_font]', array(
			'default'		=> 'none',
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options'
		) );

		$wp_customize->add_control( 'et_foxy[body_font]', array(
			'label'		=> __( 'Body Font', 'Foxy' ),
			'section'	=> 'et_google_fonts',
			'settings'	=> 'et_foxy[body_font]',
			'type'		=> 'select',
			'choices'	=> $font_choices
		) );

		$wp_customize->add_setting( 'et_foxy[color_schemes]', array(
			'default'		=> 'none',
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage'
		) );

		$wp_customize->add_control( 'et_foxy[color_schemes]', array(
			'label'		=> __( 'Color Schemes', 'Foxy' ),
			'section'	=> 'et_color_schemes',
			'settings'	=> 'et_foxy[color_schemes]',
			'type'		=> 'select',
			'choices'	=> array(
				'none'   => __( 'Default', 'Foxy' ),
				'blue'   => __( 'Blue', 'Foxy' ),
				'green'  => __( 'Green', 'Foxy' ),
				'purple' => __( 'Purple', 'Foxy' ),
				'red'    => __( 'Red', 'Foxy' ),
				'gray'   => __( 'Gray', 'Foxy' ),
			),
		) );
	}

	add_action( 'customize_preview_init', 'et_foxy_customize_preview_js' );
	function et_foxy_customize_preview_js() {
		wp_enqueue_script( 'foxy-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), false, true );
	}

	add_action( 'wp_head', 'et_foxy_add_customizer_css' );
	add_action( 'customize_controls_print_styles', 'et_foxy_add_customizer_css' );
	function et_foxy_add_customizer_css(){ ?>
		<style>
			a { color: <?php echo esc_html( et_get_option( 'link_color', '#4bb6f5' ) ); ?>; }
			body { color: <?php echo esc_html( et_get_option( 'font_color', '#878787' ) ); ?>; }

			#featured { background-color: <?php echo esc_html( et_get_option( 'slider_bg', '#f7a13c' ) ); ?>; }

			#featured { -webkit-box-shadow: inset 0 0 250px <?php echo esc_html( et_get_option( 'slider_shadow', '#bd3905' ) ); ?>; -moz-box-shadow: inset 0 0 250px <?php echo esc_html( et_get_option( 'slider_shadow', '#bd3905' ) ); ?>; box-shadow: inset 0 0 250px <?php echo esc_html( et_get_option( 'slider_shadow', '#bd3905' ) ); ?>; }

			#top-navigation > ul > li.sfHover > a, #top-navigation > ul > li > a:hover, .mobile_nav, #home-tab-area > ul > li.home-tab-active, #footer-bottom li a:hover, .et-product:hover .et-price-button, .et-products li:hover .et-price-button, #callout { background-color: <?php echo esc_html( et_get_option( 'button_bg', '#ff8a1d' ) ); ?>; }
			@media only screen and (max-width: 767px){
				#callout > strong { background-color: <?php echo esc_html( et_get_option( 'button_bg', '#ff8a1d' ) ); ?>; }
			}
			#top-navigation > ul > li.sfHover > a, #top-navigation > ul > li > a:hover, #home-tab-area > ul > li.home-tab-active, #footer-bottom li a:hover, .mobile_nav, #callout { -moz-box-shadow: inset 0 0 30px <?php echo esc_html( et_get_option( 'button_shadow', '#d9531f' ) ); ?>; -webkit-box-shadow: inset 0 0 30px <?php echo esc_html( et_get_option( 'button_shadow', '#d9531f' ) ); ?>; box-shadow: inset 0 0 30px <?php echo esc_html( et_get_option( 'button_shadow', '#d9531f' ) ); ?>; }

			#progress-time { background-color: <?php echo esc_html( et_get_option( 'widget_highlight', '#ed6f1d' ) ); ?>; }
			#home-tab-area > ul, .widget h4.widgettitle { border-bottom: 5px solid <?php echo esc_html( et_get_option( 'widget_highlight', '#ed6f1d' ) ); ?>; }

		<?php
			$et_gf_heading_font = sanitize_text_field( et_get_option( 'heading_font', 'none' ) );
			$et_gf_body_font = sanitize_text_field( et_get_option( 'body_font', 'none' ) );

			if ( 'none' != $et_gf_heading_font || 'none' != $et_gf_body_font ) :

				if ( 'none' != $et_gf_heading_font )
					et_gf_attach_font( $et_gf_heading_font, 'h1, h2, h3, h4, h5, h6, .slide .description h2, .post-heading h1, h1#comments, #reply-title, h1.category-title, .post-description h2, .related.products h2' );

				if ( 'none' != $et_gf_body_font )
					et_gf_attach_font( $et_gf_body_font, 'body' );

			endif;
		?>
		</style>
	<?php }

	/*
	 * Adds color scheme class to the body tag
	 */
	add_filter( 'body_class', 'et_customizer_color_scheme_class' );
	function et_customizer_color_scheme_class( $body_class ) {
		$color_scheme        = et_get_option( 'color_schemes', 'none' );
		$color_scheme_prefix = 'et_color_scheme_';

		if ( 'none' !== $color_scheme ) $body_class[] = $color_scheme_prefix . $color_scheme;

		return $body_class;
	}

	add_action( 'customize_controls_print_footer_scripts', 'et_load_google_fonts_scripts' );
	function et_load_google_fonts_scripts() {
		wp_enqueue_script( 'et_google_fonts', get_template_directory_uri() . '/epanel/google-fonts/et_google_fonts.js', array( 'jquery' ), '1.0', true );
	}

	add_action( 'customize_controls_print_styles', 'et_load_google_fonts_styles' );
	function et_load_google_fonts_styles() {
		wp_enqueue_style( 'et_google_fonts_style', get_template_directory_uri() . '/epanel/google-fonts/et_google_fonts.css', array(), null );
	}
}