<?php
/**
 * Client Section
 *
 * @package jobscout
 */

if ( ! function_exists( 'jobscout_customize_register_frontpage_client' ) ) :

function jobscout_customize_register_frontpage_client( $wp_customize ){

    $raratheme_companion_activated = jobscout_is_rara_theme_companion_activated();

    /** Client Section */
    $wp_customize->add_section(
        'client_section',
        array(
            'title'    => __( 'Client Section', 'jobscout' ),
            'priority' => 45,
            'panel'    => 'frontpage_settings',
        )
    );

    if( ! $raratheme_companion_activated ){
        $wp_customize->add_setting(
            'homepage_client_section_note',
            array(
                'sanitize_callback' => 'wp_kses_post'
            )
        );
    
        $wp_customize->add_control(
            new JobScout_Note_Control( 
                $wp_customize,
                'homepage_client_section_note',
                array(
                    'section'      => 'client_section', 
                    'description' => sprintf( __( 'Please install/activate the %1$sRaraTheme Companion%2$s Plugin to add "Rara: Client Logo" Widget.', 'jobscout' ), '<a href="' . admin_url( 'themes.php?page=tgmpa-install-plugins' ) . '" target="_blank">', '</a>' ),
                )
            )
        );
    }

    $home_client_settings = $wp_customize->get_section( 'sidebar-widgets-client' );

    if ( ! empty( $home_client_settings ) ) {
        $home_client_settings->panel = 'frontpage_settings';
        $home_client_settings->priority = 45;
        $wp_customize->get_section( 'sidebar-widgets-client' )->title = __( 'Client Section','jobscout' );
        if( ! $raratheme_companion_activated  ) {
            $wp_customize->get_control( 'homepage_client_section_note' )->section  = 'sidebar-widgets-client';
            $wp_customize->get_control( 'homepage_client_section_note' )->priority  = -1;
        }
    }
    /** Client Section Ends */  

}
endif;
add_action( 'customize_register', 'jobscout_customize_register_frontpage_client' );