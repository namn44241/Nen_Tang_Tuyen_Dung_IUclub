<?php
/**
 * Testimonial Section
 * 
 * @package JobScout
 */

$section_title  = get_theme_mod( 'testimonial_section_title', __( 'Clients Testimonials', 'jobscout' ) );
$section_desc   = get_theme_mod( 'testimonial_section_subtitle', __( 'We will help you find it. We are your first step to becoming everything you want to be.', 'jobscout' ) );
$ed_testimonial =  get_theme_mod( 'ed_hometestimonial', true );
if( $ed_testimonial && ( $section_title || $section_desc ||  is_active_sidebar( 'testimonial' ) ) ){ ?>
	<section id="testimonial-section" class="testimonial-section">
		<?php if( $section_title || $section_desc ){ ?>
			<div class="container">
				<?php 
					if( $section_title ) echo '<h2 class="section-title">'. esc_html( $section_title ) .'</h2>';
					if( $section_desc ) echo '<div class="section-desc">'. wpautop( wp_kses_post( $section_desc ) ) .'</div>';
				?>
			</div>
		<?php } 
		if( is_active_sidebar( 'testimonial' ) ) { ?>
			<div class="widgets-wrap owl-carousel">
		   		<?php dynamic_sidebar( 'testimonial' ); ?>
		   </div><!-- .widgets-wrap -->
		<?php } ?>

	</section> <!-- .testimonial-section -->
	<?php
}