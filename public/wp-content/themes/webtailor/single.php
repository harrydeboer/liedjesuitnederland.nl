<?php get_header(); ?>
<main id="main" class="site-main">
<?php while ( have_posts() ) : the_post();
	get_template_part( 'templates/content', 'post' );
endwhile; ?>
<?php get_footer(); ?>
