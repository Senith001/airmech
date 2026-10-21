<div class="col-lg-<?php echo esc_html($settings['product_columns']);?>  col-md-6 col-sm-6 col-12">
	<div class="bg-color-3 relative hover overflow-hidden rounded-20px productItem">
		<div class="absolute w-100 h-100 padding30 bg-light hover-op-1 hover-mt-40 z-2">
			<h4 class="p-title"><?php the_title();?></h4>
			<p class="p-desc"><?php echo wp_kses_post(wp_trim_words(get_the_excerpt(), $limit, '')); ?></p>
			<?php if($settings['show_btn'] =='yes'): ?>
				<a class="btn-main" href="<?php the_permalink()?>"><?php echo $settings['btn_text']?></a>
			<?php endif;?>
		</div>
		<div class="text-center py-3">
		<?php if($settings['product_badge_show'] =='show'): ?>
			<div class="p-badge absolute end-0 m-4 my-2 d-inline bg-color-2 text-light fw-bold px-3 rounded-20px">
				<?php echo $product_sell_badge ;?>
			</div>
		<?php endif;?>
			<?php if(has_post_thumbnail()): ?>
				<?php  the_post_thumbnail($settings['thumbnail_size'],array('class' => 'w-80'))?>
			<?php endif;?>
			<h4 class="p-title mt-2"><?php the_title();?></h4>
		</div>
	</div>
</div>
