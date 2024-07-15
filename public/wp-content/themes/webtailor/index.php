<?php get_header(); ?>
	<main id="main" class="site-main">
		<?php if ( have_posts() ) {

			// Load posts loop.
			while ( have_posts() ) {
				the_post();
				get_template_part( 'templates/content' );
			}
			} else {
			echo "<p>Helaas</p>";
			}
			?>

	</main><!-- .site-main -->
<?php get_footer(); ?>
