<?php
/**
 * JobScout Widget Areas
 * 
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * @package JobScout
 */

function jobscout_widgets_init(){    
    $sidebars = array(
        'sidebar'   => array(
            'name'        => __( 'Sidebar', 'jobscout' ),
            'id'          => 'sidebar', 
            'description' => __( 'Default Sidebar', 'jobscout' ),
        ),
        'cta' => array(
            'name'        => __( 'Call To Action Section', 'jobscout' ),
            'id'          => 'cta', 
            'description' => __( 'Add "Rara: Call To Action" widget for Call to Action section.', 'jobscout' ),
        ),
        'testimonial' => array(
            'name'        => __( 'Testimonial Section', 'jobscout' ),
            'id'          => 'testimonial', 
            'description' => __( 'Add "Rara: Testimonial" widget for testimonial section.', 'jobscout' ),
        ),
        'client' => array(
            'name'        => __( 'Client Section', 'jobscout' ),
            'id'          => 'client', 
            'description' => __( 'Add "Rara Client Logo" widget for client section.', 'jobscout' ),
        ),
        'footer-one'=> array(
            'name'        => __( 'Footer One', 'jobscout' ),
            'id'          => 'footer-one', 
            'description' => __( 'Add footer one widgets here.', 'jobscout' ),
        ),
        'footer-two'=> array(
            'name'        => __( 'Footer Two', 'jobscout' ),
            'id'          => 'footer-two', 
            'description' => __( 'Add footer two widgets here.', 'jobscout' ),
        ),
        'footer-three'=> array(
            'name'        => __( 'Footer Three', 'jobscout' ),
            'id'          => 'footer-three', 
            'description' => __( 'Add footer three widgets here.', 'jobscout' ),
        ),
        'footer-four'=> array(
            'name'        => __( 'Footer Four', 'jobscout' ),
            'id'          => 'footer-four', 
            'description' => __( 'Add footer four widgets here.', 'jobscout' ),
        )
    );
    
    foreach( $sidebars as $sidebar ){
        register_sidebar( array(
    		'name'          => esc_html( $sidebar['name'] ),
    		'id'            => esc_attr( $sidebar['id'] ),
    		'description'   => esc_html( $sidebar['description'] ),
    		'before_widget' => '<section id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</section>',
    		'before_title'  => '<h2 class="widget-title" itemprop="name">',
    		'after_title'   => '</h2>',
    	) );
    }
}
add_action( 'widgets_init', 'jobscout_widgets_init' );