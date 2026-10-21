<?php
$cat = $settings['portfolio_category'];
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

if (empty($cat)) {
	$best_wp = new wp_Query(array(
		'post_type'      => 'rt-portfolios',
		'posts_per_page' => $settings['per_page'],
	));
} else {
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

$x = 1;
$details_btn_text = !empty($settings['details_btn_text']) ? $settings['details_btn_text'] : 'Case Details';
while ($best_wp->have_posts()) : $best_wp->the_post();

	$content       = get_the_content();
	$client        = get_post_meta(get_the_ID(), 'client', true);
	$location      = get_post_meta(get_the_ID(), 'location', true);
	$surface_area  = get_post_meta(get_the_ID(), 'surface_area', true);
	$created       = get_post_meta(get_the_ID(), 'created', true);
	$date          = get_post_meta(get_the_ID(), 'date', true);
	$project_value = get_post_meta(get_the_ID(), 'project_value', true);

	$cats_show = get_the_term_list($best_wp->ID, 'rt-portfolio-category', ' ', '<span class="separator">,</span> ');
	$termsString = ""; //initialize the string that will contain the terms
	$termsSlug   = "";
	$blank = '';

	?>
	<div class="col-lg-<?php echo esc_html($settings['portfolio_columns']);?> col-md-6">
		<div class="single-portfolio-box-style style-five dynamic">
			<a href="<?php the_permalink() ?>" class="thumbnail">
				<?php if (has_post_thumbnail()) : ?>
					<?php the_post_thumbnail($settings['thumbnail_size']); ?>
				<?php endif; ?>
			</a>
			<div class="inner-content">
				<div class="left-content">
					<p class="pre"><?php echo $cats_show; ?></p>
					<a href="<?php the_permalink(); ?>">
						<h3 class="title animated fadeIn"><?php the_title(); ?></h3>
					</a>
					<?php if($settings['des_show'] == 'true') : ?>
						<p class="desc">
							<?php 
								$word_count = $settings['des_word_show'];
								$ex_post = get_the_ID();
								$excerpt = get_the_excerpt($ex_post);
								echo wp_trim_words($excerpt, $word_count, '');							
							?>
						</p>	
						<?php
					else: $blank;
					endif; ?>
					
					<?php if(!empty($settings['btn_text'])): ?>
						<a href="<?php the_permalink(); ?>" class="rts-btn btn-primary-4"><?php echo esc_html($settings['btn_text']); ?> <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

<?php
	$x++;
endwhile;
wp_reset_query();
?>