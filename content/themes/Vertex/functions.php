<?php

if ( ! isset( $content_width ) ) $content_width = 640;

function et_setup_theme(){
	global $themename, $shortname, $et_store_options_in_one_row, $default_colorscheme;
	$themename = 'Vertex';
	$shortname = 'vertex';
	$et_store_options_in_one_row = true;

	$default_colorscheme = "Default";

	$template_directory = get_template_directory();

	require_once( $template_directory . '/epanel/custom_functions.php' );

	require_once( $template_directory . '/includes/functions/comments.php' );

	require_once( $template_directory . '/includes/functions/sidebars.php' );

	load_theme_textdomain( 'Vertex', $template_directory . '/lang' );

	require_once( $template_directory . '/epanel/core_functions.php' );

	require_once( $template_directory . '/epanel/post_thumbnails_vertex.php' );

	include( $template_directory . '/includes/widgets.php' );

	register_nav_menus( array(
		'primary-menu' => __( 'Primary Menu', 'Vertex' ),
	) );

	// don't display the empty title bar if the widget title is not set
	remove_filter( 'widget_title', 'et_widget_force_title' );

	add_action( 'wp_enqueue_scripts', 'et_add_responsive_shortcodes_css', 11 );
}
add_action( 'after_setup_theme', 'et_setup_theme' );

if ( ! function_exists( 'et_vertex_fonts_url' ) ) :
function et_vertex_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Open Sans, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$open_sans = _x( 'on', 'Open Sans font: on or off', 'Vertex' );

	/* Translators: If there are characters in your language that are not
	 * supported by Raleway, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$raleway = _x( 'on', 'Raleway font: on or off', 'Vertex' );

	if ( 'off' !== $open_sans || 'off' !== $raleway ) {
		$font_families = array();

		if ( 'off' !== $open_sans )
			$font_families[] = 'Open+Sans:300italic,400italic,700italic,800italic,400,300,700,800';

		if ( 'off' !== $raleway )
			$font_families[] = 'Raleway:400,200,100,500,700,800';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => implode( '|', $font_families ),
			'subset' => 'latin,latin-ext',
		);
		$fonts_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
	}

	return $fonts_url;
}
endif;

function et_vertex_load_fonts() {
	$fonts_url = et_vertex_fonts_url();
	if ( ! empty( $fonts_url ) )
		wp_enqueue_style( 'vertex-fonts', esc_url_raw( $fonts_url ), array(), null );
}
add_action( 'wp_enqueue_scripts', 'et_vertex_load_fonts' );

function et_add_home_link( $args ) {
	// add Home link to the custom menu WP-Admin page
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'et_add_home_link' );

function et_vertex_load_scripts_styles(){
	global $wp_styles;

	$template_dir = get_template_directory_uri();

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	wp_enqueue_script( 'superfish', $template_dir . '/js/superfish.js', array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'waypoints', $template_dir . '/js/waypoints.min.js', array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'vertex-custom-script', $template_dir . '/js/custom.js', array( 'jquery' ), '1.0', true );
	wp_localize_script( 'vertex-custom-script', 'et_custom', array(
		'mobile_nav_text' 	=> esc_html__( 'Navigation Menu', 'Vertex' ),
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
	wp_enqueue_style( 'vertex-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'et_vertex_load_scripts_styles' );

function et_add_mobile_navigation(){
	echo '<div id="et_mobile_nav_menu">' . '<a href="#" class="mobile_nav closed">' . '<span class="desktop-text">' . esc_html__( 'Navigation Menu', 'Vertex' ) . '</span>' . '<span class="mobile-text">' . esc_html__( 'Menu', 'Vertex' ) . '</span>' . '<span class="et_mobile_arrow"></span>' . '</a>' . '</div>';
}
add_action( 'et_header_top', 'et_add_mobile_navigation' );

/**
 * Filters the main query on homepage
 */
function et_home_posts_query( $query = false ) {
	/* Don't proceed if it's not homepage or the main query */
	if ( ! is_home() || ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() ) return;

	/* Only filter the homepage query if the Blog Style mode is activated */
	if ( 'false' === et_get_option( 'vertex_blog_style', 'false' ) ) return;

	/* Set the amount of posts per page on homepage */
	$query->set( 'posts_per_page', (int) et_get_option( 'vertex_homepage_posts', 8 ) );

	$exclude_categories = et_get_option( 'vertex_exlcats_recent', false, 'category' );

	if ( $exclude_categories ) $query->set( 'category__not_in', array_map( 'intval', $exclude_categories ) );
}
add_action( 'pre_get_posts', 'et_home_posts_query' );

