		</div> <!-- .container -->
	</div> <!-- #body-area -->

	<div id="footer-area">
		<div class="container">
			<?php get_sidebar( 'footer' ); ?>

			<div id="footer-bottom" class="clearfix">
			<?php
				$menu_class = 'bottom-nav';
				$footerNav = '';

				if ( function_exists( 'wp_nav_menu' ) ) $footerNav = wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menu_class, 'echo' => false, 'depth' => '1' ) );
				if ( '' == $footerNav ) show_page_menu( $menu_class );
				else echo( $footerNav );
			?>

				<div id="et-social-icons">
				<?php
					$template_directory_uri = get_template_directory_uri();
					if ( 'on' == et_get_option( 'foxy_show_google_icon', 'on' ) ) $social_icons['google'] = array( 'image' => $template_directory_uri . '/images/google.png', 'url' => et_get_option( 'foxy_google_url' ), 'alt' => __( 'Google Plus', 'foxy' ) );
					if ( 'on' == et_get_option( 'foxy_show_facebook_icon','on' ) ) $social_icons['facebook'] = array( 'image' => $template_directory_uri . '/images/facebook.png', 'url' => et_get_option( 'foxy_facebook_url' ), 'alt' => __( 'Facebook', 'foxy' ) );
					if ( 'on' == et_get_option( 'foxy_show_twitter_icon', 'on' ) ) $social_icons['twitter'] = array( 'image' => $template_directory_uri . '/images/twitter.png', 'url' => et_get_option( 'foxy_twitter_url' ), 'alt' => __( 'Twitter', 'foxy' ) );

					$social_icons = apply_filters( 'et_social_icons', $social_icons );

					if ( ! empty( $social_icons ) ) {
						foreach ( $social_icons as $icon ) {
							if ( $icon['url'] )
								printf( '<a href="%s" target="_blank"><img src="%s" alt="%s" /></a>', esc_url( $icon['url'] ), esc_attr( $icon['image'] ), esc_attr( $icon['alt'] ) );
						}
					}
				?>
				</div> <!-- #social-icons -->
			</div> <!-- #footer-bottom -->
		</div> <!-- .container -->
	</div> <!-- #footer-area -->

	<div id="footer-bottom-area" class="container">
		<p id="copyright"><?php printf( __( 'Designed by %1$s | Powered by %2$s', 'Foxy' ), '<a href="http://www.elegantthemes.com" title="Premium WordPress Themes">Elegant Themes</a>', '<a href="http://www.wordpress.org">WordPress</a>' ); ?></p>
	</div>

	<?php wp_footer(); ?>
</body>
</html>