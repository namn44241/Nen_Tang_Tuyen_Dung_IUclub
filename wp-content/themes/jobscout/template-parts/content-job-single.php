<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package JobScout
 */
 ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php 
		/**
         * @hooked jobscout_get_single_job_title - 10
         * @hooked jobscout_entry_content    - 15
        */
        do_action( 'jobscout_before_single_job_content' );
	?>
</article> <!-- #article -->