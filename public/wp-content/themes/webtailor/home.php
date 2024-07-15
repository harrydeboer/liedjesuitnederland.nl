<?php get_header(); ?>
<main id="main" class="site-main">
    <?php
        /* Start the Loop */
        while ( have_posts() ) :
            the_post();
            get_template_part( 'templates/content', 'page' );
        
        endwhile; // End of the loop.
    ?>

    <?php get_footer(); ?>
