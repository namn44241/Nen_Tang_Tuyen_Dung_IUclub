<?php
/**
 * SEO Settings
 *
 * @package jobscout
 */
if ( ! function_exists( 'jobscout_customize_register_general_seo' ) ) :

function jobscout_customize_register_general_seo( $wp_customize ) {
    
    /** SEO Settings */
    $wp_customize->add_section(
        'seo_settings',
        array(
            'title'    => __( 'SEO Settings', 'jobscout' ),
            'priority' => 30,
            'panel'    => 'general_settings',
        )
    );
    
    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_post_update_date', 
        array(
            'default'           => true,
            'sanitize_callback' => 'jobscout_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new JobScout_Toggle_Control( 
			$wp_customize,
			'ed_post_update_date',
			array(
				'section'     => 'seo_settings',
				'label'	      => __( 'Enable Last Update Post Date', 'jobscout' ),
                'description' => __( 'Enable to show last updated post date on listing as well as in single post.', 'jobscout' ),
			)
		)
	);
    /** SEO Settings Ends */
    
}
endif;
add_action( 'customize_register', 'jobscout_customize_register_general_seo' );