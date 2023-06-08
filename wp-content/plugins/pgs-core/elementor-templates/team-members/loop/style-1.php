<?php
global $ciyashop_options;

$style       = isset( $settings['style'] ) ? $settings['style'] : '';
$designation = get_post_meta( get_the_ID(), 'designation', true );
?>
<div class="team">
	<div class="team-images">
		<?php
		if ( has_post_thumbnail() ) {
			$thumbnail_src = get_the_post_thumbnail_url( get_the_ID(), 'ciyashop-team-member-thumbnail-v' );
			echo '<img class="img-fluid" src="' . esc_url( $thumbnail_src ) . '">';
		} else {
			$member_img   = array();
			$member_img[] = get_parent_theme_file_uri( '/images/placeholder/team_members/259x482.png' );
			$member_img[] = 259;
			$member_img[] = 482;
			echo '<img class="img-fluid" src="' . esc_url( $member_img[0] ) . '" width="' . esc_attr( $member_img[1] ) . '" height="' . esc_attr( $member_img[2] ) . '" alt="' . esc_attr( get_the_title() ) . '">';
		}
		?>
	</div>
	<div class="team-description">
		<h4><?php echo esc_html( get_the_title() ); ?></h4>
		<?php
		if ( $designation ) {
			?>
			<span><?php echo esc_html( $designation ); ?></span>
			<?php
		}
		?>
	</div>
	<?php $this->get_templates( "{$this->widget_slug}/social-profiles/{$style}", null, array( 'settings' => $settings ) ); ?>
</div>
