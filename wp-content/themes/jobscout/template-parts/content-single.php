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
         * 
         * @hooked jobscout_entry_header - 10
         * @hooked jobscout_post_thumbnail - 15
        */
        do_action( 'jobscout_before_single_post_entry_content' );
    

        /**
         * @hooked jobscout_entry_content - 15
         * @hooked jobscout_entry_footer  - 20
        */
        do_action( 'jobscout_single_post_entry_content' );
        
    ?>
</article><!-- #post-<?php the_ID(); ?> -->
