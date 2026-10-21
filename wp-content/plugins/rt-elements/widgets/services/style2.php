<div class="service-area <?php echo $animation;?> <?php echo $settings['general_section_style'];?> <?php echo esc_attr($settings['icon_bg_style']);?>" <?php echo $delay; ?>>	
	<?php if($settings['icon']) : ?>
		<div class="icon">			
			<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
		</div>
	<?php endif; ?>
	<div class="pl-80">
	<h4><?php echo wp_kses_post($settings['service-title']); ?></h4>
	<?php if(!empty($settings['service-des'])) : ?>
        <p class="disc no-bottom mb-0"><?php echo wp_kses_post($settings['service-des']); ?></p>
    <?php endif; ?>	
	</div>
</div>