function et_add_viewport_meta(){
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />';
}
add_action( 'wp_head', 'et_add_viewport_meta' );

function et_remove_additional_stylesheet( $stylesheet ){
	global $default_colorscheme;
	return $default_colorscheme;
}
add_filter( 'et_get_additional_color_scheme', 'et_remove_additional_stylesheet' );

if ( ! function_exists( 'et_list_pings' ) ) :
function et_list_pings($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?> - <?php comment_excerpt(); ?>
<?php }
endif;

if ( ! function_exists( 'et_get_the_author_posts_link' ) ) :
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
endif;

if ( ! function_exists( 'et_get_comments_popup_link' ) ) :
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
endif;

if ( ! function_exists( 'et_postinfo_meta' ) ) :
function et_postinfo_meta( $postinfo, $date_format, $comment_zero, $comment_one, $comment_more ){
	global $themename;

	$postinfo_meta = esc_html__('Posted',$themename);


	if ( in_array( 'author', $postinfo ) && 'project' !== get_post_type() )
		$postinfo_meta .= ' ' . esc_html__('By',$themename) . ' ' . et_get_the_author_posts_link();

	if ( in_array( 'date', $postinfo ) )
		$postinfo_meta .= ' ' . esc_html__('on',$themename) . ' ' . get_the_time( $date_format );

	if ( in_array( 'categories', $postinfo ) && 'project' !== get_post_type() )
		$postinfo_meta .= ' ' . esc_html__('in',$themename) . ' ' . get_the_category_list(', ');

	if ( in_array( 'comments', $postinfo ) )
		$postinfo_meta .= ' | ' . et_get_comments_popup_link( $comment_zero, $comment_one, $comment_more );

	echo $postinfo_meta;
}
endif;

