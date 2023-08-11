<?php

/*
Template name: Page Template : Test
*/

?>

<?php get_header() ?>


<?php
$args = array(
    'post_type' => 'testimonials',
    'posts_per_page' => -1
);
$the_query = new WP_Query($args);
if ($the_query->have_posts()) {
    echo '<ul>';
    while ($the_query->have_posts()) {
        $the_query->the_post();
        echo '<li>';
        echo get_the_title();
        echo '<br>';
        echo get_the_content();

        echo '</li>';
    }

    echo '</ul>';
    wp_reset_postdata();
}
?>


<?php get_footer() ?>




