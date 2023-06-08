<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package CiyaShop
 */

get_header();

global $ciyashop_options, $ciyashop_blog_sidebar, $ciyashop_blog_layout, $ciyashop_timeline_type;

$ciyashop_blog_sidebar = $ciyashop_options['blog_sidebar'];
if ( ! isset( $ciyashop_blog_sidebar ) || empty( $ciyashop_blog_sidebar ) ) {
	$ciyashop_blog_sidebar = 'right_sidebar';
}

$ciyashop_blog_layout = $ciyashop_options['blog_layout'];
if ( ! isset( $ciyashop_blog_layout ) || empty( $ciyashop_blog_layout ) ) {
	$ciyashop_blog_layout = 'classic';
}

$section_class          = '';
$ciyashop_timeline_type = 'default';
$sidebar_stat           = '';

if ( ( 'left_sidebar' === $ciyashop_blog_sidebar || 'right_sidebar' === $ciyashop_blog_sidebar ) && is_active_sidebar( 'sidebar-1' ) ) {

	$sidebar_stat .= ' with-sidebar';
	$sidebar_stat .= " with-$ciyashop_blog_sidebar";

	if ( 'timeline' === $ciyashop_blog_layout ) {
		$section_class         = 'timeline-sidebar';
		$ciyashop_timeline_type = 'with_sidebar';
	}
}
?>
<div class="<?php echo esc_attr( $section_class ); ?>">
	<div class="row">
		<div class="<?php ciyashop_classes_main_area(); ?>">
			<div id="primary" class="content-area">
				<main id="main" class="site-main">
					<?php
					if ( have_posts() ) :
						get_template_part( 'template-parts/content', 'archive_header' );

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/blog/' . $ciyashop_blog_layout );

						if ( 'timeline' !== $ciyashop_blog_layout ) {
							get_template_part( 'template-parts/posts-pagination' );
						};
					else :

						get_template_part( 'template-parts/content', 'none' );

					endif;
					?>

				</main><!-- #main -->
			</div><!-- #primary -->
		</div>
		<?php
		if ( ( 'left_sidebar' === $ciyashop_blog_sidebar || 'right_sidebar' === $ciyashop_blog_sidebar ) && is_active_sidebar( 'sidebar-1' ) ) {
			get_sidebar();
		}
		?>
	</div>
</div>
<?php
get_footer();