function et_vertex_register_posttypes() {
	$labels = array(
		'name'               => _x( 'Projects', 'project type general name', 'Vertex' ),
		'singular_name'      => _x( 'Project', 'project type singular name', 'Vertex' ),
		'add_new'            => _x( 'Add New', 'project item', 'Vertex' ),
		'add_new_item'       => __( 'Add New Project', 'Vertex' ),
		'edit_item'          => __( 'Edit Project', 'Vertex' ),
		'new_item'           => __( 'New Project', 'Vertex' ),
		'all_items'          => __( 'All Projects', 'Vertex' ),
		'view_item'          => __( 'View Project', 'Vertex' ),
		'search_items'       => __( 'Search Projects', 'Vertex' ),
		'not_found'          => __( 'Nothing found', 'Vertex' ),
		'not_found_in_trash' => __( 'Nothing found in Trash', 'Vertex' ),
		'parent_item_colon'  => '',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'can_export'         => true,
		'show_in_nav_menus'  => true,
		'query_var'          => true,
		'has_archive'        => true,
		'rewrite'            => apply_filters( 'et_project_posttype_rewrite_args', array(
			'feeds'      => true,
			'slug'       => 'project',
			'with_front' => false,
		) ),
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' ),
	);

	register_post_type( 'project', apply_filters( 'et_project_posttype_args', $args ) );

	$labels = array(
		'name'              => _x( 'Categories', 'Project category name', 'Vertex' ),
		'singular_name'     => _x( 'Category', 'Project category singular name', 'Vertex' ),
		'search_items'      => __( 'Search Categories', 'Vertex' ),
		'all_items'         => __( 'All Categories', 'Vertex' ),
		'parent_item'       => __( 'Parent Category', 'Vertex' ),
		'parent_item_colon' => __( 'Parent Category:', 'Vertex' ),
		'edit_item'         => __( 'Edit Category', 'Vertex' ),
		'update_item'       => __( 'Update Category', 'Vertex' ),
		'add_new_item'      => __( 'Add New Category', 'Vertex' ),
		'new_item_name'     => __( 'New Category Name', 'Vertex' ),
		'menu_name'         => __( 'Category', 'Vertex' ),
	);

	register_taxonomy( 'project_category', array( 'project' ), array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	) );

	$labels = array(
		'name'               => _x( 'Team Members', 'Team Member type general name', 'Vertex' ),
		'singular_name'      => _x( 'Team Member', 'Team Member type singular name', 'Vertex' ),
		'add_new'            => _x( 'Add New', 'Team Member item', 'Vertex' ),
		'add_new_item'       => __( 'Add New Team Member', 'Vertex' ),
		'edit_item'          => __( 'Edit Team Member', 'Vertex' ),
		'new_item'           => __( 'New Team Member', 'Vertex' ),
		'all_items'          => __( 'All Team Members', 'Vertex' ),
		'view_item'          => __( 'View Team Member', 'Vertex' ),
		'search_items'       => __( 'Search Team Members', 'Vertex' ),
		'not_found'          => __( 'Nothing found', 'Vertex' ),
		'not_found_in_trash' => __( 'Nothing found in Trash', 'Vertex' ),
		'parent_item_colon'  => '',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'can_export'         => true,
		'show_in_nav_menus'  => true,
		'query_var'          => true,
		'has_archive'        => true,
		'rewrite'            => apply_filters( 'et_team_member_posttype_rewrite_args', array(
			'slug'       => 'team-member',
			'with_front' => false,
		) ),
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' ),
	);

	register_post_type( 'team-member', apply_filters( 'et_team_member_posttype_args', $args ) );

	$labels = array(
		'name'               => _x( 'Testimonials', 'Testimonial type general name', 'Vertex' ),
		'singular_name'      => _x( 'Testimonial', 'Testimonial type singular name', 'Vertex' ),
		'add_new'            => _x( 'Add New', 'Testimonial item', 'Vertex' ),
		'add_new_item'       => __( 'Add New Testimonial', 'Vertex' ),
		'edit_item'          => __( 'Edit Testimonial', 'Vertex' ),
		'new_item'           => __( 'New Testimonial', 'Vertex' ),
		'all_items'          => __( 'All Testimonials', 'Vertex' ),
		'view_item'          => __( 'View Testimonial', 'Vertex' ),
		'search_items'       => __( 'Search Testimonials', 'Vertex' ),
		'not_found'          => __( 'Nothing found', 'Vertex' ),
		'not_found_in_trash' => __( 'Nothing found in Trash', 'Vertex' ),
		'parent_item_colon'  => '',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'can_export'         => true,
		'show_in_nav_menus'  => true,
		'query_var'          => true,
		'has_archive'        => true,
		'rewrite'            => apply_filters( 'et_testimonial_posttype_rewrite_args', array(
			'slug'       => 'testimonial',
			'with_front' => false,
		) ),
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' ),
	);

	register_post_type( 'testimonial', apply_filters( 'et_testimonial_posttype_args', $args ) );
}
add_action( 'init', 'et_vertex_register_posttypes', 0 );

