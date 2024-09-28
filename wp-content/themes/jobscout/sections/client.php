<?php
/**
 * Client Section
 * 
 * @package JobScout
 */

if( is_active_sidebar( 'client' ) ){ ?>
	<section id="client-section" class="client-section">
		<div class="container">
	    	<?php dynamic_sidebar( 'client' ); ?>
		</div>
	</section> <!-- .bg-cta-section -->
<?php
}