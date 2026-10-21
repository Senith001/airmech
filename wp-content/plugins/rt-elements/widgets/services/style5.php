<div class="service-area <?php echo $animation;?> <?php echo esc_attr($settings['general_section_style']);?>" <?php echo $delay; ?> >  
	<div class="overflow-hidden rounded-20px">
		<div class="relative">
		
			<?php if(!empty($settings['service_image']['url'])) : ?>
				<img  src="<?php echo esc_url($settings['service_image']['url']);?>" alt="service-image"/>
			<?php endif; ?>
		</div>
		<div class="padding40 bg-white relative">
			<?php if($settings['icon']) : ?>
				<div class="sIcon">					
					<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
				</div>
			<?php endif; ?>
			<h3><?php echo wp_kses_post($settings['service-title']); ?></h3>
			<?php if(!empty($settings['service-des'])) : ?>
        		<p class="disc no-bottom"><?php echo wp_kses_post($settings['service-des']); ?></p>
        	<?php endif; ?>
			<div class="spacer-20"></div>
            <?php if(!empty($settings['service-btn'])): ?>
                <a href="<?php echo esc_url($settings['service-url']['url']); ?>" class="btn-main w-100"><?php echo wp_kses_post($settings['service-btn']); ?></a>
            <?php endif; ?>			
		</div>
	</div>
</div>