// Ensures correct post type is displayed in WP-Admin
function et_custom_post_type_updated_message( $messages ) {
	global $post, $post_id;

	$messages['project'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => sprintf( __( 'Project updated. <a href="%s">View Project</a>', 'Vertex' ), esc_url( get_permalink( $post_id ) ) ),
		2  => __( 'Custom field updated.', 'Vertex' ),
		3  => __( 'Custom field deleted.', 'Vertex' ),
		4  => __( 'Project updated.', 'Vertex' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Project restored to revision from %s', 'Vertex' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => sprintf( __( 'Project published. <a href="%s">View Project</a>', 'Vertex' ), esc_url( get_permalink( $post_id ) ) ),
		7  => __( 'Project saved.', 'Vertex' ),
		8  => sprintf( __( 'Project submitted. <a target="_blank" href="%s">Preview Project</a>', 'Vertex' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_id ) ) ) ),
		9  => sprintf( __( 'Project scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Project</a>', 'Vertex' ),
		  // translators: Publish box date format, see http://php.net/date
		  date_i18n( __( 'M j, Y @ G:i', 'Vertex' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_id ) ) ),
		10  => sprintf( __( 'Project draft updated. <a target="_blank" href="%s">Preview project</a>', 'Vertex' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_id ) ) ) ),
	);

	$messages['testimonial'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => sprintf( __( 'Testimonial updated. <a href="%s">View Testimonial</a>', 'Vertex' ), esc_url( get_permalink( $post_id ) ) ),
		2  => __( 'Custom field updated.', 'Vertex' ),
		3  => __( 'Custom field deleted.', 'Vertex' ),
		4  => __( 'Testimonial updated.', 'Vertex' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Testimonial restored to revision from %s', 'Vertex' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => sprintf( __( 'Testimonial published. <a href="%s">View Testimonial</a>', 'Vertex' ), esc_url( get_permalink( $post_id ) ) ),
		7  => __( 'Testimonial saved.', 'Vertex' ),
		8  => sprintf( __( 'Testimonial submitted. <a target="_blank" href="%s">Preview Testimonial</a>', 'Vertex' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_id ) ) ) ),
		9  => sprintf( __( 'Testimonial scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Testimonial</a>', 'Vertex' ),
		  // translators: Publish box date format, see http://php.net/date
		  date_i18n( __( 'M j, Y @ G:i', 'Vertex' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_id ) ) ),
		10  => sprintf( __( 'Testimonial draft updated. <a target="_blank" href="%s">Preview Testimonial</a>', 'Vertex' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_id ) ) ) ),
	);

	$messages['team-member'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => sprintf( __( 'Team Member updated. <a href="%s">View Team Member</a>', 'Vertex' ), esc_url( get_permalink( $post_id ) ) ),
		2  => __( 'Custom field updated.', 'Vertex' ),
		3  => __( 'Custom field deleted.', 'Vertex' ),
		4  => __( 'Team Member updated.', 'Vertex' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Team Member restored to revision from %s', 'Vertex' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => sprintf( __( 'Team Member published. <a href="%s">View Team Member</a>', 'Vertex' ), esc_url( get_permalink( $post_id ) ) ),
		7  => __( 'Team Member saved.', 'Vertex' ),
		8  => sprintf( __( 'Team Member submitted. <a target="_blank" href="%s">Preview Team Member</a>', 'Vertex' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_id ) ) ) ),
		9  => sprintf( __( 'Team Member scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Team Member</a>', 'Vertex' ),
		  // translators: Publish box date format, see http://php.net/date
		  date_i18n( __( 'M j, Y @ G:i', 'Vertex' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_id ) ) ),
		10  => sprintf( __( 'Team Member draft updated. <a target="_blank" href="%s">Preview Team Member</a>', 'Vertex' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_id ) ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'et_custom_post_type_updated_message' );

