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
        update_post_meta(get_the_ID(), 'author', get_the_title());
        echo get_post_meta(get_the_ID(), 'content', true);
        echo '</li>';
    }

    echo '</ul>';
    wp_reset_postdata();
}
?>
<div class="testimonial testimonial-style-3">
    <div class="testimonials owl-carousel owl-theme owl-carousel-options owl-loaded owl-drag" data-owl_options="{&quot;items&quot;:3,&quot;loop&quot;:false,&quot;margin&quot;:5,&quot;autoplay&quot;:true,&quot;autoplayTimeout&quot;:1000,&quot;autoplayHoverPause&quot;:true,&quot;dots&quot;:false,&quot;nav&quot;:true,&quot;smartSpeed&quot;:1000,&quot;navText&quot;:[&quot;<i class=\&quot;fas fa-angle-left fa-2x\&quot;><\/i>&quot;,&quot;<i class=\&quot;fas fa-angle-right fa-2x\&quot;><\/i>&quot;],&quot;responsive&quot;:{&quot;0&quot;:{&quot;items&quot;:1},&quot;480&quot;:{&quot;items&quot;:1},&quot;768&quot;:{&quot;items&quot;:2},&quot;992&quot;:{&quot;items&quot;:3},&quot;1200&quot;:{&quot;items&quot;:3}},&quot;navContainer&quot;:&quot;#testimonials-arrow-7c0f&quot;}">

        <div class="owl-stage-outer">
            <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 505px;">
                <div class="owl-item active" style="width: 500px; margin-right: 5px;">
                    <div class="item">
                        <div class="testimonial-item">
                            <div class="testimonial-content">dsdsds</div>
                            <div class="testimonial-meta">
                                <div class="client-image">
                                    <div>
                                        <div class="author-photo">
                                            <img decoding="async" class="img-responsive rounded-circle" src="https://phoenix.theprogressteam.com/wp-content/themes/phoenix-safe/images/placeholder/testimonials/150x150.png" alt="Author">
                                        </div>
                                    </div>
                                </div>
                                <div class="client-info">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="owl-dots disabled"></div>
    </div>
</div>

<?php get_footer() ?>