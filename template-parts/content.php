<?php
/**
 * Entry in a plain list, for content types without their own archive template.
 *
 * @package Sashwell_Lite
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<?php the_excerpt(); ?>
</article>
