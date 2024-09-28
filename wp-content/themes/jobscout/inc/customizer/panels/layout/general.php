<?php
/**
 * General Layout Settings
 *
 * @package jobscout
 */
if ( ! function_exists( 'jobscout_customize_register_layout_general' ) ) :

function jobscout_customize_register_layout_general( $wp_customize ) {
    
    /** Home Page Layout Settings */
    $wp_customize->add_section(
        'general_layout_settings',
        array(
            'title'    => __( 'General Sidebar Layout', 'jobscout' ),
            'priority' => 55,
            'panel'    => 'layout_settings',
        )
    );
    
    /** Page Sidebar layout */
    $wp_customize->add_setting( 
        'page_sidebar_layout', 
        array(
            'default'           => 'right-sidebar',
            'sanitize_callback' => 'jobscout_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
		new JobScout_Radio_Image_Control(
			$wp_customize,
			'page_sidebar_layout',
			array(
				'section'	  => 'general_layout_settings',
				'label'		  => __( 'Page Sidebar Layout', 'jobscout' ),
				'description' => __( 'This is the general sidebar layout for pages. You can override the sidebar layout for individual page in repective page.', 'jobscout' ),
				'choices'	  => array(
					'no-sidebar'    => get_template_directory_uri() . '/images/1c.jpg',
					'left-sidebar'  => get_template_directory_uri() . '/images/2cl.jpg',
                    'right-sidebar' => get_template_directory_uri() . '/images/2cr.jpg',
				)
			)
		)
	);
    
    /** Post Sidebar layout */
    $wp_customize->add_setting( 
        'post_sidebar_layout', 
        array(
            'default'           => 'right-sidebar',
            'sanitize_callback' => 'jobscout_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
		new JobScout_Radio_Image_Control(
			$wp_customize,
			'post_sidebar_layout',
			array(
				'section'	  => 'general_layout_settings',
				'label'		  => __( 'Post Sidebar Layout', 'jobscout' ),
				'description' => __( 'This is the general sidebar layout for posts & custom post. You can override the sidebar layout for individual post in repective post.', 'jobscout' ),
				'choices'	  => array(
					'no-sidebar'    => get_template_directory_uri() . '/images/1c.jpg',
					'left-sidebar'  => get_template_directory_uri() . '/images/2cl.jpg',
                    'right-sidebar' => get_template_directory_uri() . '/images/2cr.jpg',
				)
			)
		)
	);
    
    /** Post Sidebar layout */
    $wp_customize->add_setting( 
        'layout_style', 
        array(
            'default'           => 'right-sidebar',
            'sanitize_callback' => 'jobscout_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
		new JobScout_Radio_Image_Control(
			$wp_customize,
			'layout_style',
			array(
				'section'	  => 'general_layout_settings',
				'label'		  => __( 'Default Sidebar Layout', 'jobscout' ),
				'description' => __( 'This is the general sidebar layout for whole site.', 'jobscout' ),
				'choices'	  => array(
					'no-sidebar'    => get_template_directory_uri() . '/images/1c.jpg',
                    'left-sidebar'  => get_template_directory_uri() . '/images/2cl.jpg',
                    'right-sidebar' => get_template_directory_uri() . '/images/2cr.jpg',
				)
			)
		)
	);
    
}
endif;
add_action( 'customize_register', 'jobscout_customize_register_layout_general' );