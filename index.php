<?php
// Fallback — Elementor handles actual rendering.
// This file is required by WordPress but rarely used when Elementor is active.
get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
endif;

get_footer();
