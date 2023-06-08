<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$form_id           = uniqid( 'pgscore_newsletter_form_' );
$title             = isset( $settings['title'] ) ? $settings['title'] : ''; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$style             = isset( $settings['style'] ) ? $settings['style'] : 'style-1';
$button_type       = isset( $settings['button_type'] ) ? $settings['button_type'] : 'dark';
$description       = isset( $settings['description'] ) ? $settings['description'] : '';
$bg_type           = isset( $settings['bg_type'] ) ? $settings['bg_type'] : 'light';
$content_alignment = isset( $settings['content_alignment'] ) ? $settings['content_alignment'] : 'left';
$newsletter_design = isset( $settings['newsletter_design'] ) ? $settings['newsletter_design'] : 'design-1';

$this->add_render_attribute( 'pgscore_newsletter', 'class', 'newsletter-wrapper newsletter-' . $style );
if ( 'style-1' === $style ) {
	$this->add_render_attribute( 'pgscore_newsletter', 'class', 'newsletter-' . $newsletter_design );
	$this->add_render_attribute( 'pgscore_newsletter', 'class', 'pgscore_newsletter-content-alignment-' . $content_alignment );
} elseif ( 'style-2' === $style ) {
	$this->add_render_attribute( 'pgscore_newsletter', 'class', 'pgscore_newsletter-content-alignment-' . $content_alignment );
	$this->add_render_attribute( 'pgscore_newsletter', 'class', 'newsletter-bg-type-' . $bg_type );
} elseif ( 'style-3' === $style ) {
	$this->add_render_attribute( 'pgscore_newsletter', 'class', 'newsletter-button-' . $button_type );
}
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_newsletter' ); ?>>
		<?php
		if ( 'style-1' === $style || 'style-2' === $style ) {
			if ( $title ) {
				?>
				<h4 class="newsletter-title"><?php echo esc_html( $title ); ?></h4>
				<?php
			}
			?>
			<div class="newsletter">
				<?php
				if ( $description ) {
					?>
					<p><?php echo esc_html( $description ); ?></p>
					<?php
				}
				?>
				<div class="section-field">
					<div class="field-widget clearfix">
						<form class="newsletter_form" id="<?php echo esc_attr( $form_id ); ?>">
							<div class="input-area">
								<input type="text" class="placeholder newsletter-email" name="newsletter_email" placeholder="<?php echo esc_attr__( 'Enter your email', 'pgs-core' ); ?>">
							</div>
							<div class="button-area">
								<span class="input-group-btn">
									<button class="btn btn-icon newsletter-mailchimp submit" type="submit" data-form-id="<?php echo esc_attr( $form_id ); ?>"><?php echo esc_html__( 'Subscribe', 'pgs-core' ); ?></button>
								</span>
								<span class="newsletter-spinner spinimg-<?php echo esc_attr( $form_id ); ?>"></span>
							</div>
							<p class="newsletter-msg"></p>
						</form>
					</div>
				</div>
			</div>
			<?php
		} elseif ( 'style-3' === $style ) {
			?>
			<div class="row align-items-center">
				<div class="col-md-6">
					<div class="newslatter-text">
						<?php
						if ( $title ) {
							?>
							<h4 class="newsletter-title"><?php echo esc_html( $title ); ?></h4>
							<?php
						}
						if ( $description ) {
							?>
							<p><?php echo esc_html( $description ); ?></p>
							<?php
						}
						?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="newslatter-form">
						<form class="newsletter_form" id="<?php echo esc_attr( $form_id ); ?>">
							<div class="input-area">
								<input type="text" class="placeholder newsletter-email" name="newsletter_email" placeholder="<?php echo esc_attr__( 'Enter your email', 'pgs-core' ); ?>">
							</div>
							<div class="button-area">
								<span class="input-group-btn">
									<button class="btn btn-icon newsletter-mailchimp submit" type="submit" data-form-id="<?php echo esc_attr( $form_id ); ?>"><?php echo esc_html__( 'Subscribe', 'pgs-core' ); ?></button>
								</span>
								<span class="newsletter-spinner spinimg-<?php echo esc_attr( $form_id ); ?>"></span>
							</div>
							<p class="newsletter-msg"></p>
						</form>
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>
