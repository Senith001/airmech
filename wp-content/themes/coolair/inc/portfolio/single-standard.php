
<div class="reactheme-porfolio-details"> 
	<?php while ( have_posts() ) : the_post(); ?>    
	<div class="project-desc">       
			<?php  the_content(); ?>
	</div>
	<?php endwhile; wp_reset_query();?>	
</div>
