<?php get_header(); ?>

<div id="content-area">
	<div class="container clearfix">
		<div id="main-area">
			<?php get_template_part( 'includes/no-results', '404' ); ?>
		</div> <!-- #main-area -->

		<?php get_sidebar(); ?>
	</div> <!-- .container -->
</div> <!-- #content-area -->

<?php get_footer(); ?>