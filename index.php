<!DOCTYPE html>
<html lang="en">
	<head></head>
	<body>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	 		<?php the_content(); ?>

	<?php endwhile; else : ?>


 		<!-- REALLY stop The Loop. -->
 	<?php endif; ?>
	</body>
</html>