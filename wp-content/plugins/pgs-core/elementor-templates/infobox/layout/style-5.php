<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing ?>
<div class="pgscore_info_box-inner clearfix">
	<div class="pgscore_info_box-icon">
		<div class="pgscore_info_box-icon-wrap">
			<?php $this->get_templates( "{$this->widget_slug}/content-parts/step", null, array( 'settings' => $settings ) ); ?>
		</div>
	</div>
	<div class="pgscore_info_box-content">
		<div class="pgscore_info_box-content-wrap">
			<div class="pgscore_info_box-content-inner">
				<?php $this->get_templates( "{$this->widget_slug}/content-parts/title", null, array( 'settings' => $settings ) ); ?>
				<?php $this->get_templates( "{$this->widget_slug}/content-parts/description", null, array( 'settings' => $settings ) ); ?>
			</div>
		</div>
	</div>
</div>
