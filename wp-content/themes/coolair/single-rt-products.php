<?php

/*products single page template
*/
get_header(); 
?>

<div class="reactheme-products-details"> 
	<?php while ( have_posts() ) : the_post(); ?>    
	<div class="product-desc">       
			<?php  the_content(); ?>
	</div>
	<?php endwhile; wp_reset_query();?>	
</div>

<?php
get_footer();
?>