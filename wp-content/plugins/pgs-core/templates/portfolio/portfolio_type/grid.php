<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_portfolio'] );
extract( $atts );

$the_query = $pgscore_shortcodes['pgscore_portfolio']['the_query'];
?>
<div class="row">
	<?php
	if ( $the_query->have_posts() ) :

		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			?>
			<div class="portfolio-grid-column-item">
			<?php pgscore_get_shortcode_templates( 'portfolio/loop/content' ); ?>
			</div>
			<?php

		endwhile;

		/* Restore original Post Data */
		wp_reset_postdata();

	endif;
	?>
</div>
