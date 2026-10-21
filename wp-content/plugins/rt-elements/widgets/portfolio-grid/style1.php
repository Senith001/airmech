<?php 
    $cat = $settings['portfolio_category'];
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

	if(empty($cat)){
    	$best_wp = new wp_Query(array(
				'post_type'      => 'rt-portfolios',
				'posts_per_page' => $settings['per_page'],								
		));	  
    }   
    else{
    	$best_wp = new wp_Query(array(
				'post_type'      => 'rt-portfolios',
				'posts_per_page' => $settings['per_page'],				
				'tax_query'      => array(
			        array(
						'taxonomy' => 'rt-portfolio-category',
						'field'    => 'slug', //can be set to ID
						'terms'    => $cat //if field is ID you can reference by cat/term number
			        ),
			    )
		));	  
    }
 
	while($best_wp->have_posts()): $best_wp->the_post();		
		
		$location      = get_post_meta( get_the_ID(), 'location', true );				
	?>

	<div class="col-lg-<?php echo esc_html($settings['portfolio_columns']);?> col-md-6 col-xs-1 grid-item">
		<div class="dynamic">
			<?php if(has_post_thumbnail()): ?>
				
				<a href="<?php the_permalink(); ?>" class="d-block hover">
					<div class="relative overflow-hidden rounded-20px">
						<div class="absolute start-0 w-100 abs-middle fs-36 text-white text-center porfolio_icon">
							<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
						</div>
						<?php  the_post_thumbnail($settings['thumbnail_size']);?>
					</div>
				</a>
            <?php endif;?>
            <div class="portfolio-content">  		
				<?php if(get_the_title()):?>
					<h4 class="p-title mt-3 mb-0"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
				<?php endif;?>		
				<p class="mb-0"> <?php echo esc_html($location);?> </p>	
            </div>
        
    	</div>		
    </div>		
	<?php
	endwhile;
	wp_reset_query(); 
 ?>  