function et_add_post_meta_box() {
	add_meta_box( 'et_settings_meta_box', __( 'ET Settings', 'Vertex' ), 'et_single_settings_meta_box', 'post', 'normal', 'high' );
	add_meta_box( 'et_settings_meta_box', __( 'ET Settings', 'Vertex' ), 'et_single_settings_meta_box', 'page', 'normal', 'high' );
	add_meta_box( 'et_settings_meta_box', __( 'ET Settings', 'Vertex' ), 'et_single_settings_meta_box', 'project', 'normal', 'high' );
	add_meta_box( 'et_settings_meta_box', __( 'ET Settings', 'Vertex' ), 'et_single_settings_meta_box', 'team-member', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'et_add_post_meta_box' );

if ( ! function_exists( 'et_single_settings_meta_box' ) ) :
function et_single_settings_meta_box( $post ) {
	$post_id = get_the_ID();

	$skill_names  = get_post_meta( $post_id, '_et_skill_name', true );
	$skill_values = get_post_meta( $post_id, '_et_skill_value', true );
	$position     = get_post_meta( $post_id, '_et_position', true );

	wp_nonce_field( basename( __FILE__ ), 'et_settings_nonce' );
?>

	<?php if ( 'team-member' === $post->post_type ) { ?>
	<p style="padding: 10px;">
		<label for="et_position" style="display: inline-block; min-width: 120px; font-weight: bold; margin-bottom: 5px;"><?php esc_html_e( 'Position', 'Vertex' ); ?>: </label>
		<input id="et_position" name="et_position" class="regular-text" type="text" value="<?php echo esc_attr( $position ); ?>" />
	</p>

	<div class="et_vertex_skills_settings">
	<?php
	if ( is_array( $skill_names ) ) {
		foreach( $skill_names as $skill_key => $skill_name ) {
	?>
		<div class="et-skill">
			<label><?php esc_html_e( 'Skill Name', 'Vertex' ); ?>: </label>
			<input class="et_skill_name regular-text" name="et_skill_name[]" type="text" value="<?php echo esc_attr( $skill_name ); ?>" />

			<br/>

			<label><?php esc_html_e( 'Skill Value ( 0-100 )', 'Vertex' ); ?>: </label>
			<input class="et_skill_value regular-text" name="et_skill_value[]" type="text" value="<?php echo esc_attr( $skill_values[$skill_key] ); ?>" />

			<a href="#" class="button button-secondary et-delete-skill"><?php esc_html_e( 'Delete Skill', 'Vertex' ); ?></a>
		</div>
<?php
		}
	} else {
?>
		<div class="et-skill">
			<label><?php esc_html_e( 'Skill Name', 'Vertex' ); ?>: </label>
			<input class="et_skill_name regular-text" name="et_skill_name[]" type="text" value="" />

			<br/>

			<label><?php esc_html_e( 'Skill Value ( 0-100 )', 'Vertex' ); ?>: </label>
			<input class="et_skill_value regular-text" name="et_skill_value[]" type="text" value="" />

			<a href="#" class="button button-secondary et-delete-skill"><?php esc_html_e( 'Delete Skill', 'Vertex' ); ?></a>
		</div>
<?php
	}
?>
		<a href="#" class="button button-primary et-add-skill"><?php esc_html_e( 'Add Skill', 'Vertex' ); ?></a>
	</div>
<?php
	}

	if ( in_array( $post->post_type, array( 'post', 'page', 'project'  ) ) ) { ?>
	<p>
		<label for="et_single_bg_image" style="min-width: 150px; display: inline-block;"><?php esc_html_e( 'Header Background Image', 'Vertex' ); ?>: </label>
		<input type="text" name="et_single_bg_image" id="et_single_bg_image" class="regular-text" value="<?php echo esc_attr( get_post_meta( $post_id, '_et_single_bg_image', true ) ); ?>" />
		<input class="upload_image_button" type="button" value="<?php esc_html_e( 'Upload Image', 'Vertex' ); ?>" data-choose="<?php esc_attr_e( 'Choose Header Background Image', 'Vertex' ); ?>" data-update="<?php esc_attr_e( 'Use For Header Background', 'Vertex' ); ?>" /><br/>
	</p>
<?php
	}
}
endif;

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

	if ( isset( $_POST['et_single_bg_image'] ) )
		update_post_meta( $post_id, '_et_single_bg_image', esc_url_raw( $_POST['et_single_bg_image'] ) );
	else
		delete_post_meta( $post_id, '_et_single_bg_image' );

	if ( isset( $_POST['et_position'] ) )
		update_post_meta( $post_id, '_et_position', sanitize_text_field( $_POST['et_position'] ) );
	else
		delete_post_meta( $post_id, '_et_position' );

	if ( isset( $_POST['et_skill_name'] ) && '' !== $_POST['et_skill_name'][0] )
		update_post_meta( $post_id, '_et_skill_name', array_map( 'sanitize_text_field', $_POST['et_skill_name'] ) );
	else
		delete_post_meta( $post_id, '_et_skill_name' );

	if ( isset( $_POST['et_skill_value'] ) && '' !== $_POST['et_skill_value'][0] )
		update_post_meta( $post_id, '_et_skill_value', array_map( 'intval', $_POST['et_skill_value'] ) );
	else
		delete_post_meta( $post_id, '_et_skill_value' );
}
add_action( 'save_post', 'et_metabox_settings_save_details', 10, 2 );

function et_vertex_post_admin_scripts_styles( $hook ) {
	global $typenow;

	if ( ! in_array( $hook, array( 'post-new.php', 'post.php' ) ) ) return;

	if ( ! isset( $typenow ) ) return;

	if ( 'team-member' === $typenow ) {
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'et-admin-post-script', get_template_directory_uri() . '/js/admin_post_settings.js', array( 'jquery' ) );
		wp_enqueue_style( 'et-admin-skills-style', get_template_directory_uri() . '/css/admin_team_member_post.css' );
	}

	if ( in_array( $typenow, array( 'post', 'page', 'project' ) ) )
		wp_enqueue_script( 'et_image_upload_custom', get_template_directory_uri() . '/js/admin_custom_uploader.js', array( 'jquery' ) );
}
add_action( 'admin_enqueue_scripts', 'et_vertex_post_admin_scripts_styles' );

// Flushes permalinks on theme activation
function et_rewrite_flush() {
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'et_rewrite_flush' );

