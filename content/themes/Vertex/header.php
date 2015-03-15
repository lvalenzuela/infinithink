<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php elegant_titles(); ?></title>
	<?php elegant_description(); ?>
	<?php elegant_keywords(); ?>
	<?php elegant_canonical(); ?>

	<?php do_action( 'et_head_meta' ); ?>

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php $template_directory_uri = get_template_directory_uri(); ?>
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( $template_directory_uri . '/js/html5.js"' ); ?>" type="text/javascript"></script>
	<![endif]-->

	<script type="text/javascript">
		document.documentElement.className = 'js';
	</script>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<header id="main-header">
		<div id="top-menu">
			<div class="container clearfix">

<?php
$site_name = get_bloginfo( 'name' );

if ( 'on' === et_get_option( 'vertex_use_site_name', 'on' ) ) {
	$site_logo = $site_name;
} else {
	$logo = ( $user_logo = et_get_option( 'vertex_logo' ) ) && '' != $user_logo
		? $user_logo
		: $template_directory_uri . '/images/logo.png';

	$site_logo = sprintf( '<img src="%s" alt="%s" />',
		esc_attr( $logo ),
		esc_attr( $site_name )
	);
}
?>
				<div id="et-logo">
				<?php
					printf( '<a href="%s">%s</a>',
						esc_url( home_url( '/' ) ),
						$site_logo
					);
				?>
				</div>

				<nav>
				<?php
					$menuClass = 'nav';
					if ( 'on' == et_get_option( 'vertex_disable_toptier' ) ) $menuClass .= ' et_disable_top_tier';
					$primaryNav = '';

					$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );

					if ( '' == $primaryNav ) :
				?>
					<ul class="<?php echo esc_attr( $menuClass ); ?>">
						<?php if ( 'on' == et_get_option( 'vertex_home_link' ) ) { ?>
							<li <?php if ( is_home() ) echo( 'class="current_page_item"' ); ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home','Vertex' ); ?></a></li>
						<?php }; ?>

						<?php show_page_menu( $menuClass, false, false ); ?>
						<?php show_categories_menu( $menuClass, false ); ?>
					</ul>
				<?php
					else :
						echo( $primaryNav );
					endif;
				?>
				</nav>

				<?php do_action( 'et_header_top' ); ?>
			</div> <!-- .container -->
		</div> <!-- #top-menu -->

		<div id="top-area" class="et-animation">
			<div class="container clearfix">

<?php
	$heading = $tagline = '';

	if ( is_home() ) {
		$heading = sprintf( '<a href="%s">%s</a>',
			esc_url( home_url( '/' ) ),
			$site_logo
		);
		$tagline = get_bloginfo( 'description' );
	} elseif( is_tag() ) {
		$heading = esc_html__( 'Posts Tagged &quot;', 'Vertex' ) . single_tag_title( '', false ) . '&quot;';
	} elseif ( is_day() ) {
		$heading = esc_html__( 'Posts made in', 'Vertex' ) . ' ' . get_the_time( 'F jS, Y' );
	} elseif ( is_month() ) {
		$heading = esc_html__( 'Posts made in', 'Vertex' ) . ' ' . get_the_time( 'F, Y' );
	} elseif ( is_year() ) {
		$heading = esc_html__( 'Posts made in', 'Vertex' ) . ' ' . get_the_time( 'Y' );
	} elseif ( is_search() ) {
		$heading = esc_html__( 'Search results for', 'Vertex' ) . ' ' . get_search_query();
	} elseif ( is_category() ) {
		$heading = single_cat_title( '', false );
		$tagline = category_description();
	} elseif ( is_author() ) {
		global $wp_query;
		$curauth = $wp_query->get_queried_object();
		$heading = esc_html__( 'Posts by ', 'Vertex' ) . $curauth->nickname;
	} elseif ( is_page() || is_single() ) {
		$heading = get_the_title();
		if ( is_page() ) {
			$tagline = get_post_meta( get_the_ID(), 'Description', true ) ? get_post_meta( get_the_ID(), 'Description' ,true ) : '';
		} else {
			the_post();
			ob_start();
			et_vertex_post_meta();
			$tagline = ob_get_clean();
			rewind_posts();
		}
	} elseif ( is_tax() ) {
		$heading = single_term_title( '', false );
		$tagline = term_description();
	} elseif ( is_post_type_archive() ) {
		$heading = post_type_archive_title( '', false );
	}
?>
			<?php if ( '' !== $heading ) : ?>
				<h1<?php if ( ! is_home() ) echo ' class="title"'; ?>><?php echo $heading; ?></h1>
			<?php endif; ?>

			<?php if ( '' !== $tagline ) : ?>
				<p class="tagline"><?php echo $tagline; ?></p>
			<?php endif; ?>

				<br />

				<?php if ( is_home() ) et_vertex_action_button(); ?>
			</div> <!-- .container -->
		</div> <!-- #top-area -->
	</header> <!-- #main-header -->