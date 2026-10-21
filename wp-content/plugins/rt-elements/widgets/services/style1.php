<div class="service-area <?php echo $animation;?> <?php echo esc_attr($settings['general_section_style']);?>" <?php echo $delay; ?> >  
	<div class="rounded-20px overflow-hidden <?php echo esc_attr($settings['image_position']);?>">
		<div class="relative">
			<?php if($settings['icon']) : ?>
				<div class="w-70px mb20 top-30px start-30px bg-color-3 rounded-10px absolute">					
					<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
				</div>
			<?php endif; ?>
			<?php if(!empty($settings['service_image']['url'])) : ?>
				<img  src="<?php echo esc_url($settings['service_image']['url']);?>" alt="service-image"/>
			<?php endif; ?>
		</div>
		<div class="padding40 bg-color-3">
			<h4><?php echo wp_kses_post($settings['service-title']); ?></h4>
				<?php if(!empty($settings['service-des'])) : ?>
        		 <p class="disc no-bottom"><?php echo wp_kses_post($settings['service-des']); ?></p>
        		<?php endif; ?> 
			
			<div class="spacer-20"></div>
			<?php if(!empty($settings['service-btn'])): ?>
        		<a href="<?php echo esc_url($settings['service-url']['url']); ?>" class="btn-main"><?php echo wp_kses_post($settings['service-btn']); ?></a>
        	<?php endif; ?>			
		</div>
	</div>
</div>