function et_attach_bg_images() {
	$template_directory = get_template_directory_uri();
	$header_bg = et_get_option( 'vertex_header_bg_image', $template_directory .  '/images/bg.jpg' );

	if ( is_single() || is_page() || 'project' === get_post_type() && has_post_thumbnail() ) {
		if ( ( $et_custom_image = get_post_meta( get_the_ID(), '_et_single_bg_image', true ) ) && '' !== $et_custom_image ) {
			$header_bg = $et_custom_image;
		} else if ( has_post_thumbnail() ) {
			$image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
			$header_bg = $image_attributes[0];
		}
	}
?>
	<style>
		#top-area, #pre-footer { background-image: url(<?php echo esc_html( $header_bg ); ?>); }
	</style>
<?php
}
add_action( 'wp_head', 'et_attach_bg_images' );

function et_vertex_customize_register( $wp_customize ) {
	$google_fonts = et_get_google_fonts();

	$font_choices = array();
	$font_choices['none'] = 'Default Theme Font';
	foreach ( $google_fonts as $google_font_name => $google_font_properties ) {
		$font_choices[ $google_font_name ] = $google_font_name;
	}

	$wp_customize->remove_section( 'title_tagline' );
	$wp_customize->remove_section( 'background_image' );

	$wp_customize->add_section( 'et_google_fonts' , array(
		'title'		=> __( 'Fonts', 'Vertex' ),
		'priority'	=> 50,
	) );

	$wp_customize->add_section( 'et_color_schemes' , array(
		'title'       => __( 'Schemes', 'Vertex' ),
		'priority'    => 60,
		'description' => __( 'Note: Color settings set above should be applied to the Default color scheme.', 'Vertex' ),
	) );

	$wp_customize->add_setting( 'et_vertex[link_color]', array(
		'default'		=> '#4bb6f5',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'et_vertex[link_color]', array(
		'label'		=> __( 'Link Color', 'Vertex' ),
		'section'	=> 'colors',
		'settings'	=> 'et_vertex[link_color]',
	) ) );

	$wp_customize->add_setting( 'et_vertex[font_color]', array(
		'default'		=> '#959494',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'et_vertex[font_color]', array(
		'label'		=> __( 'Main Font Color', 'Vertex' ),
		'section'	=> 'colors',
		'settings'	=> 'et_vertex[font_color]',
	) ) );

	$wp_customize->add_setting( 'et_vertex[accent_color_1]', array(
		'default'		=> '#25383b',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'et_vertex[accent_color_1]', array(
		'label'		=> __( 'Accent Color #1', 'Vertex' ),
		'section'	=> 'colors',
		'settings'	=> 'et_vertex[accent_color_1]',
	) ) );

	$wp_customize->add_setting( 'et_vertex[accent_color_2]', array(
		'default'		=> '#c24c4c',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'et_vertex[accent_color_2]', array(
		'label'		=> __( 'Accent Color #2', 'Vertex' ),
		'section'	=> 'colors',
		'settings'	=> 'et_vertex[accent_color_2]',
	) ) );

	$wp_customize->add_setting( 'et_vertex[menu_link]', array(
		'default'		=> '#ffffff',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'et_vertex[menu_link]', array(
		'label'		=> __( 'Menu Links Color', 'Vertex' ),
		'section'	=> 'colors',
		'settings'	=> 'et_vertex[menu_link]',
	) ) );

	$wp_customize->add_setting( 'et_vertex[menu_link_active]', array(
		'default'		=> '#ffffff',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'et_vertex[menu_link_active]', array(
		'label'		=> __( 'Active Menu Link Color', 'Vertex' ),
		'section'	=> 'colors',
		'settings'	=> 'et_vertex[menu_link_active]',
	) ) );

	$wp_customize->add_setting( 'et_vertex[heading_font]', array(
		'default'		=> 'none',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options'
	) );

	$wp_customize->add_control( 'et_vertex[heading_font]', array(
		'label'		=> __( 'Header Font', 'Vertex' ),
		'section'	=> 'et_google_fonts',
		'settings'	=> 'et_vertex[heading_font]',
		'type'		=> 'select',
		'choices'	=> $font_choices
	) );

	$wp_customize->add_setting( 'et_vertex[body_font]', array(
		'default'		=> 'none',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options'
	) );

	$wp_customize->add_control( 'et_vertex[body_font]', array(
		'label'		=> __( 'Body Font', 'Vertex' ),
		'section'	=> 'et_google_fonts',
		'settings'	=> 'et_vertex[body_font]',
		'type'		=> 'select',
		'choices'	=> $font_choices
	) );

	$wp_customize->add_setting( 'et_vertex[color_schemes]', array(
		'default'		=> 'none',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	) );

	$wp_customize->add_control( 'et_vertex[color_schemes]', array(
		'label'		=> __( 'Color Schemes', 'Vertex' ),
		'section'	=> 'et_color_schemes',
		'settings'	=> 'et_vertex[color_schemes]',
		'type'		=> 'select',
		'choices'	=> array(
			'none'   => __( 'Default', 'Vertex' ),
			'blue'   => __( 'Blue', 'Vertex' ),
			'green'  => __( 'Green', 'Vertex' ),
			'purple' => __( 'Purple', 'Vertex' ),
			'red'    => __( 'Red', 'Vertex' ),
		),
	) );
}
add_action( 'customize_register', 'et_vertex_customize_register' );

function et_vertex_customize_preview_js() {
	wp_enqueue_script( 'vertex-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), false, true );
}
add_action( 'customize_preview_init', 'et_vertex_customize_preview_js' );

function et_vertex_add_customizer_css(){ ?>
	<style>
		a { color: <?php echo esc_html( et_get_option( 'link_color', '#4bb6f5' ) ); ?>; }

		body { color: <?php echo esc_html( et_get_option( 'font_color', '#959494' ) ); ?>; }

		body, #top-menu, a.action-button, .skills li, .nav li ul, .et_mobile_menu, .description h2, .alt-description h2 { background-color: <?php echo esc_html( et_get_option( 'accent_color_1', '#25383b' ) ); ?>; }

		.tagline, .et-zoom, a.more, .skill-amount, .description p.meta-info, .alt-description p.meta-info, #content-area .wp-pagenavi span.current, #content-area .wp-pagenavi a:hover, .comment-reply-link, .form-submit #submit { background-color: <?php echo esc_html( et_get_option( 'accent_color_2', '#c24c4c' ) ); ?>; }
		.footer-widget li:before, .widget li:before { border-left-color: <?php echo esc_html( et_get_option( 'accent_color_2', '#c24c4c' ) ); ?>; }

		#top-menu a, .et_mobile_menu a { color: <?php echo esc_html( et_get_option( 'menu_link', '#ffffff' ) ); ?>; }

		#top-menu li.current-menu-item > a, .et_mobile_menu li.current-menu-item > a { color: <?php echo esc_html( et_get_option( 'menu_link_active', '#ffffff' ) ); ?>; }

	<?php
		$et_gf_heading_font = sanitize_text_field( et_get_option( 'heading_font', 'none' ) );
		$et_gf_body_font = sanitize_text_field( et_get_option( 'body_font', 'none' ) );

		if ( 'none' != $et_gf_heading_font || 'none' != $et_gf_body_font ) :

			if ( 'none' != $et_gf_heading_font )
				et_gf_attach_font( $et_gf_heading_font, 'h1, h2, h3, h4, h5, h6, #top-area h1, .et-description h2, .et-home-testimonial blockquote p, .description h2, .alt-description h2, blockquote p, #comments, #reply-title, #footer-logo, #et-logo' );

			if ( 'none' != $et_gf_body_font )
				et_gf_attach_font( $et_gf_body_font, 'body, input, textarea, select' );

		endif;
	?>
	</style>
<?php }
add_action( 'wp_head', 'et_vertex_add_customizer_css' );
add_action( 'customize_controls_print_styles', 'et_vertex_add_customizer_css' );

/*
 * Adds color scheme class to the body tag
 */
function et_customizer_color_scheme_class( $body_class ) {
	$color_scheme        = et_get_option( 'color_schemes', 'none' );
	$color_scheme_prefix = 'et_color_scheme_';

	if ( 'none' !== $color_scheme ) $body_class[] = $color_scheme_prefix . $color_scheme;

	return $body_class;
}
add_filter( 'body_class', 'et_customizer_color_scheme_class' );

function et_load_google_fonts_scripts() {
	wp_enqueue_script( 'et_google_fonts', get_template_directory_uri() . '/epanel/google-fonts/et_google_fonts.js', array( 'jquery' ), '1.0', true );
}
add_action( 'customize_controls_print_footer_scripts', 'et_load_google_fonts_scripts' );

function et_load_google_fonts_styles() {
	wp_enqueue_style( 'et_google_fonts_style', get_template_directory_uri() . '/epanel/google-fonts/et_google_fonts.css', array(), null );
}
add_action( 'customize_controls_print_styles', 'et_load_google_fonts_styles' );

/**
 * Removes galleries on single projects, since we display images from all
 * galleries on the bottom of the page
 */
function et_delete_post_gallery( $content ) {
	if ( is_single() && is_main_query() && 'project' === get_post_type() ) :
		$regex = get_shortcode_regex();
		preg_match_all( "/{$regex}/s", $content, $matches );

		// $matches[2] holds an array of shortcodes names in the post
		foreach ( $matches[2] as $key => $shortcode_match ) {
			if ( 'gallery' === $shortcode_match )
				$content = str_replace( $matches[0][$key], '', $content );
		}
	endif;

	return $content;
}
add_filter( 'the_content', 'et_delete_post_gallery' );

if ( ! function_exists( 'et_vertex_post_meta' ) ) :
function et_vertex_post_meta() {
	$postinfo = is_single() ? et_get_option( 'vertex_postinfo2' ) : et_get_option( 'vertex_postinfo1' );

	if ( $postinfo ) :
		if ( ! is_single() ) echo '<p class="meta-info">';
		et_postinfo_meta( $postinfo, et_get_option( 'vertex_date_format', 'M j, Y' ), esc_html__( '0 comments', 'Vertex' ), esc_html__( '1 comment', 'Vertex' ), '% ' . esc_html__( 'comments', 'Vertex' ) );
		if ( ! is_single() ) echo '</p>';
	endif;
}
endif;

if ( ! function_exists( 'et_gallery_images' ) ) :
function et_gallery_images() {
	$output = $images_ids = '';

	if ( function_exists( 'get_post_galleries' ) ) {
		$galleries = get_post_galleries( get_the_ID(), false );

		if ( empty( $galleries ) ) return false;

		foreach ( $galleries as $gallery ) {
			// Grabs all attachments ids from one or multiple galleries in the post
			$images_ids .= ( '' !== $images_ids ? ',' : '' ) . $gallery['ids'];
		}

		$attachments_ids = explode( ',', $images_ids );
		// Removes duplicate attachments ids
		$attachments_ids = array_unique( $attachments_ids );
	} else {
		$pattern = get_shortcode_regex();
		preg_match( "/$pattern/s", get_the_content(), $match );

		if ( empty( $match ) ) return false;

		$atts = shortcode_parse_atts( $match[3] );

		if ( isset( $atts['ids'] ) )
			$attachments_ids = explode( ',', $atts['ids'] );
		else
			return false;
	}

	echo '<ul id="et-projects" class="clearfix">';
	foreach ( $attachments_ids as $attachment_id ) {
		$attachment = get_post( $attachment_id );
		$fullimage_attributes = wp_get_attachment_image_src( $attachment_id, 'full' );

		printf( '<li><a href="%s" class="fancybox" rel="gallery" title="%s">%s<span class="project-description"><span class="et-zoom"></span></span></a></li>',
			esc_url( $fullimage_attributes[0] ),
			esc_attr( $attachment->post_title ),
			wp_get_attachment_image( $attachment_id, 'et-project-thumb' )
		);
	}
	echo '</ul>';

	return $output;
}
endif;

function et_vertex_add_animations( $body_class ) {
	if ( 'on' === et_get_option( 'vertex_animations_on_scroll', 'on' ) )
		$body_class[] = 'et-scroll-animations';

	return $body_class;
}
add_filter( 'body_class', 'et_vertex_add_animations' );

function et_vertex_add_ios_class( $body_class ) {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];

	if ( stripos( $user_agent, 'iPod' ) || stripos( $user_agent, 'iPad' ) || stripos( $user_agent, 'iPhone' ) ) {
		$body_class[] = 'et-ios';
	}

	return $body_class;
}
add_filter( 'body_class', 'et_vertex_add_ios_class' );

if ( ! function_exists( 'et_vertex_action_button' ) ) :
function et_vertex_action_button() {
	if ( ( $action_button_url = et_get_option( 'vertex_action_button_url' ) ) && '' !== $action_button_url )
		printf( '<a class="action-button" href="%s">%s</a>',
			esc_url( $action_button_url ),
			esc_html( et_get_option( 'vertex_action_button_text', __( 'Sign Up Today', 'Vertex' ) ) )
		);
}
endif;